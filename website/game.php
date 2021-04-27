<?php
// The pdo connection
require "lib/config.php";

// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {

    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);

    // Fetch the game from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the game exists (array is not empty)
    if (!$product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Game does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Game does not exist!');
}
?>

<?php
echo '<title>MKGameStore | Game</title>';
require "templates/storeheader.php" ?>

<div class="product content-wrapper">
    <img src="images/<?= $product['img'] ?>" width="500" height="500" alt="<?= $product['name'] ?>">
    <div>
        <h1 class="name"><?= $product['name'] ?></h1>
        <span class="price">
            &dollar;<?= $product['price'] ?>
            <?php if ($product['rrp'] > 0): ?>
                <span class="rrp">&dollar;<?= $product['rrp'] ?></span>
            <?php endif; ?>
        </span>
        <form action="storeindex.php?page=cart" method="post">
            <input type="number" name="quantity" value="1" min="1" max="<?= $product['quantity'] ?>"
                   placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <input type="submit" value="Add To Cart">
        </form>
        <div class="description">
            <?= $product['desc'] ?>
        </div>
    </div>
</div>

<?php require "templates/storefooter.php" ?>
