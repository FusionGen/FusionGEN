<?php

class Icon extends MX_Controller
{
	/**
	 * Get an item's icon display name and cache it
	 * @param Int $realm
	 * @param Int $id
	 * @param Int $isDisplayId
	 * @return String
	 */
	public function get($realm = false, $id = false, $isDisplayId = 0)
	{		
		// Check if ID and realm is valid
		if($id != false && is_numeric($id) && $realm != false)
		{
			// It is already a display ID
			if($isDisplayId == 1)
			{
				$icon = $this->getDisplayName($id);
			}
			else
			{
				$displayId = $this->getDisplayId($id, $realm);

				if($displayId != false)
				{
					$icon = $this->getDisplayName($displayId);

					if(substr($icon, 0, 3) == pack("CCC", 0xef, 0xbb, 0xbf))
					{
						$icon = substr($icon, 3);
					}
				}
				else
				{
					$icon = "inv_misc_questionmark";
				}
			}

			die($icon);
		}
	}

	/**
	 * Get the display ID of an item
	 * @param Int $item
	 * @return Int
	 */
	private function getDisplayId($item, $realm)
	{
		$realmObj = $this->realms->getRealm($realm);
		$item = $realmObj->getWorld()->getItem($item);

		return $item['displayid'];
	}

	/**
	 * Get the display name from the raxezdev display ID API
	 * @param Int $displayId
	 * @return String
	 */
	private function getDisplayName($displayId)
	{
		$cache = $this->cache->get("items/display_".$displayId);

		// Can we use the cache?
		if($cache !== false)
		{
			$name = $cache;
		}
		else
		{
			$retailId = $this->findRetailItem($displayId);
			
			if(!$retailId)
			{
				$name = "inv_misc_questionmark";
			}
			else
			{
				$name = $this->getIconName($retailId);

				// In case it wasn't found: show ?-icon
				if(empty($name))
				{
					$name = "inv_misc_questionmark";
				}
			}

			// Make sure to cache
			$this->cache->save("items/display_".$displayId, $name);
		}
		
		return $name;
	}

	private function findRetailItem($id)
	{
		// Get the item ID
		$query = $this->db->query("SELECT entry FROM item_display WHERE displayid=? LIMIT 1", array($id));

		// Check for results
		if($query->num_rows() > 0)
		{
			$row = $query->result_array();

			return $row[0]['entry'];
		}
		else
		{
			return false;
		}
	}

	private function getIconName($item)
	{
		// Get the item XML data
		$xml = file_get_contents("http://www.wowhead.com/item=".$item."&xml");

		// In case it wasn't found: show ?-icon
		if(empty($xml))
		{
			$icon = "inv_misc_questionmark";
		}
		else
		{
			// Convert the data to an array
			$itemData = $this->xmlToArray($xml);

			// Make sure the icon key is set
			$icon = (isset($itemData['item']['icon'])) ? strtolower($itemData['item']['icon']) : "inv_misc_questionmark";
		}

		return $icon;
	}

	/**
	 * Convert XML data to an array
	 * @param String $xml
	 * @return Array
	 */
	private function xmlToArray($xml)
	{
		$xml = simplexml_load_string($xml);
		$json = json_encode($xml);
		$array = json_decode($json, TRUE);

		return $array;
	}
}