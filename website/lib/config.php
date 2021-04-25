<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'mkstore');

try {
    $pdo = new PDO("mysql:hosts=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Failed to connect (✖╭╮✖) (✖╭╮✖) (✖╭╮✖) (✖╭╮✖) (✖╭╮✖)" . $e->getMessage());
}

?>