<?php

    ob_start();

    // проверяем сессию
    if (isset($_SESSION)) {
        session_start();
    }

    $host = '127.0.0.1';
    $user = 'root';
    $password = 'YpUVMwmR8)';
    $dbname = 'baseddc';

    // создаем строку подключения к базе
    $connection = mysqli_connect($host, $user, $password, $dbname) or die('Ошибка соединения');
?>