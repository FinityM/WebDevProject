<?php
session_start();

// Page is set to storepage (storepage.php), once visitor enters store page that will be the default
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'storepage';
// Include and show the requested page
include $page . '.php';
?>