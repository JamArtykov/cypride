<?php
//start session and connect
session_start();
include('connection.php');
$sql2="DELETE FROM trip_participants WHERE trip_id='".$_POST['trip_id']."'";
$result2= mysqli_query($link, $sql2);
$sql="DELETE FROM carsharetrips WHERE trip_id='".$_POST['trip_id']."'";
$result = mysqli_query($link, $sql);
?>