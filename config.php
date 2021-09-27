<?php
    global $conn;
    // переменные с данными для подкючения к базе данных
    $server ='127.0.0.1';
    $user = 'root';
    $pass ='YpUVMwmR8)';
    $db = 'baseddc';

    // подключение к базе данных
    $conn = new mysqli($server, $user, $pass, $db);

    // проверяем соединение
    if($conn->connect_error) {
        die('Не удалось подключиться к MySQL: ' . $conn->connect_error);
    }

?>