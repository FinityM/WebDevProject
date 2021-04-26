<?php
require "lib/config.php";

// If the user clicked the add to cart button on the product page check the form data
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {

    // Set the post variables so its identifiable, typecast into an int, it MUST be an int
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Prepare the SQL statement, to check if the product exists in our database
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_POST['product_id']]);

    // Fetch the game from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the game exists (array isn't empty)
    if ($product && $quantity > 0) {
        // Game exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There is no products in the cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission
    header('location: storeindex.php?page=cart');
    exit;
}

// Remove the game from the cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    // Remove the game from the shopping cart
    unset($_SESSION['cart'][$_GET['remove']]);
}

// Update game quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in the cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update the new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission
    header('location: storeindex.php?page=cart');
    exit;
}

// Send the user to the place order page if they click the Place Order button, leave the cart to be not empty
if (isset($_POST['order']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: storeindex.php?page=order');
    exit;
}

// Check the session variable for the game in the cart
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;

// If there are games in cart
if ($products_in_cart) {
    // There are games in the cart so we need to select those products from the database
    // Games in the cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the games
    $stmt->execute(array_keys($products_in_cart));
    // Fetch the games from the database and return the result as an Array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Calculate the subtotal
    foreach ($products as $product) {
        $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
    }
}
?>

<?php require "templates/storeheader.php" ?>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form action="storeindex.php?page=cart" method="post">
        <table>
            <thead>
            <tr>
                <td colspan="2">Game</td>
                <td>Price</td>
                <td>Quantity</td>
                <td>Total</td>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no games added in your Shopping Cart</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="img">
                            <a href="storeindex.php?page=game&id=<?= $product['id'] ?>">
                                <img src="images/<?= $product['img'] ?>" width="50" height="50"
                                     alt="<?= $product['name'] ?>">
                            </a>
                        </td>
                        <td>
                            <a href="storeindex.php?page=game&id=<?= $product['id'] ?>"><?= $product['name'] ?></a>
                            <br>
                            <a href="storeindex.php?page=cart&remove=<?= $product['id'] ?>" class="remove">Remove</a>
                        </td>
                        <td class="price">&dollar;<?= $product['price'] ?></td>
                        <td class="quantity">
                            <input type="number" name="quantity-<?= $product['id'] ?>"
                                   value="<?= $products_in_cart[$product['id']] ?>" min="1"
                                   max="<?= $product['quantity'] ?>" placeholder="Quantity" required>
                        </td>
                        <td class="price">&dollar;<?= $product['price'] * $products_in_cart[$product['id']] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?= $subtotal ?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <input type="submit" value="Place Order" name="order">
        </div>
    </form>
</div>

<? require "templates/storefooter.php" ?>
