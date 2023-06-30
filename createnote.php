<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('location: index.php');
  exit();
}
include('connection.php');

$trip_id = $_POST['trip_id'];
$passenger_id = $_POST['passenger_id'];
$driver_id = $_POST['driver_id'];

// Retrieve the price of the trip
$sql_price = "SELECT price FROM carsharetrips WHERE trip_id = '$trip_id'";
$result_price = mysqli_query($link, $sql_price);
$row_price = mysqli_fetch_assoc($result_price);
$price = $row_price['price'];

// Check if the passenger has enough funds in their wallet
$sql_wallet = "SELECT balance FROM wallet WHERE user_id = '$passenger_id'";
$result_wallet = mysqli_query($link, $sql_wallet);
$row_wallet = mysqli_fetch_assoc($result_wallet);
$balance = $row_wallet['balance'];

if ($balance >= $price) {
  // Deduct the price from the passenger's wallet balance
  $sql_deduct = "UPDATE wallet SET balance = balance - $price WHERE user_id = '$passenger_id'";
  $result_deduct = mysqli_query($link, $sql_deduct);

  if ($result_deduct) {
    // Update the seatsavailable count in the carsharetrips table
    $sql_update_seats = "UPDATE carsharetrips SET seatsavailable = seatsavailable - 1 WHERE trip_id = '$trip_id'";
    $result_update_seats = mysqli_query($link, $sql_update_seats);

    if ($result_update_seats) {
      // Insert into trip_participants table
      $sql_insert = "INSERT INTO `trip_participants` (trip_id, user_id, is_driver, payment_amount, pickup_status) VALUES ('$trip_id', '$passenger_id', 0, '$price', 'pending')";
      $result_insert = mysqli_query($link, $sql_insert);

      $sql_chat = "INSERT INTO `chat_participants` (chat_id, user_id) VALUES ('$trip_id', '$passenger_id')";
      $reuslt_chat = mysqli_query($link, $sql_chat);

      $sql = "SELECT first_name, last_name FROM users WHERE user_id = $passenger_id";
        $result = mysqli_query($link, $sql);
        $user = mysqli_fetch_assoc($result);

        $sql2 = "SELECT departure, destination FROM carsharetrips WHERE trip_id = $trip_id";
        $result2 = mysqli_query($link, $sql2);
        $trip = mysqli_fetch_assoc($result2);

      $message = $user["first_name"] . " " . $user["last_name"] . " has joined your " . $trip["departure"] . " to " . $trip["destination"] . " trip!";

      if ($result_insert) {
        // Insert into notifications table
        $sql_notification = "INSERT INTO `notifications` (`trip_id`, `user_id`, `notification_type`, `message`, `created_at`) VALUES ('$trip_id', '$driver_id', 'join', '$message', CONVERT_TZ(CURRENT_TIMESTAMP, @@session.time_zone, '+03:00'))";

        $result_notification = mysqli_query($link, $sql_notification);

        if ($result_notification) {
          echo 'success';
        } else {
          echo 'error';
        }
      } else {
        echo 'error';
      }
    } else {
      echo 'error';
    }
  } else {
    echo 'error';
  }
} else {
  echo 'insufficient_funds';
}
?>