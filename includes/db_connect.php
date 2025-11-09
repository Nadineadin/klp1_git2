<?php
$host = "localhost";
$pass = "";
$user = "root";
$name = "klp1";
$port = "3306";
try {
    $mysqli = new mysqli($host, $user, $pass, $name, $port);
} catch (mysqli_sql_exception $e) {
    die('Gagal connect ke database: ' . $e->getMessage());
}
