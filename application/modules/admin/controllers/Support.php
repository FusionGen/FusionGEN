<?php

defined('BASEPATH') or exit('This page does not exist');

class Support extends MX_Controller
{
    private $fullWriteableList = array();
    private $collect;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('administrator');
        $this->load->model('dashboard_model');

        require_once('application/libraries/Configeditor.php');
    }

    public function index()
    {
        $this->administrator->setTitle("Support");

        $apiKey = $this->config->item('api_key');
        if (!$apiKey) {
            $fusionConfig = new ConfigEditor("application/config/fusion.php");
            $fusionConfig->set("api_key", $this->randomString());
            $fusionConfig->save();
        }

        $supportrequests = $this->dashboard_model->getSupportRequests();

        $data = array(
            'url' => $this->template->page_url,
            'supportrequests' => $supportrequests,
        );

        $output = $this->template->loadPage("support.tpl", $data);

        $content = $this->administrator->box('Support', $output);

        $this->administrator->view($content, false, "modules/admin/js/support.js");
    }

    public function create_request()
    {
        $apiKey = $this->config->item('api_key');
        $url = 'https://fusiongen.net/api/create_request';

        $data = array(
            'key' => $apiKey,
            'domain' => pageURL,
            'ip' => $_SERVER['SERVER_ADDR'],
            'site_name' => $this->config->item('server_name'),
            'datas' => $this->collect(),
        );

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $apiKey));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);

        curl_close($ch);

        $db = array(
            'timestamp' => time(),
        );

        $this->dashboard_model->insertRequest($db);

        die($result);
    }

    public function collect()
    {
        $system_hostname = gethostname();

        $this->checkWritePermission(".");

        $realms = $this->cms_model->getRealms();
        $emulator = array_column($realms, "emulator");

        $data = array(
            'enabledModules' => $this->administrator->getEnabledModules(),
            'disabledModules' => $this->administrator->getDisabledModules(),
            'defaultLanguage' => $this->config->item('language'),
            'languages' => $this->language->getAllLanguages(),
            'CMSVersion' => $this->administrator->getVersion(),
            'ip' => $_SERVER['SERVER_ADDR'],
            'site_name' => $this->config->item('server_name'),
            'site_domain' => pageURL,
            'system_hostname' => $system_hostname,
            'server_software' => $_SERVER['SERVER_SOFTWARE'],
            'ApacheModules' => $this->getApacheModules(),
            'php_version' => phpversion(),
            'php_extensions' => $this->getPHPExtensions(),
            'ci_version' => CI_VERSION,
            'allow_url_fopen' => ini_get('allow_url_fopen'),
            'allow_url_include' => ini_get('allow_url_include'),
            'writeableList' => $this->fullWriteableList,
            'configs' => array(
                'theme' => $this->config->item('theme'),
                'has_smtp' => $this->config->item('has_smtp'),
                'disabled_expansions' => $this->config->item('disabled_expansions'),
                'slider' => $this->config->item('slider'),
                'slider_home' => $this->config->item('slider_home'),
                'slider_interval' => $this->config->item('slider_interval'),
                'slider_style' => $this->config->item('slider_style'),
                'vote_reminder' => $this->config->item('vote_reminder'),
                'reminder_interval' => $this->config->item('reminder_interval'),
                'use_fcms_tooltip' => $this->config->item('use_fcms_tooltip'),
                'cache' => $this->config->item('cache'),
                'auto_update' => $this->config->item('auto_update'),
                'use_own_smtp_settings' => $this->config->item('use_own_smtp_settings'),
                'smtp_protocol' => $this->config->item('smtp_protocol'),
                'smtp_port' => $this->config->item('smtp_port'),
                'smtp_crypto' => $this->config->item('smtp_crypto'),
                ),
            'emulator' => $emulator['0'],
        );

        $result = serialize($data);
        $result = base64_encode($result);
        return $result;
    }

    private function getApacheModules()
    {
        if (function_exists('apache_get_modules')) {
            $modules = apache_get_modules();
            return $module;
        }
    }

    private function getPHPExtensions()
    {
        $extensions = get_loaded_extensions();
        return $extensions;
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

    private function randomString()
    {
        return implode(str_split(substr(strtoupper(md5(time() . rand(1000, 9999))), 0, 40), 4));
    }
}
