<?php
// GET DB OPERATION CLASS
require_once dirname(__FILE__) . '/dbOperation.php';

if (isset($_GET['call'])) {
    // INIT DB OPERATION
    $dbo = new DbOperation();

    // PROCESS REQUEST
    switch ($_GET['call']) {
        default:
            echo json_encode([
                "message" => "Invalid Request"
            ]);
            break;

        case "update_data":
            checkMissingParameters(array('device_id', 'suhu_data', 'kelembaban_data'));
            $dbo->updateData($_POST['device_id'], $_POST['suhu_data'], $_POST['kelembaban_data']);
            echo json_encode([
                "message" => "Update Success"
            ]);
            break;

        case "update_data_get":
            $dbo->updateData($_GET['device_id'], $_GET['suhu_data'], $_GET['kelembaban_data']);
            echo json_encode([
                "message" => "Update Success"
            ]);
            break;

        case "get_all_data":
            $data = $dbo->getAllData();
            echo json_encode([
                "data" => $data
            ]);
            break;

        case "get_device_data":
            $data = $dbo->getDeviceData($_GET['device_id']);
            echo json_encode([
                "data" => $data
            ]);
            break;

        case "get_device_latest_data":
            $data = $dbo->getDeviceLatestData($_GET['device_id']);
            echo json_encode([
                "data" => $data
            ]);
            break;

    }
}


//Only for POST parameter
function checkMissingParameters($params) {
    //assuming all parameters are available
    $available = true;
    $missingparams = "";
    foreach ($params as $param) {
        if (!isset($_POST[$param]) || strlen($_POST[$param]) <= 0) {
            $available = false;
            $missingparams = $missingparams . ", " . $param;
        }
    }
    //if parameters are missing
    if (!$available) {
        $response = array();
        $response['error'] = true;
        $response['message'] = 'Parameters ' .
            substr($missingparams, 1, strlen($missingparams)) . ' missing';
        //displaying error
        echo json_encode($response);
        //stopping further execution
        die();
    }
}

