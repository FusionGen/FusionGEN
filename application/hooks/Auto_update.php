<?php

/**
 * @package FusionGen
 * @author  Err0r
 * @link    http://fusiongen.net
 */
 
use VisualAppeal\AutoUpdate;

class Auto_update
{
    private $CI;
    private $db;
    private $update;
    private $update_url;
    private $version;
    private $cache_file;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->update_url = 'https://update.fusiongen.net';
        $this->version = $this->CI->config->item('FusionGENVersion');
        $this->cache_file = FCPATH . 'application/cache/updater.cache';
    }
    
    function run()
    {
        // The file path you want to check
        $file_path = APPPATH . 'logs/update.log';

        if (file_exists($file_path) && is_writable(dirname($file_path)))
        {
            // Get the file size in bytes
            $file_size = filesize($file_path);

            // Check if the file size is greater than 5MB (5 * 1024 * 1024 bytes)
            if ($file_size > 5242880)
            {
                // Delete the file
                unlink($file_path);
            }
        }

        if (!file_exists($this->cache_file))
        {
            if (!is_writable(dirname($this->cache_file)))
            {
                log_message('error', 'Cannot create version cache file. Directory is not writable.');
            }

            touch($this->cache_file);

            if (!file_exists($this->cache_file))
            {
                die('Error: Cannot create version cache file. Unknown error occurred.');
            }
        }

        $check_interval = 3600; // 1 hour
        $check_update = time() - filemtime($this->cache_file) < $check_interval;

        // Check if it's time to check for updates
        if (file_exists($this->cache_file) && !$check_update && !$this->CI->input->is_ajax_request())
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->update_url . '/update.json');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response !== false)
            {
                $this->install_updates();
            } else {
                log_message('error', 'Updater: Response failed');
            }
        }
    }

    private function check_updates()
    {
        $this->update = new AutoUpdate(FCPATH . 'temp', FCPATH . '', 60);

        $this->update->setCurrentVersion($this->version);

        $this->update->setUpdateUrl($this->update_url);

        $logger = new \Monolog\Logger("default");
        $logger->pushHandler(new Monolog\Handler\StreamHandler(APPPATH . '/logs/update.log'));
        $this->update->setLogger($logger);
    }

    private function install_updates()
    {
        $this->check_updates();

        if ($this->update->checkUpdate() == false)
        {
            log_message('error', 'No update available. Next check in 1 hour.');
            touch($this->cache_file);
        }
        else
        {
            if ($this->update->newVersionAvailable())
            {
                $simulate = true;
    
                $checkUpdate = $this->update->checkUpdate();
    
                $simulate = $this->update->update($simulate);
                $simulate_result = $this->update->getSimulationResults();
    
                if (!$simulate_result)
                {
                    log_message('error', 'Simulation successful');
                    $simulate = false;
                    $update = $this->update->update($simulate);
    
                    if ($update === true)
                    {
                        $this->installSql();
                    }
                }
                else
                {
                    log_message('error', 'New update available but could not be installed!');
                }
    
                $this->delete_files();
    
                touch($this->cache_file);
            }
        }
    }

    private function installSql()
    {
        $tempDBFolder = FCPATH . "/temp/db";

        //Get all Files from temp db folder
        foreach (scandir($tempDBFolder) as $file)
        {
            // Set line to collect lines that wrap
            $templine = '';

            //Check if file
            if (is_file($tempDBFolder . "/" . $file))
            {
                //Check if file extension is sql
                if (strtoupper(pathinfo(FCPATH . "/temp/db/" . $file)["extension"]) === "SQL")
                {
                    $lines = file($tempDBFolder . "/" . $file);

                    // Loop through each line
                    foreach ($lines as $line)
                    {
                        // Skip it if it's a comment
                        if (substr($line, 0, 2) == '--' || $line == '')
                        {
                            continue;
                        }

                        // Add this line to the current templine we are creating
                        $templine .= $line;

                        // If it has a semicolon at the end, it's the end of the query so can process this templine
                        if (substr(trim($line), -1, 1) == ';')
                        {
                            // Perform the query
                            $this->CI->db->query($templine);

                            // Reset temp variable to empty
                            $templine = '';
                        }
                    }
                }
            }
        }
    }

    private function delete_files()
    {
        $file = FCPATH . 'temp/files_to_delete.json';

        // Verify that the JSON file exists
        if (file_exists($file))
        {
            $json = file_get_contents($file);
            $file_paths = json_decode($json, true);

            // Check that the array is not empty
            if (!empty($file_paths))
            {
                // Check each path and delete the file if it exists
                foreach ($file_paths as $file_path)
                {
                    if (file_exists($file_path))
                    {
                        if (is_writable($file_path))
                        {
                            unlink(FCPATH . $file_path);
                        } else {
                            // The file cannot be deleted, go to the next one
                            continue;
                        }
                    }
                }
            }

            unlink($file);
        }
    }
}
