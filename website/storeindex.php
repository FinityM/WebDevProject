<?php
session_start();

// Page is set to home (home.php) by default, so when the visitor visits that will be the page they see.
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'storepage';
// Include and show the requested page
include $page . '.php';
?>