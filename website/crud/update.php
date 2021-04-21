<?php
require_once "../lib/config.php";

$name = "";
$name_err = "";

if (isset($_POST["id"]) && !empty($_POST["id"])) {

    $id = $_POST["id"];

    $input_name = trim($_POST["username"]);
    if (empty($input_name)) {
        $name_err = "Please enter an email.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid email.";
    } else {
        $name = $input_name;
    }


    if (empty($name_err)) {

        $sql = "UPDATE users SET username=:username WHERE id=:id";

        if ($stmt = $pdo->prepare($sql)) {

            $stmt->bindParam(":username", $param_name);

            $param_name = $name;
            $param_id = $id;

            if ($stmt->execute()) {

                header("location: crudtable.php");
                exit();
            } else {
                echo "Something went wrong (✖╭╮✖). Please try again later.";
            }
        }

        unset($stmt);
    }

    unset($pdo);
} else {

    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {

        $id = trim($_GET["id"]);

        $sql = "SELECT * FROM users WHERE id = :id";
        if ($stmt = $pdo->prepare($sql)) {

            $stmt->bindParam(":id", $param_id);

            $param_id = $id;

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $name = $row["name"];

                } else {

                    header("location: error.php");
                    exit();
                }

            } else {
                echo "Something went wrong (✖╭╮✖). Please try again later.";
            }
        }

        // Close statement
        unset($stmt);

        // Close connection
        unset($pdo);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="update-table">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Update Record</h2>
                <p>Please edit the input values and submit to update the user record.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="name"
                               class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                               value="<?php echo $name; ?>">
                        <span class="invalid-feedback"><?php echo $name_err; ?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="crudtable.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
