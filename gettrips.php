<?php
// Start session and connect to the database
session_start();
include('connection.php');

// Retrieve all trips for the user
$sql = "SELECT * FROM carsharetrips WHERE user_id = '" . $_SESSION['user_id'] . "'";

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $activeTrips = array(); // Array to store active trips
        $passedTrips = array(); // Array to store passed trips
        $joinedTrips = array(); // Array to store joined trips

        $currentDateTime = date('Y-m-d H:i:s');
        $currentDateTimeTimestamp = strtotime($currentDateTime);

        while ($row = mysqli_fetch_array($result)) {
            $tripDate = date('Y-m-d', strtotime($row['date']));
            $tripTime = date('H:i:s', strtotime($row['time']));
            $tripDateTime = $tripDate . ' ' . $tripTime;
            $tripDateTimeTimestamp = strtotime($tripDateTime);


            if ($tripDateTimeTimestamp >= $currentDateTimeTimestamp) {
                $activeTrips[] = $row;
            } else {
                $passedTrips[] = $row;
            }

        }

        // Sort the active trips by date and time
        usort($activeTrips, function($a, $b) {
            return strtotime($a['date'] . ' ' . $a['time']) - strtotime($b['date'] . ' ' . $b['time']);
        });

        // Sort the passed trips by date and time in descending order
        usort($passedTrips, function($a, $b) {
            return strtotime($b['date'] . ' ' . $b['time']) - strtotime($a['date'] . ' ' . $a['time']);
        });

        // Retrieve joined trips
        $joinedTripsQuery = "SELECT carsharetrips.* FROM carsharetrips JOIN trip_participants ON carsharetrips.trip_id = trip_participants.trip_id WHERE trip_participants.user_id = '" . $_SESSION['user_id'] . "' AND trip_participants.is_driver = 0";

        if ($joinedTripsResult = mysqli_query($link, $joinedTripsQuery)) {
            while ($row = mysqli_fetch_array($joinedTripsResult)) {
                $joinedTrips[] = $row;
            }
        }

        // Sort the joined trips by date and time
        usort($joinedTrips, function($a, $b) {
            return strtotime($a['date'] . ' ' . $a['time']) - strtotime($b['date'] . ' ' . $b['time']);
        });

        // Render the sorted trips
        if (!empty($activeTrips)) {
            renderTrips($activeTrips, 'Active Trips');
        }

        if (!empty($joinedTrips)) {
            renderTrips($joinedTrips, 'Joined Trips');
        }

        if (!empty($passedTrips)) {
            renderTrips($passedTrips, 'Passed Trips');
        }
    } else {
        echo '<div class="notrips alert alert-warning">You have not created any trips yet</div>';
    }
}

function renderTrips($trips, $title) {
    echo '<h2 style="color:#ffffff;">' . $title . '</h2>';

    foreach ($trips as $trip) {
        $departure = $trip['departure'];
        $destination = $trip['destination'];
        $date = $trip['date'];
        $time = $trip['time'];
        $regular = $trip['regular'];
        $price = $trip['price'];
        $seatsavailable = $trip['seatsavailable'];
        $trip_id = $trip['trip_id'];

        echo '

<style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-8d3Tq8AqxiWRHZWxZxO4umqnYtCgGRW2M32dgKl07G9AMbTkukvXjpzEW9C9jHMd0Q3qhe5V8RUIj4Q9/b+iJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <script src="https://kit.fontawesome.com/49abe375a7.js"crossorigin="anonymous"></script>


        <div class="row trip" style="background: linear-gradient(to top, rgb(217,237,247),#ecf3fa,rgb(217,237,247));">
            <div class="col-sm-8 journey">
                <div style="margin-top: 10px;"><i class="fa-solid fa-circle-arrow-right"></i> <span class="departure">Departure:</span> ' . $departure . '.</div>
                <div><i class="fa-solid fa-route"></i> <span class="destination">Destination:</span> ' . $destination . '.</div>
                <div class="time"><i class="fa-solid fa-clock"></i> ' . $date . ' at ' . $time . '.</div>
                
            </div>
            <div class="col-sm-2 price" style="margin-top: 30px;">
                <div class="price"> ' . $price . ' <i class="fa-solid fa-coins"></i></div>
                <div class="perseat">Per Seat</div>
                <div class="seatsavailable">' . $seatsavailable . ' left</div>
            </div>
            <div class="col-sm-2">';

        // Display Edit button for active and passed trips
        if ($title !== 'Joined Trips') {
            echo '
                <button class="btn green edit btn-lg" data-target="#edittripModal" data-toggle="modal" data-trip_id="' . $trip_id . '" style="width: 100%;">Edit</button>';
        }

        // Display View button for all trips
        echo '
                <a href="viewtrip.php?trip_id=' . $trip_id . '" class="btn green btn-lg active" style="color: black; margin-top: 10px; width: 100%;" aria-pressed="true" >View</a>
            </div>
        </div>';
    }
}
?>
