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

// Retrieve the payment amount for the passenger
$sql_payment_amount = "SELECT payment_amount FROM `trip_participants` WHERE user_id = $passenger_id AND trip_id = $trip_id";
$result_payment_amount = mysqli_query($link, $sql_payment_amount);
$row_payment_amount = mysqli_fetch_assoc($result_payment_amount);
$payment_amount = $row_payment_amount['payment_amount'];

// Retrieve the date and time for the trip
$sql_trip_datetime = "SELECT date, time FROM carsharetrips WHERE trip_id = $trip_id";
$result_trip_datetime = mysqli_query($link, $sql_trip_datetime);
$row_trip_datetime = mysqli_fetch_assoc($result_trip_datetime);
$date = $row_trip_datetime['date'];
$time = $row_trip_datetime['time'];

// Convert the date and time to a format compatible with strtotime()
$formatted_date = date('Y-m-d', strtotime($date));
$formatted_time = date('H:i', strtotime($time));

// Calculate the refund amount based on the remaining time before the trip
$current_datetime = strtotime(date('Y-m-d H:i:s'));
$trip_datetime = strtotime($formatted_date . ' ' . $formatted_time);
$remaining_time = $trip_datetime - $current_datetime;
$remaining_hours = $remaining_time / 3600;
$refund_percentage = ($remaining_hours < 1) ? 0.8 : 1; // 80% refund if less than 1 hour remaining, otherwise 100% refund
$refund_amount = $payment_amount * $refund_percentage;

// Refund the amount to the passenger's wallet
$sql_refund = "UPDATE wallet SET balance = balance + $refund_amount WHERE user_id = '$passenger_id'";
$result_refund = mysqli_query($link, $sql_refund);

if ($result_refund) {
  // Update the seatsavailable count in the carsharetrips table
  $sql_update_seats = "UPDATE carsharetrips SET seatsavailable = seatsavailable + 1 WHERE trip_id = '$trip_id'";
  $result_update_seats = mysqli_query($link, $sql_update_seats);

  if ($result_update_seats) {
    // Delete the passenger from trip_participants table
    $sql_delete = "DELETE FROM trip_participants WHERE trip_id = '$trip_id' AND user_id = '$passenger_id'";
    $result_delete = mysqli_query($link, $sql_delete);

    $sql_delete_chat = "DELETE FROM `chat_participants` WHERE `chat_participants`.`chat_id` = $trip_id AND `chat_participants`.`user_id` = $passenger_id";
    $result_delete_chat = mysqli_query($link, $sql_delete_chat);

    $sql = "SELECT first_name, last_name FROM users WHERE user_id = $passenger_id";
    $result = mysqli_query($link, $sql);
    $user = mysqli_fetch_assoc($result);
    
    $sql2 = "SELECT departure, destination FROM carsharetrips WHERE trip_id = $trip_id";
    $result2 = mysqli_query($link, $sql2);
    $trip = mysqli_fetch_assoc($result2);

    if ($result_delete) {
      $message = $user["first_name"] . " " . $user["last_name"] . " has left your " . $trip["departure"] . " to " . $trip["destination"] . " trip!";
      // Insert the leave notification into the notifications table
      $sql_notification = "INSERT INTO `notifications` (`trip_id`, `user_id`, `notification_type`, `message`, `created_at`) VALUES ('$trip_id', '$driver_id', 'leave', '$message', CONVERT_TZ(CURRENT_TIMESTAMP, @@session.time_zone, '+03:00'))";      $result_notification = mysqli_query($link, $sql_notification);

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
?>
