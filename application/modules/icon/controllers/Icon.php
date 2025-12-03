<?php

class Icon extends MX_Controller
{
    /**
     * Get an item's icon display name and cache it
     *
     * @param  Int $realm
     * @param  Int $item
     * @return String
     */
    public function get($realm = false, $item = false)
    {
        // Check if item ID and realm is valid
        if ($item != false && is_numeric($item) && $realm != false)
        {
            // check if item is in cache
            $item_in_cache = $this->get_icon_cache($item);

            if ($item_in_cache)
            {
                $icon = $item_in_cache;
                die($icon);
            } else {
                // check if item is in database
                $item_in_db = $this->get_icon_db($item);

                if ($item_in_db)
                {
                    $icon = $item_in_db;
                    die($icon);
                } else {
                    // check if item is on Wowhead
                    $item_wowhead = $this->get_icon_wowhead($item);

                    if ($item_wowhead)
                    {
                        $icon = $item_wowhead;
                        die($icon);
                    } else {
                        $icon = "inv_misc_questionmark";
                        die($icon);
                    }
                }
            }
        }
    }

    /**
     * Check if item icon name is in cache
     *
     * @param  Int $item
     * @return String
     */
    private function get_icon_cache($item)
    {
        $cache = $this->cache->get("items/display_iconname_" . $item);

        // can we use the cache?
        if ($cache !== false)
        {
            $name = $cache;
        }
        else
        {
            return false;
        }

        return $name;
    }

    /**
     * Check if item icon name is in database and cache it
     *
     * @param  Int $item
     * @return String
     */
    private function get_icon_db($item)
    {
        // Get the item ID
        $query = $this->db->query("SELECT icon FROM item_icons WHERE item_id = ? LIMIT 1", [$item]);

        // Check for results
        if ($query->num_rows() > 0)
        {
            $row = $query->result_array();

            $name = $row[0]['icon'];
            
            // save to cache
            $this->cache->save("items/display_iconname_" . $item, $name);
        }
        else
        {
            return false;
        }

        return $name;
    }

    private function get_icon_wowhead($item)
    {
        // Get the item XML data using cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.wowhead.com/item=" . $item . "&xml");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.4472.124 Safari/537.36');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $xml = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (version_compare(phpversion(), '8.5', '<')) {
            curl_close($ch);
        }

        // Check if request was successful
        if ($httpCode !== 200 || $xml === false)
        {
            return false;
        }

        $itemData = $this->xmlToArray($xml);

        if (!isset($itemData['error']) && isset($itemData['item']['icon']))
        {
            $icon = $itemData['item']['icon'];

            // Make sure icon is valid and not an array
            if (!empty($icon) && !is_array($icon))
            {
                // Check if not in DB already
                $result = $this->db->query("SELECT COUNT(*) as count FROM item_icons WHERE item_id = ?", [$item])->row();

                if ($result->count == 0)
                {
                    $query = $this->db->query("INSERT INTO item_icons (item_id, icon) VALUES (?, ?)", [$item, $icon]);
                }

                // Save to cache
                $this->cache->save("items/display_iconname_" . $item, $icon);

                return $icon;
            }
        }

        return false;
    }

    /**
     * Convert XML data to an array
     *
     * @param  String $xml
     * @return Array
     */
    private function xmlToArray($xml)
    {
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        $array = json_decode($json, true);

        return $array;
    }
}
