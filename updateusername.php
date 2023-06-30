<?php
// Start session and connect to the database
session_start();
include('connection.php');

// Get user_id
$user_id = $_SESSION['user_id'];

// Get the new profile information sent through Ajax
$username = $_POST['username'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$moreInformation = $_POST['more_information'];

// Update the profile information in the database
$sql = "UPDATE users SET username='$username', gender='$gender', phonenumber='$phone', moreinformation='$moreInformation' WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);


if ($result) {
    echo '<div class="alert alert-success">Profile information updated successfully.</div>';
} else {
    echo '<div class="alert alert-danger">There was an error updating the profile information. Please try again later.</div>';
}

?>