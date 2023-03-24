<?php

/**
 * @package FusionGen
 * @author  Jesper Lindström
 * @author  Xavier Geerinck
 * @author  Elliott Robbins
 * @author  Err0r
 * @link    http://fusiongen.net
 */
 
use VisualAppeal\AutoUpdate;

class Tasks
{
    private $CI;
    private $db;
    private $update;
    private $update_url;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->library('dbbackup');
        $this->CI->load->library('user');
        $this->CI->load->model('internal_user_model');
        $this->CI->load->config('backups');

        $this->update_url = 'https://update.fusiongen.net';
        $this->FCPATH = FCPATH;

        if ($this->CI->config->item('auto_backups')) {
            $this->CI->dbbackup->backup();
        }

        /* Start update auto update*/
        $ch = curl_init($this->update_url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);

        if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                case 200:
                case 301:
                     $this->installupdates();
                break;
                default:
                     log_message('error', 'Update URL broken. Check for update not possible');
            }
        }

        curl_close($ch);
        /* End update auto update*/
    }

    private function check_updates()
    {
        $this->update = new AutoUpdate(FCPATH . 'temp', FCPATH . '', 60);

        $this->update->setCurrentVersion($this->CI->config->item('FusionGENVersion'));

        $this->update->setUpdateUrl($this->update_url);
    }

    private function installupdates()
    {

        $this->check_updates();

        if ($this->update->checkUpdate() === false) {
        }

        if ($this->update->newVersionAvailable()) {
            $simulate = false;

            function eachUpdateFinishCallback($updatedVersion)
            {
            }

            $this->update->onEachUpdateFinish('eachUpdateFinishCallback');

            $result = $this->update->update($simulate);

            if ($result === true) {
                $this->installSql();
            } else {
                if ($result = AutoUpdate::ERROR_SIMULATE) {
                }
            }
        } else {
        }
    }

    private function installSql()
    {
        $tempDBFolder = FCPATH . "/temp/db";

        //Get all Files from temp db folder
        foreach (scandir($tempDBFolder) as $file) {
            // Set line to collect lines that wrap
            $templine = '';

            //Check if file
            if (is_file($tempDBFolder . "/" . $file)) {
                //Check if file extension is sql
                if (strtoupper(pathinfo(FCPATH . "/temp/db/" . $file)["extension"]) === "SQL") {
                    $lines = file($tempDBFolder . "/" . $file);

                    // Loop through each line
                    foreach ($lines as $line) {
                        // Skip it if it's a comment
                        if (substr($line, 0, 2) == '--' || $line == '') {
                            continue;
                        }

                        // Add this line to the current templine we are creating
                        $templine .= $line;

                        // If it has a semicolon at the end, it's the end of the query so can process this templine
                        if (substr(trim($line), -1, 1) == ';') {
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
}
