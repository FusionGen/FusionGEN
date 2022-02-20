<?php
ini_set('max_execution_time', 30);

if (isset($_POST)) {
    $title = $_POST['title'];
    $server_name = $_POST['server_name'];
    $realmlist = $_POST['realmlist'];
    $keywords = $_POST['keywords'];
    $description = $_POST['description'];
    $analytics = ($_POST['analytics']) ? $_POST['analytics'] : false;
    $cdn = ($_POST['cdn'] == '1') ? true : false;
    $security_code = $_POST['security_code'];

    if (!($title && $server_name && $realmlist && $security_code)) {
        echo json_encode(array("success" => false, "message" => "Please input all fields."));
        exit();
    }

    require_once('../application/libraries/configeditor.php');
	
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
    $data['cdn'] = ($cdn == '1') ? true : false;
    $data['security_code'] = $security_code;

    foreach($data as $key => $value)
    {
        $config->set($key, $value);
    }

    switch($_POST['expansion'])
    {
        case "legion":
            $config->set('disabled_expansions', array(7));
        break;
        
        case "wod":
            $config->set('disabled_expansions', array(6,7));
        break;
        
        case "mop":
            $config->set('disabled_expansions', array(5,6,7));
        break;
        
        case "cata":
            $config->set('disabled_expansions', array(4,5,6,7));
        break;
        
        case "wotlk":
            $config->set('disabled_expansions', array(3,4,5,6,7));
        break;
        
        case "tbc":
            $config->set('disabled_expansions', array(2,3,4,5,6,7));
        break;
        
        case "vanilla":
            $config->set('disabled_expansions', array(1,2,3,4,5,6,7));
        break;
        
        default:
            $config->set('disabled_expansions', array());
        break;
    }
	
    $config->save();

    echo json_encode(array("success" => true));
    exit();
}
