<?php
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {

    require_once "../lib/config.php";

    $sql = "SELECT * FROM users WHERE id = :id";

    if ($stmt = $pdo->prepare($sql)) {

        $stmt->bindParam(":id", $param_id);

        $param_id = trim($_GET["id"]);

        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $name = $row["username"];

            } else {

                header("location: error.php");
                exit();
            }

        } else {
            echo "Something went wrong (✖╭╮✖). Please try again later.";
        }
    }

    unset($stmt);

    unset($pdo);
} else {
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
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
