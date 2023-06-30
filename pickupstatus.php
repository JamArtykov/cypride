<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $tripId = $_POST["tripId"];
  $passengerId = $_POST["passengerId"];
  $driverId = $_POST["driverId"];
  $pickupStatus = $_POST["pickupStatus"];

  // Update the pickup status in the trip_participants table
  $sql = "UPDATE trip_participants SET pickup_status = '$pickupStatus'
          WHERE trip_id = $tripId AND user_id = $passengerId";
  $result = mysqli_query($link, $sql);

  if ($result) {
    // Perform any additional actions if needed

    // Return a success message
    echo "Pickup status updated successfully";
  } else {
    // Return an error message
    echo "Error updating pickup status: " . mysqli_error($link);
  }
}
?>