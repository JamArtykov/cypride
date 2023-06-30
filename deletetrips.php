<?php
//start session and connect
session_start();
include('connection.php');
$sql2="DELETE FROM trip_participants WHERE trip_id='".$_POST['trip_id']."'";
$result2= mysqli_query($link, $sql2);
$sql="DELETE FROM carsharetrips WHERE trip_id='".$_POST['trip_id']."'";
$result = mysqli_query($link, $sql);
?>

<?php
// Start session and connect
session_start();
include('connection.php');

// Delete entries from trip_participants table
$sql1 = "DELETE FROM trip_participants WHERE trip_id = '".$_POST['trip_id']."'";
$result1 = mysqli_query($link, $sql1);

// Delete entries from chats table
$sql2 = "DELETE FROM chats WHERE trip_id = '".$_POST['trip_id']."'";
$result2 = mysqli_query($link, $sql2);

// Delete entries from chat_messages table
$sql3 = "DELETE FROM chat_messages WHERE chat_id IN (SELECT chat_id FROM chats WHERE trip_id = '".$_POST['trip_id']."')";
$result3 = mysqli_query($link, $sql3);

// Delete entries from chat_participants table
$sql4 = "DELETE FROM chat_participants WHERE chat_id IN (SELECT chat_id FROM chats WHERE trip_id = '".$_POST['trip_id']."')";
$result4 = mysqli_query($link, $sql4);

// Delete entries from notifications table
$sql5 = "DELETE FROM notifications WHERE trip_id = '".$_POST['trip_id']."'";
$result5 = mysqli_query($link, $sql5);

// Delete entries from transactions table
$sql6 = "DELETE FROM transactions WHERE trip_id = '".$_POST['trip_id']."'";
$result6 = mysqli_query($link, $sql6);

// Delete entry from carsharetrips table
$sql7 = "DELETE FROM carsharetrips WHERE trip_id = '".$_POST['trip_id']."'";
$result7 = mysqli_query($link, $sql7);

// Check if all queries executed successfully
if ($result1 && $result2 && $result3 && $result4 && $result5 && $result6 && $result7) {
  // Queries executed successfully
  echo "Trip entries deleted successfully from all related tables.";
} else {
  // Error occurred
  echo "Error deleting trip entries from related tables: " . mysqli_error($link);
}

// Close the database connection
mysqli_close($link);
?>
