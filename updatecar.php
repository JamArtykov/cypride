<?php
//start session and connect
session_start();
include ('connection.php');
$user_id = $_SESSION['user_id'];
$plate = $_POST['plate2'];
$brand = $_POST['brand2'];
$model = $_POST['model2'];
$year = $_POST['year2'];

$sql = "UPDATE carinformation SET plate='$plate', brand='$brand', model='$model', year='$year' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

if ($result) {    
    echo "<div class='alert alert-success'>Car information updated successfully.</div>";
    
} else {
    echo "<div class='alert alert-success'>Failed to update car information.</div>";
}

?>