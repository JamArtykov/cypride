<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trip Details</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="styling.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/sunny/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA_6tTKWvu8rFKXruzKisNnFJSrAVsuqxE"></script>
    <style>
        
        .container{
            margin-top: 100px;
            
            text-align: center;
        }
        
        .border-right {
            border-right: 1px solid black;
        }

        hr { background-color: black; height: 1px; border: 0; }

        .driver-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto;
        }

        .passenger-picture{
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto;
        }
        
    </style>



<?php 
if(isset($_SESSION["user_id"])){
    include("navigationbarconnected.php");
}else{
    include("navigationbarnotconnected.php");
}



$trip_id = $_GET['trip_id'];
echo  $trip_id;

$sql = "SELECT * FROM carsharetrips WHERE trip_id = $trip_id";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>';
    exit;
}

$row = mysqli_fetch_array($result);
$destination = $row['destination'];
$departure = $row['departure'];

if($row['regular']=="N"){
    $frequency = "One-off journey.";
    $time = $row['date']." at " .$row['time'].".";
}else{
    $frequency = "Regular."; 
    $array = [];
        if($row['monday']==1){array_push($array,"Mon");}
        if($row['tuesday']==1){array_push($array,"Tue");}
        if($row['wednesday']==1){array_push($array,"Wed");}
        if($row['thursday']==1){array_push($array,"Thu");}
        if($row['friday']==1){array_push($array,"Fri");}
        if($row['saturday']==1){array_push($array,"Sat");}
        if($row['sunday']==1){array_push($array,"Sun");}
    $time = implode("-", $array)." at " .$row['time'].".";
}


$sql2 = "SELECT * FROM trip_participants WHERE trip_id = $trip_id";
$result2 = mysqli_query($link, $sql2);
$num_rows = mysqli_num_rows($result2);
$passengers = array(); // Initialize an empty array to hold passenger IDs
while($row2 = mysqli_fetch_array($result2)){
    if ($row2['is_driver']==1){
        $driver_id = $row2['user_id'];
    } else {
        $passengers[] = $row2['user_id']; // Append passenger ID to the array
    }
}
$seatsleft = $row['seatsavailable'] - $num_rows + 1;

// Fetch driver information
$sql3 = "SELECT * FROM users WHERE user_id = $driver_id";
$result3 = mysqli_query($link, $sql3);
$row3 = mysqli_fetch_array($result3);
$driver_first_name = $row3['first_name'];
$driver_last_name = $row3['last_name'];
$driver_profile_picture = $row3['profilepicture'];

if(empty($driver_profile_picture)){
    $driver_profile_picture = "noimage.jpg";
}



echo
'<div class="container" style="color: black">
<div class="row">
  <div class="col-md-8 border-right">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">TRIP DETAILS</h4>
        <div class="d-flex flex-wrap justify-content-between align-items-center">
          <div>
            <i class="fas fa-map-marker-alt"></i>'.$departure.' - <i class="fas fa-map-marker-alt"></i> '.$destination.'
          </div>
          <div>
            <i class="fas fa-calendar-alt"></i> '.$time.'
          </div>
          <div>
            <i class="fas fa-clock"></i> '.$row['price'].'$ per seat
          </div>
          <div>
            <i class="fas fa-road"></i> '.$seatsleft.' seats left
          </div>
        </div>
        <hr>
        <div id="googleMap"></div>    
        
      </div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Participants</h4>
        <hr>
        <h5 class="card-title">Driver</h5>
            <img class="driver-picture" src="' . $driver_profile_picture . '">
            <p>' . $driver_first_name . ' ' . $driver_last_name . '</p>
        <hr>
        <h5 class="card-title">Passengers</h5>
        <div class="col-12">';
            foreach ($passengers as $passenger_id) {
                $sql4 = "SELECT * FROM users WHERE user_id = $passenger_id";
                $result4 = mysqli_query($link, $sql4);
                $row4 = mysqli_fetch_array($result4);
                $passenger_first_name = $row4['first_name'];
                $passenger_last_name = $row4['last_name'];
                $passenger_profile_picture = $row4['profilepicture'];
                if(empty($driver_profile_picture)){
                    $driver_profile_picture = "noimage.jpg";
                }
                echo '<span class="col-sm-4">
                        <img class="passenger-picture" src="'.$passenger_profile_picture.'">
                        <p>' .$passenger_first_name . ' ' . $passenger_last_name . '</p>
                    </span>';
            }
        echo '</div>';      
        echo '</div>';      
        echo'</div>';       
    echo '</div>';
    echo '<div id="trip-details" data-trip-id="'.$trip_id.'" data-passenger-id="'.$_SESSION['user_id'].'"></div>';
        echo '<button class="btn btn-primary" id="add-passenger-btn">Join Now</button>';

?>


<script src="js/bootstrap.min.js"></script>
<script src="map.js"></script>  
<script src="javascript.js"></script>

</head>
</html>