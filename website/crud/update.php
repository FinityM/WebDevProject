<?php
require_once "../lib/config.php";

$name = $password = "";
$name_err = $password_err = "";

if(isset($_POST["id"]) && !empty($_POST["id"])){

    $id = $_POST["id"];

    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter an email.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_EMAIL)){
        $name_err = "Please enter a valid email.";
    } else{
        $name = $input_name;
    }

    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Please enter a password.";
    } else{
        $password = $input_password;
    }

    if(empty($name_err) && empty($password_err) && empty($salary_err)){

        $sql = "UPDATE users SET username=:name, password=:password WHERE id=:id";

        if($stmt = $pdo->prepare($sql)){

            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":password", $param_password);
            $stmt->bindParam(":id", $param_id);

            $param_name = $name;
            $param_password = $password;
            $param_id = $id;

            if($stmt->execute()){

                header("location: crudtable.php");
                exit();
            } else{
                echo "Something went wrong (✖╭╮✖). Please try again later.";
            }
        }

        unset($stmt);
    }

    unset($pdo);
} else{

    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

        $id =  trim($_GET["id"]);

        $sql = "SELECT * FROM users WHERE id = :id";
        if($stmt = $pdo->prepare($sql)){

            $stmt->bindParam(":id", $param_id);

            $param_id = $id;

         if($stmt->execute()){
                if($stmt->rowCount() == 1){

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $name = $row["username"];
                    $password = $row["password"];
                } else{

                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Something went wrong (✖╭╮✖). Please try again later.";
            }
        }

        unset($stmt);

        unset($pdo);
    }  else{

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
    <link rel="stylesheet" href="../css/crud.css">
</head>
<body>
<div class="update-table">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Update Record</h2>
                <p>Please edit the input values and submit to update the users record.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                        <span class="invalid-feedback"><?php echo $name_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?><?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err;?></span>
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