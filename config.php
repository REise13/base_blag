<?php
define('DB_SERVER', '91.223.123.104');
define('DB_USERNAME', 'admin');
define('DB_PASSWORD', 'baseDdc)');
define('DB_NAME', 'baseddc');

// подключение к базе данных
try {
    $con = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD, array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
      ));
    // $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}    

?>