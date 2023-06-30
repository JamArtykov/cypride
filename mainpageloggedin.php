<?php
session_start();
include('connection.php');
if(!isset($_SESSION['user_id'])){
    header("location: index.php");
}
?>

<?php
$user_id = $_SESSION['user_id'];

//get username and email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if($count == 1){
    $row = mysqli_fetch_array($result, MYSQL_ASSOC); 
    $username = $row['username'];
    $picture = $row['profilepicture'];
}else{
    echo "There was an error retrieving the username and email from the database";   
}

$car_check_query = "SELECT * FROM carinformation WHERE user_id='$user_id'";
$car_check_result = mysqli_query($link, $car_check_query);
$car_check_count = mysqli_num_rows($car_check_result);
$row = mysqli_fetch_array($car_check_result);
$has_car_info = false;
if ($car_check_count > 0) {
    $has_car_info = true;
}

$plate = $row['plate'];
$brand = $row['brand'];
$model = $row['model'];
$year = $row['year'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Trips</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/sunny/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="styling.css?v=<?php echo time(); ?>" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={API_KEY}"></script>
      <style>
        #container{
            margin-top:120px;   
        }

        #notePad, #allNotes, #done, .delete{
            display: none;   
        }

        textarea{
            width: 100%;
            max-width: 100%;
            font-size: 16px;
            line-height: 1.5em;
            border-left-width: 20px;
            border-color: #CA3DD9;
            color: #CA3DD9;
            background-color: #FBEFFF;
            padding: 10px;
              
        }
        
        .noteheader{
            border: 1px solid grey;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            padding: 0 10px;
            background: linear-gradient(#FFFFFF,#ECEAE7);
        }
          
        .text{
            font-size: 20px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
          
        .timetext{
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .notes{
            margin-bottom: 100px;
        }
          
        #googleMap{
            width: 300px;
            height: 200px;
            margin: 30px auto;
        }
        .modal{
            z-index: 20;   
        }
        .modal-backdrop{
            z-index: 10;        
        }
        #spinner{
          display: none;
          position: fixed;
          top: 0;
          left: 0;
          bottom: 0;
          right: 0;
          height: 85px;
          text-align: center;
          margin: auto;
          z-index: 1100;
      }
        .checkbox{
            margin-bottom: 10px;   
        }
        .trip{
            border:1px solid grey;
            border-radius: 10px;
            margin-bottom:10px;
            background: linear-gradient(#ECE9E6, #FFFFFF);
            padding: 10px;
        }
        .price{
            font-size:1.5em;
        }
        .departure, .destination{
            font-size:1.5em;
        } 
        .perseat{
            font-size:0.5em;
    /*        text-align:right;*/
        }
        .time{
            margin-top:10px;  
        }  
        .notrips{
            text-align:center;
        }
        .trips{
            margin-top: 20px;
        }
        .previewing2{
            margin: auto;
            height: 20px;
            border-radius: 50%;
        }
        .update-car-btn{
            padding-right: 20px;
        }
        .btn-group {
            margin-bottom: 20px; 
        }
        #mytrips{
            margin-bottom: 100px;   
        }
        .h2 {
            color: #FFFFFF;
        }
        

      </style>
  </head>
  <body>
    <!--Navigation Bar-->  
    <?php
    if(isset($_SESSION["user_id"])){
        include("navigationbarconnected.php");
    }else{
        include("navigationbarnotconnected.php");
    }  
    ?>
    
<!--Container-->
      <div class="container" id="container">
          <div class="row">
              <div class="col-sm-8 col-sm-offset-2">
              <div>
                    <?php
                    
                        if ($has_car_info) {                       
                            echo '<div style="display: flex; justify-content: space-between;">';
                            echo '<button type="button" class="btn green btn-lg" data-target="#editcarModal" data-toggle="modal">Update Car Information</button>';
                            echo '<button type="button" class="btn green btn-lg" data-target="#addtripModal" data-toggle="modal">Add trips</button>';
                            echo '</div>';
                        } else {                
                            echo '<button type="button" class="btn green btn-lg" data-target="#addCarModal" data-toggle="modal">Add car information</button>';
                        }
                    ?>
                </div>
                <hr>
                  <div id="mytrips" class="trips">
                      <!--Ajax Call to php file-->
                  </div>
              </div>

          </div>
      </div>
      
    <!--Add a car form-->
    <form method="post" name="carpicture" id="addcarform" enctype="multipart/form-data">
    <div class="modal" id="addCarModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h4 id="myModalLabel">
                        Add new car to add new trips!
                    </h4>
                </div>
                <div class="modal-body">
                    <!--Error message from PHP file-->
                    <div id="carFormResult"></div>
                    <div class="form-group">
                        <label for="plate" class="sr-only">Plate:</label>
                        <input type="text" name="plate" id="plate" placeholder="Plate" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="brand" class="sr-only">Brand:</label>
                        <input type="text" name="brand" id="brand" placeholder="Brand" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="model" class="sr-only">Model:</label>
                        <input type="text" name="model" id="model" placeholder="Model" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="year" class="sr-only">Year:</label>
                        <input type="number" name="year" id="year" placeholder="Year" class="form-control">
                    </div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="16777216"> <!-- 16MB limit -->
                    <div class="form-group">
                        <label for="carpicture" class="sr-only">Car Picture:</label>
                        <input type="file" name="carpicture" id="carpicture" class="form-control">
                    </div>
                    <!-- Add more input fields as needed -->
                </div>
                <div class="modal-footer">
                    <input class="btn btn-primary" name="createCar" type="submit" value="Create Car">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Edit car form -->
<form method="post" id="editcarform">
    <div class="modal" id="editcarModal" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h4 id="myModalLabel3">Edit Car Information:</h4>
                </div>
                <div class="modal-body">
                    <!-- Error message from PHP file -->
                    <div id="result3"></div>
                    <div class="form-group">
                        <label for="plate2" class="sr-only">Plate:</label>
                        <input type="text" name="plate2" id="plate2" placeholder="Plate" class="form-control" value="<?php echo $plate; ?>">
                    </div>
                    <div class="form-group">
                        <label for="brand2" class="sr-only">Brand:</label>
                        <input type="text" name="brand2" id="brand2" placeholder="Brand" class="form-control" value="<?php echo $brand; ?>">
                    </div>
                    <div class="form-group">
                        <label for="model2" class="sr-only">Model:</label>
                        <input type="text" name="model2" id="model2" placeholder="Model" class="form-control" value="<?php echo $model; ?>">
                    </div> 
                    <div class="form-group">
                        <label for="year2" class="sr-only">Year:</label>
                        <input type="text" name="year2" id="year2" placeholder="Year" class="form-control" value="<?php echo $year; ?>">
                    </div>
                    <div class="form-group">
                        <label for="carpicture2" class="sr-only">Car Picture:</label>
                        <input type="file" name="carpicture2" id="carpicture2" class="form-control">
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


<!--Add a trip form-->
<form method="post" id="addtripform">
  <div class="modal" id="addtripModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            &times;
          </button>
          <h4 id="myModalLabel">
            New trip:
          </h4>
        </div>
        <div class="modal-body">

          <!--Error message from PHP file-->
          <div id="result5"></div>

          <!--Google Map-->
          <div id="googleMap"></div>

          <div class="form-group">
            <label for="departure" class="sr-only">Departure:</label>
            <input type="text" name="departure" id="departure" placeholder="Departure" class="form-control">
          </div>
          <div class="form-group">
            <label for="destination" class="sr-only">Destination:</label>
            <input type="text" name="destination" id="destination" placeholder="Destination" class="form-control">
          </div>
          <div class="form-group">
            <label for="price" class="sr-only">Price:</label>
            <input type="number" name="price" id="price" placeholder="Price" class="form-control">
          </div>
          <div class="form-group">
            <label for="seatsavailable" class="sr-only">Seats available:</label>
            <input type="number" name="seatsavailable" id="seatsavailable" placeholder="Seats available" class="form-control">
          </div>
          <div class="form-group date">
            <label for="date" class="sr-only">Date:</label>
            <input name="date" id="date" readonly="readonly" placeholder="Date" class="form-control">
          </div>
          <div class="form-group time">
            <label for="time" class="sr-only">Time:</label>
            <input type="time" name="time" id="time" placeholder="Time" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <input class="btn btn-primary" name="createTrip" type="submit" value="Create Trip">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>

      <!--Edit a trip form-->
      <form method="post" id="edittripform">
        <div class="modal" id="edittripModal" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>
                  <h4 id="myModalLabel2">
                    Edit trip:
                  </h4>
              </div>
              <div class="modal-body">
                  
                  <!--Error message from PHP file-->
                  <div id="result2"></div>
                  
                <div class="form-group">
                    <label for="departure2" class="sr-only">Departure:</label>
                    <input type="text" name="departure2" id="departure2" placeholder="Departure" class="form-control">
                </div>
                <div class="form-group">
                    <label for="destination2" class="sr-only">Destination:</label>
                    <input type="text" name="destination2" id="destination2" placeholder="Destination" class="form-control">
                </div>
                <div class="form-group">
                    <label for="price2" class="sr-only">Price:</label>
                    <input type="number" name="price2" id="price2" placeholder="Price" class="form-control">
                </div> 
                <div class="form-group">
                    <label for="seatsavailable2" class="sr-only">Seats available:</label>
                    <input type="number" name="seatsavailable2" placeholder="Seats available" class="form-control" id="seatsavailable2">
                </div>  
            
                 
                <div class="form-group date2">
                    <input name="date2" id="date2" readonly="readonly" placeholder="Date"  class="form-control">
                </div>  
                <div class="form-group time regular2 time2">
                    <label for="time2" class="sr-only">Time: </label>    
                    <input type="time" name="time2" id="time2" placeholder="Time"  class="form-control">
                </div>  
              </div>
              <div class="modal-footer">
                <input class="btn btn-primary" name="updatetrip" type="submit" id="updatetrip" value="Edit Trip">
                <input type="button" class="btn btn-danger" name="deletetrip" value="Delete" id="deletetrip">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
          </div>
      </div>
      </div>
      </form>

    <!-- Footer-->
      <div class="footer">
          <div class="container">
              
          </div>
      </div>
      
      <!--Spinner-->
      <div id="spinner">
         <img src='ajax-loader.gif' width="64" height="64" />
         <br>Loading..
      </div>
    <script src="profile.js"></script>                         
    <script src="map.js"></script>  
    <script src="mytrips.js"></script>  
  </body>
</html>