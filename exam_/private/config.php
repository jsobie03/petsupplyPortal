<?php
ini_set('session.cookie_lifetime', 60 * 60 * 24);
ini_set('session.gc-maxlifetime', 60 * 60 * 24);
session_start();
date_default_timezone_set('America/Los_Angeles');
    try {
        $db = new PDO("mysql:host=www.jonsobier.com;dbname=jsobieze_exam;",'jsobieze_psPort','adminPS');
    } catch (Exception $e) {
        die('Error : ' . $e->getMessage());
    }

    require_once '/functions/func.php';
?>