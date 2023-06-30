
<?php
//start session and connect to database
session_start();
include('connection.php');



//define error messages
$missingdeparture = '<p><strong>Please enter your departure!</strong></p>';
$invaliddeparture = '<p><strong>Please enter a valid departure!</strong></p>';
$missingdestination = '<p><strong>Please enter your destination!</strong></p>';
$invaliddestination = '<p><strong>Please enter a valid destination!</strong></p>';

//Get inputs:
$departure = $_POST["departure"];
$destination = $_POST["destination"];

//check coordinates
if(!isset($_POST["departureLatitude"]) or !isset($_POST["departureLongitude"])){
    $errors .= $invaliddeparture;
}else{
    $departureLatitude = $_POST["departureLatitude"];
    $departureLongitude = $_POST["departureLongitude"];
}

if(!isset($_POST["destinationLatitude"]) or !isset($_POST["destinationLongitude"])){
    $errors .= $invaliddestination;
}else{
    $destinationLatitude = $_POST["destinationLatitude"];
    $destinationLongitude = $_POST["destinationLongitude"];
}

//set search radius
$searchRadius = 5;

//min max Departure Longitude
$deltaLongitudeDeparture = $searchRadius*360/(24901*cos(deg2rad($departureLatitude)));
$minLongitudeDeparture = $departureLongitude - $deltaLongitudeDeparture;
if($minLongitudeDeparture < -180){
    $minLongitudeDeparture += 360;
}
$maxLongitudeDeparture = $departureLongitude + $deltaLongitudeDeparture;
if($maxLongitudeDeparture > 180){
    $maxLongitudeDeparture -= 360;
}

//min max Destination Longitude
$deltaLongitudeDestination = $searchRadius*360/(24901*cos(deg2rad($destinationLatitude)));
$minLongitudeDestination = $destinationLongitude - $deltaLongitudeDestination;
if($minLongitudeDestination < -180){
    $minLongitudeDestination += 360;
}
$maxLongitudeDestination = $destinationLongitude + $deltaLongitudeDestination;
if($maxLongitudeDestination > 180){
    $maxLongitudeDestination -= 360;
}

//min max Departure Latitude
$deltaLatitudeDeparture = $searchRadius*180/12430;
$minLatitudeDeparture = $departureLatitude - $deltaLatitudeDeparture;
if($minLatitudeDeparture < -90){
    $minLatitudeDeparture = -90;
}
$maxLatitudeDeparture = $departureLatitude + $deltaLatitudeDeparture;
if($maxLatitudeDeparture > 90){
    $maxLatitudeDeparture = 90;
}

//min max Destination Latitude
$deltaLatitudeDestination = $searchRadius*180/12430;
$minLatitudeDestination = $destinationLatitude - $deltaLatitudeDestination;
if($minLatitudeDestination < -90){
    $minLatitudeDestination = -90;
}
$maxLatitudeDestination = $destinationLatitude + $deltaLatitudeDestination;
if($maxLatitudeDestination > 90){
    $maxLatitudeDestination = 90;
}

//Check departure:
if(!$departure){
    $errors .= $missingdeparture;
}else{
    $departure = filter_var($departure, FILTER_SANITIZE_STRING);
}

//Check destination:
if(!$destination){
    $errors .= $missingdestination;
}else{
    $destination = filter_var($destination, FILTER_SANITIZE_STRING);
}

//if there is an error print error message
if($errors){
    $resultMessage = '<div class=" alert alert-danger">' . $errors . '</div>';
    echo $resultMessage; exit;
}

//get all available trips in the carsharetrips table
$myArray = [$minLongitudeDeparture < $maxLongitudeDeparture, $minLatitudeDeparture < $maxLatitudeDeparture, $minLongitudeDestination < $maxLongitudeDestination, $minLatitudeDestination < $maxLatitudeDestination];

$queryChoice1 = [
    " (departureLongitude BETWEEN $minLongitudeDeparture AND $maxLongitudeDeparture)",
    " AND (departureLatitude BETWEEN $minLatitudeDeparture AND $maxLatitudeDeparture)",
    " AND (destinationLongitude BETWEEN $minLongitudeDestination AND $maxLongitudeDestination)",
    " AND (destinationLatitude BETWEEN $minLatitudeDestination AND $maxLatitudeDestination)"
];

$queryChoice2 = [
    " ((departureLongitude > $minLongitudeDeparture) OR (departureLongitude < $maxLongitudeDeparture))",
    " AND (departureLatitude BETWEEN $minLatitudeDeparture AND $maxLatitudeDeparture)",
    " AND ((destinationLongitude > $minLongitudeDestination) OR (destinationLongitude < $maxLongitudeDestination))",
    " AND (destinationLatitude BETWEEN $minLatitudeDestination AND $maxLatitudeDestination)"
];

$queryChoices = [$queryChoice2, $queryChoice1];

$sql = "SELECT * FROM carsharetrips WHERE ";

for ($value=0; $value<4; $value++) {
    $index = $myArray[$value];
    $sql .= $queryChoices[$index][$value];
}

$result = mysqli_query($link, $sql);
if(!$result){
    echo "ERROR: Unable to excecute: $sql. " . mysqli_error($link); exit;
}

if(mysqli_num_rows($result) == 0){
    echo "<div class='alert alert-info noresults'>There are no journeys matching your search!</div>"; exit;
}

echo "<div class='alert alert-info journeysummary' style='margin-top: 23px; border-radius: 10px; white-space: nowrap;'><i class='fa-solid fa-signs-post' style='color: #31708F; '></i> From <span style='color: black'>$departure</span> to <span style='color: black'>$destination</span><br />Closest Journeys:</div>";
echo '<div id="message">';

//cycle through trips and find close ones
//retrieve each row in $result

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $trip_id = $row['trip_id'];

    // Check if the trip date is in the past
    $dateOK = 1;
    $source = $row['date'];
    $tripDate = DateTime::createFromFormat('D d M, Y', $source);
    $today = date("D d M, Y");
    $todayDate = DateTime::createFromFormat('D d M, Y', $today);
    $dateOK = ($tripDate > $todayDate);

    // If the date is ok
    if ($dateOK && $row['seatsavailable'] > 0) {
        // Get trip user id
        $person_id = $row['user_id'];

        // Run query to get user details
        $sql2 = "SELECT * FROM users WHERE user_id='$person_id' LIMIT 1";
        $result2 = mysqli_query($link, $sql2);

        if ($result2) {
            $sql3 = "SELECT * FROM carinformation WHERE user_id='$person_id'";
            $row3 = mysqli_fetch_array(mysqli_query($link, $sql3));
            // Get user details
            $row2 = mysqli_fetch_array($result2);

            // Get phone number
            if ($_SESSION['user_id']) {
                $phonenumber = $row2['phonenumber'];
            } else {
                $phonenumber = "Please sign up! Only members have access to contact information.";
            }

            // Get picture
            $picture = $row3['carpicture'];
            // Get firstname
            $firstname = $row2['first_name'];

            $lastname = $row2['last_name'];

            // Get gender
            $gender = $row2['gender'];

            // More information
            $moreInformation = $row2['moreinformation'];

            // Get trip departure
            $tripDeparture = $row['departure'];

            // Get trip destination
            $tripDestination = $row['destination'];

            // Get trip price
            $tripPrice = $row['price'];

            // Get seats available in the trip
            $seatsAvailable = $row['seatsavailable'];

            // Get trip date and time
            $frequency = "One-off journey.";
            $time = $row['date'] . " at " . $row['time'] . ".";

            // Print trip
            echo "
<style> 

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' integrity='sha512-8d3Tq8AqxiWRHZWxZxO4umqnYtCgGRW2M32dgKl07G9AMbTkukvXjpzEW9C9jHMd0Q3qhe5V8RUIj4Q9/b+iJQ==' crossorigin='anonymous' referrerpolicy='no-referrer' />
.button-6 {
  align-items: center;
  background-color: #337ab7;
  border: 1px solid rgba(246,246,246,0.1);
  border-radius: .25rem;
  box-shadow: rgba(255,255,255,0.02) 0 1px 3px 0;
  box-sizing: border-box;
  color: rgba(255,255,255,0.85);
  cursor: pointer;
  display: inline-flex;
  font-weight: 600;
  justify-content: center;
  line-height: 1.25;
  margin: 0;
  min-height: 3rem;
  padding: calc(.875rem - 1px) calc(1.5rem - 1px);
  position: relative;
  text-decoration: none;
  transition: all 250ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: baseline;
  width: auto;
}

.button-6:hover,
.button-6:focus {
  border-color: rgba(255,255,255,0.15);
  box-shadow: rgba(255,255,255,0.1) 0 4px 12px;
  color: rgba(255,255,255,0.65);
}

.button-6:hover {
  transform: translateY(-1px);
}

.button-6:active {
  background-color: #337ab7;
  border-color: rgba(0, 0, 0, 0.15);
  box-shadow: rgba(0, 0, 0, 0.06) 0 2px 4px;
  color: rgba(0, 0, 0, 0.65);
  transform: translateY(0);
}
.line-container {
            position: relative;
            width: 300px;
            height: 200px;
        }

    .line {
        position: absolute;
        top: 51.9%;
        left: 12px;
        right: 20px;
        height: 4px;
        width: 258px;
        background-color: #000;
    }

    .pin {
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: #ffffff00;
        border: 2px solid #00000000;
        border-radius: 50%;
        transform: translate(-50%, -50%);
    }

    .pin.start {
        left: 10px;
        top: 50%;
    }

    .pin.end {
        right: 11px;
        top: 50%;
    }

    .letter-container {
        position: absolute;
        top: calc(50% - 25px);
        display: flex;
        width: 100%;
        justify-content: space-between;
        font-family: Arial, sans-serif;
        font-size: 12px;
        font-weight: bold;
    }

    .letter {
    margin-top: 50px;
        position: relative;
        width: 20px;
        text-align: center;
    }

    .letter-b {
    
        margin-right: 23px;
        /* Add your custom styles for the B letter here */
        color: rgb(0, 0, 0); /* Example: change the color to red */
    }

    .fa-solid  {
        margin-bottom: 30px;
        margin-left: 4px;
        color: rgb(0, 0, 0);
        height: 30px;
        

    }
    .icon {
  width: 24px;
  height: 24px;
}

.other-icon{
height: 50px;
}

</style>
    <script src='https://kit.fontawesome.com/49abe375a7.js' crossorigin='anonymous'></script>

            
                <a href='viewtrip.php?trip_id=$trip_id'>
                    <div class='results-container' data-price='$tripPrice' data-date='" . $row['date'] . "' style='border-radius: 30px; margin-top: 25px; margin-bottom: 10px; background: linear-gradient(to top, rgb(217,237,247),#ecf3fa,rgb(217,237,247))'>
                    <div class='inneer-content' style=' padding: 20px;'>
                        <h4 class='row'>
                        
                            <a></a>
                            

                            <div class='col-sm-8 journey' style='margin-left: 5%'>
                            
                         
                            <div class='line-container'>        
                                 <div class='line'></div>
                                 
                                    <div class='pin start'><i class='fa-solid fa-map-pin'></i></div>
                                            <div class='pin end'><i class='fa-solid fa-map-pin'></i></div>
                                            
                                            <div>   </div>
                                            <div class='letter-container'>
                                                <div class='letter'>
                                                    <div class='letter-inner'><div class='dep-dest'>
                                    <span class='departure' style='font-size: 88%'><b>Departure:</b></span> 
                                    $tripDeparture.
                                </div></div>
                                                </div>
                                                <div class='letter letter-b'>
                                                    <div class='letter-inner'><div>
                                    <span class='destination'style='font-size: 88%'><b>Destination:</b></span> 
                                    $tripDestination.
                                </div>
                                </div>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class='time' style='font-size: 80%'>
                                    <b style='font-family: sans-serif; font-size: 100%'><img style='height: 10%; margin-right: 5px;' class='icon'src='/images/event.ico'>Time & Date: </b>$time
                                    <div style='margin-top: 7px;'> <div style='white-space: nowrap;'><img style='height: 10%; margin-right: 5px;' class='icon'src='/images/id-card-regular.svg'>
                                    </i>
                                    <span style='font-size: 95%; margin-top: 5px; margin-left: 1.5px;'>Driver Full-Name:</span><b>$firstname $lastname</b> 
                                    
                                </div></div>
                                
                                </div>
                              
                                
                                        </div>
                                        <div class='a'>
                                
                                
                                
                                
                            </div>
                                              
                                
                            </div>
                            
                            
                            

                            <div class='col-sm-2 price journey2'>
                            <div class='automatedbyme' style='margin-left: 40px;'>
                            <div  class='perseat' style='white-space: nowrap;'>
                                    Per Seat
                                </div>
                                <div class='price' style='white-space: nowrap;'>
                                    $tripPrice <b><i class='fa-solid fa-coins other-icon' style=''></i></b>
                                </div>
                                
                                <div class='seatsavailable' style='white-space: nowrap;'>
                                   <i class='fas fa-road'></i> $seatsAvailable Seat left
                                </div>
                                <div style='margin-top: 75px'>
                                "; 
                                if(isset($_SESSION["user_id"])) {
                                    echo "<a href='viewtrip.php?trip_id=$trip_id' class='button-6 btn btn-primary btn-lg active' style='font-size: 50%; background: #337ab7; color: #ffffff; border-radius: 10px;' role='button' aria-pressed='true' >View Trip </a>";}
                                else {
                                        echo '<button type="button" class="btn btn-lg green login" data-toggle="modal" data-target="#loginModal" style="font-size: 49%;">Login to Join</button>';
                                }
                                echo "
                                    </div>
                            </div>
                            </div>

                        </h4>

                    </div>

                    </div>
                </a>";

        }
    }
}

echo "</div>";

