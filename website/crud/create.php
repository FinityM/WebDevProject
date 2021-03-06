<?php
// Require the config file
require_once "../lib/config.php";

// Declare variables for username and password, initialized with empty values
$name = $password = "";
$name_err = $password_err = "";

// Form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter an email.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_EMAIL)) {
        $name_err = "Please enter a valid email.";
    } else {
        $name = $input_name;
    }

    // Validate password
    $input_password = trim($_POST["password"]);
    if (empty($input_password)) {
        $password_err = "Please enter a password";
    } else {
        $password = $input_password;
    }

    // Check the input errors before placing into database
    if (empty($name_err) && empty($password_err)) {
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

        if ($stmt = $pdo->prepare($sql)) {

            // Bind variables to prepared statement as parameters
            $stmt->bindParam(":username", $param_name);
            $stmt->bindParam(":password", $param_password);

            // Set the parameters
            $param_name = $name;
            $param_password = $password;

            // Attempt to execute prepared statement
            if ($stmt->execute()) {
                // If record is created successfully redirect to the main CRUD page
                header("location: crudtable.php");
                exit();
            } else {
                echo "Something went wrong (✖╭╮✖). Please try again later.";
            }
        }

        // Close the statement
        unset($stmt);
    }

    // Close the PDO connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/crud.css">
</head>
<body>
<div class="create-table">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Create Record</h2>
                <p>Please fill this form and submit to add a user to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="name"
                               class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                               value="<?php echo $name; ?>">
                        <span class="invalid-feedback"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password"
                               class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                               value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="crudtable.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>