<?php
require "templates/header.php";
?>

<div class="jumbotron" style="background-color: #7289da; text-align: center">
    <h1 class="display-4">Welcome</h1>
    <p class="lead">Welcome to the homepage</p>
    <hr class="my-4">
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus a nisi viverra, consectetur nunc in, varius
        tellus. Donec at erat cursus, ullamcorper tortor eget, finibus urna. In sit amet tortor metus. Phasellus est
        est, semper sed porta sed, aliquam quis orci. Mauris sit amet tempor erat. Nunc in nisi eu lectus ornare
        dignissim in ac erat. Aenean feugiat blandit ante id finibus. Cras lobortis pulvinar magna et cursus. Vestibulum
        vitae diam est. Praesent arcu lacus, vehicula ut sem volutpat, iaculis feugiat tellus. Integer sodales, ex non
        congue aliquam, diam ante porta nunc, in faucibus dui nunc vitae odio. Fusce nec dui suscipit, pulvinar libero
        id, venenatis diam.

        Vestibulum ut tellus non felis auctor pharetra. In et pretium augue, eu eleifend lacus. Sed lobortis lacinia
        purus. Nunc a pellentesque odio. Cras efficitur at elit sed dictum. Ut condimentum gravida magna vitae molestie.
        Maecenas aliquam purus accumsan tellus molestie, id vestibulum dolor malesuada. Vestibulum nec rhoncus neque, in
        porttitor nunc. Curabitur ut libero placerat, pellentesque ligula nec, semper risus. In ac euismod lectus, id
        accumsan libero. Curabitur vestibulum nulla quis nunc scelerisque, et aliquam nunc rutrum. Pellentesque et
        sapien non orci congue sagittis.</p>
</div>

<div class="jumbotron" style="background-color: #7289da; text-align: center">
    <h1 class="display-4">Visit our store </h1>
    <p class="lead">
        <a class="btn btn-primary btn-lg" href="store.php" role="button">Here</a>
    </p>

</div>

<div class="jumbotron" style="background-color: #7289da; text-align: center">
    <h1 class="display-4">Account Status</h1>
    <?php
    if (isset($_SESSION['id'])){
        echo "You are logged in";
    } else {
        echo "There is no account logged in";
    }
    ?>
</div>


<?php
require "templates/footer.php";
?>
