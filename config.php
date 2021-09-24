<?php

// создаем строку подключения к базе
$link = mysql_connect('127.0.0.1', 'root', 'YpUVMwmR8', 'baseddc');

if (!$link) {
    die('Ошибка соединения: ' . mysql_error());
}

echo 'Успешное соединение';

?>