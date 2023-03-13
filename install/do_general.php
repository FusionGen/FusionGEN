<?php
ini_set('set_time_limit', 30);


if (isset($_POST)) {
    $title = $_POST['title'];
    $server_name = $_POST['server_name'];
    $realmlist = $_POST['realmlist'];
    $keywords = $_POST['keywords'];
    $description = $_POST['description'];
    $analytics = ($_POST['analytics']) ? $_POST['analytics'] : false;
    $security_code = $_POST['security_code'];
    $max_expansion = $_POST['max_expansion'];

    if (!($title && $server_name && $realmlist && $security_code)) {
        echo json_encode(array("success" => false, "message" => "Please input all fields."));
        exit();
    }

    require_once('../application/libraries/Configeditor.php');
	
    $distConfig = '../application/config/fusion.php.dist';
    $config = '../application/config/fusion.php';

    if(file_exists($config)) {
        unlink($config);
    }

    if(file_exists($distConfig)) {
        copy($distConfig, $config);
    }

    $config = new ConfigEditor($config);

    $data['title'] = $title;
    $data['server_name'] = $server_name;
    $data['realmlist'] = $realmlist;
    $data['keywords'] = $keywords;
    $data['description'] = $description;
    $data['analytics'] = ($analytics) ? $analytics : false;
    $data['security_code'] = $security_code;
    $data['max_expansion'] = $max_expansion;

    foreach($data as $key => $value)
    {
        $config->set($key, $value);
    }
	
    $config->save();

    echo json_encode(array("success" => true));
    exit();
}
