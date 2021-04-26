<?php
echo '<title>MKGameStore | Sign Up</title>';
require "templates/header.php";

?>

<?php
// Define variables with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Form processing for when it's submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate the username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter an email.";
    } else {
        // Prepare the select statement
        $sql = "SELECT id FROM users WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set the parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "That email is taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Something went wrong (✖╭╮✖). Please try again later.";
            }

            // Close the statement
            unset($stmt);
        }
    }

    // Password validation
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have a minimum of 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Confirm password validation
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting into the database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

        if ($stmt = $pdo->prepare($sql)) {

            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            $param_username = $username;
            $param_password = $password;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {

                //Redirect to the login page
                header("location: login.php");
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

    <div class="signup-form">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
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
                       class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                       value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password"
                       class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                       value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>

<?php
require "templates/footer.php";
?>