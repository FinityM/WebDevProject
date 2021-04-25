<?php
// The pdo
require "lib/config.php";

// The amounts of products to show on each page
$num_products_on_each_page = 3;
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT ?,?');
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of products
$total_products = $pdo->query('SELECT * FROM products')->rowCount();
?>

<?php
echo '<title>MKGameStore | Store</title>';
require "templates/storeheader.php"
?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <p><?= $total_products ?> Products</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product): ?>
            <a href="storeindex.php?page=game&id=<?= $product['id'] ?>" class="product">
                <img src="images/<?= $product['img'] ?>" width="200" height="200" alt="<?= $product['name'] ?>">
                <span class="name"><?= $product['name'] ?></span>
                <span class="price">
                &dollar;<?= $product['price'] ?>
                    <?php if ($product['rrp'] > 0): ?>
                        <span class="rrp">&dollar;<?= $product['rrp'] ?></span>
                    <?php endif; ?>
            </span>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="buttons">
        <?php if ($current_page > 1): ?>
            <a href="storeindex.php?page=game&p=<?= $current_page - 1 ?>">Prev</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)): ?>
            <a href="storeindex.php?page=game&p=<?= $current_page + 1 ?>">Next</a>
        <?php endif; ?>
    </div>
</div>

<?php
require "templates/storefooter.php"
?>
