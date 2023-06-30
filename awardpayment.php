<?php
// Include the necessary files and establish a database connection
include('connection.php');

// Retrieve the trip ID and driver ID from the AJAX request
$tripId = $_POST['tripId'];
$driverId = $_POST['driverId'];

// Retrieve the payment amount per passenger from the database
$sql_data = "SELECT price FROM carsharetrips WHERE trip_id = $tripId";
$result_data = mysqli_query($link, $sql_data);
$row = mysqli_fetch_array($result_data);
$paymentAmount = $row['price'];

// Update the driver's wallet balance by adding the payment amount
$sql_update = "UPDATE wallet SET balance = balance + $paymentAmount WHERE user_id = $driverId";
$result_update = mysqli_query($link, $sql_update);



$sql2 = "SELECT departure, destination FROM carsharetrips WHERE trip_id = $tripId";
$result2 = mysqli_query($link, $sql2);
$trip = mysqli_fetch_assoc($result2);

$message = "You have been awarded " . $paymentAmount . " for your trip from " . $trip["departure"] . " to " . $trip["destination"] . "!";
$sql_notification = "INSERT INTO `notifications` (`trip_id`, `user_id`, `notification_type`, `message`, `created_at`) VALUES ('$tripId', '$driverId', 'join', '$message', CONVERT_TZ(CURRENT_TIMESTAMP, @@session.time_zone, '+03:00'))";
$result_notification = mysqli_query($link, $sql_notification);
if ($result_update) {
  // Success message
  echo "Payment awarded successfully!";
} else {
  // Error message
  echo "Error awarding payment. Please try again.";
}

// Close the database connection
mysqli_close($link);
?>
