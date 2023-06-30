<?php
session_start();
include('connection.php');
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}

$user_id = $_SESSION['user_id'];

?>
<?php

if (isset($_FILES['carpicture'])){
    $plate = $_POST['plate'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];


    // Handle car picture upload
    $carPictureDir = "car_pictures/"; // Directory to store the uploaded car pictures
    $carPicturePath = $carPictureDir . basename($_FILES['carpicture']['name']);

    if (move_uploaded_file($_FILES['carpicture']['tmp_name'], $carPicturePath)) {
        // Insert the car details into the database
        $sql = "INSERT INTO carinformation (user_id, plate, brand, model, year, carpicture) VALUES ('$user_id', '$plate', '$brand', '$model', '$year', '$carPicturePath')";
        if (mysqli_query($link, $sql)) {
            echo "<div class='alert alert-success'>Your car has been added successfully.</div>";
        } else {
            echo "Failed to add the car: " . mysqli_error($link);
        }
    } else {
        echo "Failed to upload car picture.";
    }

    mysqli_close($link);
}
else {
    echo '<div class="alert alert-danger">Please add your car picture!</div>';
    
}



?>