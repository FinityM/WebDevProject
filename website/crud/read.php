<?php
// Check for the id before processing
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {

    // Require the config file once
    require_once "../lib/config.php";

    // Prepare the select statement
    $sql = "SELECT * FROM users WHERE id = :id";

    if ($stmt = $pdo->prepare($sql)) {

        // Bind the variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);

        // Set the parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                /* Fetch the result as an associative array. Since the set only contains one row, while loop isn't required*/
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retrieve the field value
                $name = $row["username"];

            } else {
                // Redirect to error page if it fails
                header("location: error.php");
                exit();
            }

        } else {
            echo "Something went wrong (✖╭╮✖). Please try again later.";
        }
    }

    // Close the statement
    unset($stmt);

    // Close the connection
    unset($pdo);
} else {
    // Redirect to the error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Read</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/crud.css">
</head>
<body>
<div class="read-table">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-5 mb-3">View Record</h1>
                <div class="form-group">
                    <label>Email</label>
                    <p><b><?php echo $row["username"]; ?></b></p>
                </div>
                <p><a href="crudtable.php" class="btn btn-primary">Back</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
