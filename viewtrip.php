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
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={API_KEY}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-chat-js/1.3.2/simple-chat.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simple-chat-js/1.3.2/simple-chat.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-chat-js/1.3.2/simple-chat.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simple-chat-js/1.3.2/simple-chat.min.js"></script>
      <link rel="shortcut icon" type="image/png" href="/images/favicon2.ico">
      <meta property="og:image" content="/images/favicon.png" />

    <style>
        
        .container{
            margin-top: 100px;
            
            text-align: center;
        }
        
        .border-right {
            border-right: 1px solid white;
        }

        hr { background-color: white; height: 1px; border: 0; }

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

        .card-title {
            color: white;
        }

        .d-flex > div {
            color: white;
        }
        #chat-window-container {
            position: fixed;
            bottom: 0px;
            right: 20px;
            width: 325px;
            height: 420px;
            border: 1px solid #ccc;
            
            transition: height 0.3s ease;
        }

        #chat-window-container iframe {
            width: 100%;
            height: 100%;
            border: none;
            overflow: hidden;
        }


    </style>

<body>

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
$frequency = "One-off journey.";
$time = $row['date']." at " .$row['time'].".";
$time2 = $row['time'];
$date = $row['date'];
$price = $row['price'];


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
$seatsleft = $row['seatsavailable'];

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

$sql4 = "SELECT * FROM carinformation WHERE user_id = $driver_id";
$result4 = mysqli_query($link, $sql4);
$row4 = mysqli_fetch_array($result4);
$plate = $row4['plate'];
$brand = $row4['brand'];
$model = $row4['model'];
$year = $row4['year'];
$carpicture = $row4['carpicture'];
echo
'<div class="container" style="color: black">
<div class="row">
  <div class="col-md-8 border-right">
    <div class="card">
      <div class="card-body">

        <h4 class="card-title" style="background: linear-gradient(to left, #002949, transparent); color: white; border-radius: 10px; padding: 5px;">TRIP DETAILS</h4>

        <div class="d-flex flex-wrap justify-content-between align-items-center">
          <div>
            <i class="fas fa-map-marker-alt"></i>'.$departure.' - <i class="fas fa-map-marker-alt"></i> '.$destination.'
          </div>
          <div>
            <i class="fas fa-calendar-alt"></i> '.$time.'
          </div>
          <div>
            <i class="fas fa-clock"></i> '.$row['price'].' per seat
          </div>
          <div>
            <i class="fas fa-road"></i> '.$seatsleft. ' seats left
          </div>
        </div>
        <hr>
        <div id="googleMap"></div>    
        
      </div>
    </div>
            <!--CAR INFORMATIONS-->
        <hr>
<div class="card-title" style="margin-bottom: 70px;">

    <div style="display: flex; align-items: center;">
        <div style="flex: 1;">
            <h4 class="card-title" style="color: white; background: linear-gradient(to left, #002039, transparent); color: white; border-radius: 10px; padding: 5px;">Car Information</h4>
    <p>Plate: ' .$plate. '</p>
    <p>Brand: ' .$brand. '</p>
    <p>Model: ' .$model. '</p>
    <p>Year: ' .$year. '</p>
        </div>
        <div style="flex: 1; text-align: right;">
            <img class="driver-picture" style="height: 200px; width: 235px;" src="'.$carpicture.'" alt="Car Profile Picture">
        </div>
    </div>
</div>

        
        <!--CAR INFORMATIONS ENDS-->
  </div>
  
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title" style="background: linear-gradient(to right, #002949, transparent); color: white; border-radius: 10px; padding: 5px;">Participants</h4>


        <hr>
        <h5 class="card-title" style="color: white; background: linear-gradient(to right, #2eb26b, transparent); color: white; border-radius: 10px; padding: 5px;">Driver</h5>
          <a href="profile.php?u=' .$driver_id.'">
            <img class="driver-picture" src="'.$driver_profile_picture.'" alt="Driver Profile Picture">
          </a>
        <p style="color: white">' . $driver_first_name . ' ' . $driver_last_name . '</p>
        

        <hr>
        <h4 class="card-title" style="background: linear-gradient(to right, #002949, transparent); color: white; border-radius: 10px; padding: 5px;">Passengers</h4>
        <div class="col-12">';
            foreach ($passengers as $passenger_id) {
                $sql4 = "SELECT * FROM users WHERE user_id = $passenger_id";
                $result4 = mysqli_query($link, $sql4);
                $row4 = mysqli_fetch_array($result4);
                $passenger_id = $row4['user_id'];
                $passenger_first_name = $row4['first_name'];
                $passenger_last_name = $row4['last_name'];
                $passenger_profile_picture = $row4['profilepicture'];
                if(empty($driver_profile_picture)){
                    $driver_profile_picture = "noimage.jpg";
                }
                echo '<span class="col-sm-4">
                        <a href="profile.php?u='.$passenger_id.'">
                          <img class="passenger-picture" src="'.$passenger_profile_picture.'" alt="Profile Picture">
                        </a>
                        <p style="color: white">' .$passenger_first_name . ' ' . $passenger_last_name . '</p>
                      </span>';
            }
        echo '</div>';
        echo '</div>';
        echo'</div>';
    echo '</div>';
    echo '<div id="trip-details" data-trip-id="'.$trip_id.'" data-passenger-id="'.$_SESSION['user_id'].'" data-driver-id="'.$driver_id.'"></div>';

    if ($driver_id == $_SESSION['user_id']) {
        echo '<button class="btn"><a style="padding-bottom: 15px;" href="mainpageloggedin.php">Back to My Trips</a></button>';
    } else if (in_array($_SESSION['user_id'], $passengers)) {
        echo '<button class="btn btn-primary" id="leave-passenger-btn">Leave the Trip</button>';
        echo '<div id="confirmation-section" style="display: none; padding-top: 15px;" data-trip-id="' . $trip_id . '" data-passenger-id="' . $_SESSION['user_id'] . '" data-driver-id="' . $driver_id . '">
            <button class="btn btn-primary" id="picked-up-btn">I was picked up</button>
            <button class="btn btn-primary" id="not-picked-up-btn">I wasn\'t picked up</button>
        </div>';
        echo '<div id="refund-message" style="display: show; color: #f2f2f2; padding-top: 10px; padding-left: 10px;">Leaving the trip before 1 hour results in an 80% refund of the payment amount.</div>';
    } else {
        if ($seatsleft == 0) {
            echo '<div style="color:#ffffff;">No seats available. Trip is full.</div>';
            echo '<a href="index.php" class="btn btn-primary">Back to Home</a>';
        } else {
            // Check if the user has sufficient funds
            $sql5 = "SELECT balance FROM wallet WHERE user_id = " . $_SESSION['user_id'];
            $result5 = mysqli_query($link, $sql5);
            $balance = mysqli_fetch_array($result5)['balance'];
            if ($balance > $price) {
                echo '<button class="btn btn-primary" id="add-passenger-btn">Join Now</button>';
            } else {
                
                echo '<a href="wallet.php" class="btn btn-primary">Add Funds</a>';
                echo '<div id="balance-message" style="display: show; color: #f2f2f2; padding-top: 10px; padding-left: 10px;">You have insufficient amount of funds.</div>';
            }
        }
    }

?>



  <div id="chat-window-container" style="height: 35px;">
  <div id="navbar" style="height: 35px;">
    <button id="collapseBtn" style="background:#1b1759; color: white;width:100%; height:100%;"onclick="toggleChat()">Chat</button>
  </div>
    <iframe id="chatFrame" src="loadnotes.php?trip_id=<?php echo $trip_id?>" frameborder="0"></iframe>
  </div>



<!--Edit a trip form-->
<form method="post" id="edittripform">
    <div class="modal" id="edittripModal" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h4 id="myModalLabel2">Edit trip:</h4>
                </div>
                <div class="modal-body">
                    <!--Error message from PHP file-->
                    <div id="result2"></div>
                    <div class="form-group">
                        <label for="departure2" class="sr-only">Departure:</label>
                        <input type="text" name="departure2" id="departure2" placeholder="Departure" class="form-control" value="<?php echo $departure; ?>">
                    </div>
                    <div class="form-group">
                        <label for="destination2" class="sr-only">Destination:</label>
                        <input type="text" name="destination2" id="destination2" placeholder="Destination" class="form-control" value="<?php echo $destination; ?>">
                    </div>
                    <div class="form-group">
                        <label for="price2" class="sr-only">Price:</label>
                        <input type="number" name="price2" id="price2" placeholder="Price" class="form-control" value="<?php echo $row['price']; ?>">
                    </div> 
                    <div class="form-group">
                        <label for="seatsavailable2" class="sr-only">Seats available:</label>
                        <input type="number" name="seatsavailable2" placeholder="Seats available" class="form-control" id="seatsavailable2" value="<?php echo $seatsleft; ?>">
                    </div>  
                    <div class="form-group date2">
                    <input name="date2" id="date2" readonly="readonly" placeholder="Date"  class="form-control" value="<?php echo $date; ?>">
                </div>  
                <div class="form-group time regular2 time2">
                    <label for="time2" class="sr-only">Time: </label>    
                    <input type="time" name="time2" id="time2" placeholder="Time"  class="form-control" value="<?php echo $time2; ?>">
                </div>
                </div>
                <div class="modal-footer">
                    <input class="btn green" name="submit" type="submit" value="Save changes">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="map2.js"></script> 
<script>
    // Pass departure and destination values to the calcRoute function
    var departure = "<?php echo $departure; ?>";
    var destination = "<?php echo $destination; ?>";
    calcRoute2(departure, destination);
</script>
<script>
$(document).ready(function() {
  var tripTime = new Date("<?php echo $date . ' ' . $time2; ?>");
  var currentTime = new Date();
  var passengersArray = <?php echo json_encode($passengers); ?>;
  var user_id = <?php echo $_SESSION['user_id']; ?>;

  for (var i = 0; i < passengersArray.length; i++) {
    passengersArray[i] = parseInt(passengersArray[i]);
  }

  if (currentTime > tripTime && passengersArray.includes(user_id)) {
    console.log("Trip is in the past and user is a passenger");
    $("#leave-passenger-btn").hide();
    $("#add-passenger-btn").hide();
    $("#confirmation-section").show();

    // Calculate remaining time in seconds
    var remainingTime = Math.floor((currentTime - tripTime) / 1000);

    // Show or hide the refund message based on remaining time
    if (remainingTime <= 3600) {
      $("#refund-message").show();
    } else {
      $("#refund-message").hide();
    }
  } else if (currentTime > tripTime) {
    console.log("Trip is in the past");
    $("#leave-passenger-btn").hide();
    $("#add-passenger-btn").hide();
  } else {
    console.log("Trip is in the future");
  }
});

//Calendar Input
$('input[name="date2"], input[name="date"]').datepicker({
    showAnim: "fadeIn",
    numberOfMonths: 1,
    dateFormat: "D d M, yy",
    minDate: +1,
    maxDate: "+12M",
    showWeek: true
});

$(document).ready(function() {
    // Event handler for "I was picked up" button
    $("#picked-up-btn").click(function() {
        $(this).hide(); // Hide the button
        $("#not-picked-up-btn").hide(); // Hide the other button
        $("#confirmation-section").html("You have confirmed that you were picked up."); // Update the message
        $("#confirmation-section").show(); // Show the updated message
    });

    // Event handler for "I wasn't picked up" button
    $("#not-picked-up-btn").click(function() {
        $(this).hide(); // Hide the button
        $("#picked-up-btn").hide(); // Hide the other button
        $("#confirmation-section").html("You have confirmed that you were not picked up. Your funds have been added back to your balance"); // Update the message
        $("#confirmation-section").show(); // Show the updated message
    });


});

</script>
<script>
function toggleChat() {
  var chatFrame = document.getElementById("chat-window-container");
  if (chatFrame.style.height === "35px") {
    chatFrame.style.height = "420px";
  } else {
    chatFrame.style.height = "35px";
  }
}
</script>

<script src="js/bootstrap.min.js"></script>
<script src="trip_confirmation.js"></script>
<script src="javascript.js"></script>

</head>
</html>