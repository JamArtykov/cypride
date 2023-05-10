<?php
//start session and connect
session_start();
include('connection.php');

//retrieve all trips
$sql="SELECT * FROM carsharetrips WHERE user_id='".$_SESSION['user_id']."'";

if($result = mysqli_query($link, $sql)){
    //print_r($result);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            //check frequency
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

            $trip_id=$row['trip_id'];
            $sql2 = "SELECT * FROM trip_participants WHERE trip_id = $trip_id";
            $result2 = mysqli_query($link, $sql2);
            $num_rows = mysqli_num_rows($result2);
            $seatsleft = $row['seatsavailable'] - $num_rows + 1;

            echo 
             '<div class="row trip href=">

                    <div class="col-sm-8 journey">
                    
                        <div><span class="departure">Departure:</span> '.$row['departure'].'.</div>
                        <div><span class="destination">Destination:</span> '. $row['destination'] .'.</div>
                        <div class="time">'.$time.'</div>
                        <div>'.$frequency.'</div>
                    </div>
                    <div class="col-sm-2 price">
                        <div class="price">$'.$row['price'].'</div>
                        <div class="perseat">Per Seat</div>
                        <div class="seatsavailable">'.$seatsleft.' left</div>
                    </div>
                    <div class="col-sm-2">
                        <button class= "btn green edit btn-lg" data-target="#edittripModal" data-toggle="modal" data-trip_id="'.$row['trip_id'].'">Edit</button>
                        
                        <a href="viewtrip.php?trip_id='.$row['trip_id'].'" class="btn green btn-lg active" style="color: black; margin-top: 10px;" aria-pressed="true">View</a>
                    </div>
                </div>';
        }
    }else{
        echo '<div class="notrips alert alert-warning">You Have not created any trips yet</div>';
    }
}
?>