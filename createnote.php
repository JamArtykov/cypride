<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('location: index.php');
}
include('connection.php');

$trip_id = $_POST['trip_id'];
$passenger_id = $_POST['passenger_id'];

$sql = "INSERT INTO `trip_participants` (trip_id, user_id, is_driver) VALUES ('$trip_id', '$passenger_id', 0)";
$result = mysqli_query($link, $sql);

if ($result) {
  echo 'success';
} else {
  echo 'error';
}
?>