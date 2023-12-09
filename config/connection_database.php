<?php
$host = "localhost";
$dbname = "pv116";
$username = "root";
$password = "";

//$host = "mariadbphp.mariadb.database.azure.com";
//$dbname = "mariadbphp";
//$username = "ferry";
//$password = "Tayle267072&";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
