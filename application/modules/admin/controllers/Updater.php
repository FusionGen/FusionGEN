<?php

use VisualAppeal\AutoUpdate;

class Updater extends MX_Controller
{
    private $update_url;
    private $update_details;
    private $update;
    public $message;
    private $fullWriteableList = array();

    public $flush_output = true;

    public function __construct()
    {
        parent::__construct();

        //URL to check update json from
        $this->update_url = 'https://update.fusiongen.net';

        //Base directory to start apllying updates
        $this->FCPATH = FCPATH;

        $this->load->library('administrator');

        require_once('application/libraries/Configeditor.php');
    }

    public function index()
    {
        $this->administrator->setTitle("Updater");

        $system_hostname = gethostname();

        $this->checkWritePermission(".");

        $data = array(
            'url' => $this->template->page_url,
            'version' => $this->administrator->getVersion(),
            'system_hostname' => $system_hostname,
            'server_software' => $_SERVER['SERVER_SOFTWARE'],
            'ApacheModules' => $this->getApacheModules(),
            'php_version' => phpversion(),
            'php_extensions' => $this->getPHPExtensions(),
            'ci_version' => CI_VERSION,
            'allow_url_fopen' => ini_get('allow_url_fopen'),
            'allow_url_include' => ini_get('allow_url_include'),
            'writeableList' => $this->fullWriteableList
        );

        $this->check_updates();
        $data["update"] = array();

        if ($this->update->checkUpdate() === false) {
            $data["update"]["available"] = false;
            $data["update"]["error"] = "Could not check for updates! See log file for details.";
        }

        if ($this->update->newVersionAvailable()) {
            $data["update"]["available"] = true;
            $data["update"]["lates"] = $this->update->getLatestVersion();
            $data["update"]["versions"] = $this->update->getVersionsToUpdate();
        } else {
            $data["update"]["available"] = false;
        }

        $output = $this->template->loadPage("updater.tpl", $data);

        $content = $this->administrator->box('Updater', $output);

        $this->administrator->view($content, false, "modules/admin/js/updater.js");
    }

    public function getApacheModules()
    {
        if (function_exists('apache_get_modules')) {
            $modules = apache_get_modules();
            return $modules;
        }
    }

    public function getPHPExtensions()
    {
        $extensions = get_loaded_extensions();
        return $extensions;
    }

    public function check_updates()
    {
        $this->update = new AutoUpdate(FCPATH . 'temp', FCPATH . '', 60);

        $this->update->setCurrentVersion($this->administrator->getVersion());

        $this->update->setUpdateUrl($this->update_url);

        $logger = new \Monolog\Logger("default");
        $logger->pushHandler(new Monolog\Handler\StreamHandler(APPPATH . '/logs/update.log'));
        $this->update->setLogger($logger);
    }

    public function install_updates()
    {
        $this->check_updates();

        if ($this->update->checkUpdate() === false) {
            $this->_flush('Could not check for updates! See log file for details.');
        }

        if ($this->update->newVersionAvailable()) {
            $simulate = false;

            function eachUpdateFinishCallback($updatedVersion)
            {
                echo '<h4>Version ' . $updatedVersion . ' installed succesful</h4>';
            }
            $this->update->onEachUpdateFinish('eachUpdateFinishCallback');

            $result = $this->update->update($simulate);

            if ($result === true) {
                $this->installSql();
                $this->_flush('<h4 class="h4 fw-bold text-primary">Update successful!</h4>');
            } else {
                $this->_flush('Update failed: ' . $result . '!');

                if ($result = AutoUpdate::ERROR_SIMULATE) {
                    $this->_flush("<pre>" . var_dump($this->update->getSimulationResults()) . "</pre>");
                }
            }
        } else {
            $this->_flush("Your CMS is up to date! Hooooooooorrraaaay!");
        }

        die();
    }

    private function installSql()
    {
        $this->_flush("<h4>Install SQL...</h4>");
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
                            $this->db->query($templine);

                            // Reset temp variable to empty
                            $templine = '';
                        }
                    }

                    if (!unlink($tempDBFolder . "/" . $file)) {
                        $this->_flush("Unable to delete file: " . $tempDBFolder . "/" . $file);
                    }

                    $this->_flush("SQL File installed: " . $file);
                }
            }
        }
    }

    public function check_ajax_updates()
    {
        $this->check_updates();
        $autoUpdate = $this->input->post("auto_update");

        if ($this->update->checkUpdate() === false) {
            die(json_encode(array("updateAvailable" => false, "error" => "Could not check for updates! See log file for details.")));
        }

        if ($this->update->newVersionAvailable()) {
            die(json_encode(array("updateAvailable" => true)));
        } else {
            die(json_encode(array("updateAvailable" => false)));
        }
    }

    private function checkWritePermission($dir = "")
    {
        $ffs = scandir($dir);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        foreach ($ffs as $ff) {
            if (!is_writable($dir . "/" . $ff)) {
                $this->fullWriteableList[] = array(
                   "path" => $dir . "/" . $ff,
                   "writeable" => is_writable($dir . "/" . $ff) ? 1 : 0
                   );
            }
            if (is_dir($dir . '/' . $ff)) {
                $this->checkWritePermission($dir . '/' . $ff);
            }
        }
    }

    private function _flush($message = '')
    {
        if ($this->flush_output === true) {
            echo $message . '<br/>';
        }
    }
}
