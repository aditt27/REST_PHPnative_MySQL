<?php

class DbOperation {

    //Database connection link
    private $con;

    //Class constructor
    function __construct() {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/dbConnect.php';

        //Creating a DbConnect object to connect to the database
        $db = new DbConnect();

        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $db->connect();
    }

    function updateData($device, $suhu, $kelembaban) {
        $stmt = $this->con->prepare("INSERT INTO monitoring (monitoring_id, device_id, suhu_data, kelembaban_data, monitoring_date) VALUES (NULL, UPPER(?), ?, ?, CURRENT_TIMESTAMP)");
        $stmt->bind_param("sdd", $device, $suhu, $kelembaban);
        $stmt->execute();
        $stmt->close();
    }

    function getAllData() {
        $stmt = $this->con->prepare("SELECT monitoring_id, device_id, suhu_data, kelembaban_data, monitoring_date FROM monitoring");
        $stmt->execute();
        $stmt->bind_result($monitoring_id, $device_id, $suhu_data, $kelembaban_data, $suhu_date);

        $infos = array();

        while ($stmt->fetch()) {
            $info = array();
            $info['monitoring_id'] = $monitoring_id;
            $info['device_id'] = $device_id;
            $info['suhu_data'] = $suhu_data;
            $info['kelembaban_data'] = $kelembaban_data;
            $info['suhu_date'] = $suhu_date;

            array_push($infos, $info);
        }
        $stmt->close();
        return $infos;
    }

    function getDeviceLatestData($device_id) {
        $stmt = $this->con->prepare("SELECT monitoring_id, device_id, suhu_data, kelembaban_data, monitoring_date FROM monitoring WHERE device_id = ? ORDER BY monitoring_date DESC LIMIT 1");
        $stmt->bind_param("s",$device_id);
        $stmt->execute();
        $stmt->bind_result($monitoring_id, $device_id, $suhu_data, $kelembaban_data, $suhu_date);

        $info = array();

        while ($stmt->fetch()) {
            $info['monitoring_id'] = $monitoring_id;
            $info['device_id'] = $device_id;
            $info['suhu_data'] = $suhu_data;
            $info['kelembaban_data'] = $kelembaban_data;
            $info['suhu_date'] = $suhu_date;
        }
        $stmt->close();
        return $info;
    }

    function getDeviceData($device_id) {
        $stmt = $this->con->prepare("SELECT monitoring_id, device_id, suhu_data, kelembaban_data, monitoring_date FROM monitoring WHERE device_id = ?");
        $stmt->bind_param("s",$device_id);
        $stmt->execute();
        $stmt->bind_result($monitoring_id, $device_id, $suhu_data, $kelembaban_data, $suhu_date);

        $infos = array();

        while ($stmt->fetch()) {
            $info = array();
            $info['monitoring_id'] = $monitoring_id;
            $info['device_id'] = $device_id;
            $info['suhu_data'] = $suhu_data;
            $info['kelembaban_data'] = $kelembaban_data;
            $info['suhu_date'] = $suhu_date;

            array_push($infos, $info);
        }
        $stmt->close();
        return $infos;
    }


}
