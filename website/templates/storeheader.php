<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/store.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<header>
    <div class="content-wrapper">
        <h1>MKGameStore</h1>
        <nav>
            <a href="..\website\index.php">Home</a>
            <a href="..\website\storeindex.php">Store</a>
        </nav>
        <div class="link-icons">
            <a href="storeindex.php?page=cart">
                <i class="fas fa-shopping-cart"></i>
                <span><?php $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;  $num_items_in_cart?></span>
            </a>
        </div>
    </div>
</header>
<main>