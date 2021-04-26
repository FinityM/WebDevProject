<?php
echo '<title>MKGameStore | Login</title>';
require "templates/header.php";
?>

<?php
// If user is logged in redirect to the main home page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Define variables and initialise with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Form data processing when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check for empty usernames
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter an email";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check for empty passwords
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate the credentials
    if (empty($username_err) && empty($password_err)) {

        $sql = "SELECT id, username, password FROM users WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set the parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {

                // Check if the username exists
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $username = $row["username"];

                        if ($password) {
                            // If password is correct start a new session
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect to the main home page
                            header("location: index.php");
                        } else {

                            $login_err = "Wrong username or password.";
                        }
                    }
                } else {

                    $login_err = "Wrong username or password.";
                }
            } else {
                echo "Something went wrong (✖╭╮✖). Please try again later.";
            }

            // Close the statement
            unset($stmt);
        }
    }

    // Close the PDO connection
    unset($pdo);
}
?>

    <div class="login-form">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="username"
                       class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                       value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password"
                       class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
        </form>
    </div>

<?php
require "templates/footer.php";
?>