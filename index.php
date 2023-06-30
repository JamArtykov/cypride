<?php
session_start();
include('connection.php');

//logout
include('logout.php');

//remember me
include('remember.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cypride</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="styling.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/sunny/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key={API_KEY}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /*margin top for myContainer*/
        #myContainer {
            margin-top: 90px;
            text-align: center;
            color: black;
        }

        /*header size*/
        #myContainer h1{
            font-size: 5em;
        }

        .bold{
            font-weight: bold;
        }
        #googleMap{
            width: 100%;
            height: 30vh;
            margin: 10px auto;
        }
        .signup{
            margin-top: 20px;
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
        #results{
            margin-bottom: 100px;
        }
        .driver{
            font-size:1.5em;
            text-transform:capitalize;
            text-align: center;
        }
        .price{
            font-size:1.5em;
        }
        .departure, .destination{
            font-size:1.5em;
        }
        .perseat{
            font-size:0.5em;
        }
        .journey{
            text-align:left;
        }
        .journey2{
            text-align:right;
        }
        .time{
            margin-top:10px;
        }
        .telephone{
            margin-top:10px;
        }
        .seatsavailable{
            font-size:0.7em;
            margin-top:5px;
        }
        .moreinfo{
            text-align:left;
        }
        .aboutme{
            border-top:1px solid grey;
            margin-top:15px;
            padding-top:5px;
        }
        #message{
            margin-top:20px;
        }
        .journeysummary{
            text-align:left;
            font-size:1.5em;
        }
        .noresults{
            text-align:center;
            font-size:1.5em;
        }

        .previewing{
            max-width: 100%;
            height: auto;
            border-radius: 50%;
        }
        .previewing2{
            margin: auto;
            height: 20px;
            border-radius: 50%;
        }

        .footerlogo{
            height: 60px;
        }

        .modal-dialog {
            width: 100%;
            max-width: 600px;
            margin: 10% auto;
        }

        @media only screen and (max-width: 768px) {
            .modal-dialog {
                margin: 20px;
            }
        }

        .slogan{
            font-family: "Century751 No2 BT";
            color: aliceblue;
        }

        .results-container {
            background-color: white;
        }
        .trip-row {
            /* Add your desired styles for each row here */
            background-color: #f2f2f2;
            margin-bottom: 10px;
            /* ... */
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





<div class="container-fluid" id="myContainer">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="slogan" id="slogan">
                <div class="row">
                    <p class="text1slogan" style="font-size:40px">Share a ride, reduce your carbon footprint</p>
                    <!--                          <p class="text1slogan" style="font-size:50px">Join the ride-sharing community</p>-->
                    <p class="text1slogan" style="font-size:50px">Ride-sharing made easy</p>
                </div>


            </div>
            <!--Search Form-->
            <form class="form-inline" method="get" id="searchform">
                <div class="form-group">
                    <label class="sr-only" for="departure">Departure:</label>
                    <input type="text" class="form-control" id="departure" placeholder="Departure" name="departure">
                </div>
                <div class="form-group">
                    <label class="sr-only"></label>
                    <input type="text" class="form-control" id="destination" placeholder="Destination" name="destination">
                </div>
                <input type="submit" value="Search" class="btn btn-lg green" name="search">
                <button id="filterBtn" class="btn btn-lg blue"><i style="font-size:22px" class="fa fa-filter"></i></button>

            </form>

            <div style="margin-top: 10px;"></div>
            <!--Search Form End-->

            <!--                  Filter Form Start-->
            <form class="form-inline">
                <div id="filterOptions" style="display: none;" style="margin-top: 10px;">
                    <!-- Add your desired filter options here -->
                    <!-- For example, you can add filters for date, price, etc. -->
                    <!-- Make sure to give appropriate IDs and names to the filter elements -->
                    <label for="filterDate"></label>
                    <input type="text" class="form-control" id="filterDate" placeholder="Date" name="filterDate">
                    <label for="filterPrice"></label>
                    <input type="text" class="form-control" id="filterPrice" placeholder="Price" name="filterPrice">
                    <!-- Add more filter options as needed -->
                    <button id="applyFiltersBtn" class="btn btn-primary">Apply Filters</button>
                    <button id="resetFiltersBtn" class="btn btn-secondary"><i class="fa fa-refresh fa-spin" style="font-size:19px"></i></button>
                </div>
            </form>

            <script>
                $(document).ready(function() {
                    // Handle the click event for the filter button
                    $("#filterBtn").click(function(event) {
                        // Prevent the form from being submitted
                        event.preventDefault();

                        // Toggle the visibility of the filter options
                        $("#filterOptions").toggle();

                        // Add your own logic or functionality for the filter button click event
                        console.log('Filter button clicked!');
                        // ...
                    });
                    $("#applyFiltersBtn").click(function(event) {
                        event.preventDefault();

                        // Apply the filters
                        applyFilters();
                    });

                    $("#resetFiltersBtn").click(function(event) {
                        event.preventDefault();

                        // Reset the filters
                        resetFilters();
                    });
                    // Calendar Input
                    $('input[name="date2"], input[name="date"], #filterDate').datepicker({
                        showAnim: "fadeIn",
                        numberOfMonths: 1,
                        dateFormat: "D d M, yy",
                        minDate: +1,
                        maxDate: "+12M",
                        showWeek: true
                    });
                });

                function applyFilters() {
                    var filterDate = $("#filterDate").val();
                    var filterPrice = $("#filterPrice").val();

                    // Hide all result items initially
                    $(".results-container").hide();
                    console.log("Date: " + filterDate);

                    // Loop through each result item and apply the filters
                    $(".results-container").each(function() {
                        var date = $(this).data("date");
                        var price = $(this).data("price");
                        console.log("Date2: " + date);
                        // Check if the result item matches the filter criteria
                        if ((!filterDate || date === filterDate) &&
                            (!filterPrice || price <= filterPrice)) {
                            $(this).show(); // Show the result item
                        }
                    });
                    $('html, body').animate({
                    scrollTop: $('#results').offset().top
                    }, 800); 
                }

                function resetFilters() {
                    // Clear the filter values
                    $("#filterDate").val("");
                    $("#filterPrice").val("");

                    // Show all result items
                    $(".results-container").show();
                }

            </script>
            <script>
                $(document).ready(function() {
                $('#search').click(function(event) {
                    event.preventDefault(); 

                    // Scroll to the div with id="results"
                    $('html, body').animate({
                    scrollTop: $('#results').offset().top
                    }, 800); 
                });
                });
            </script>

            <!--Google Map-->
            <div id="googleMap"></div>

            <!--Sign up button-->
            <?php
            if(!isset($_SESSION["user_id"])){
                echo '<button type="button" class="btn btn-lg green signup" data-toggle="modal" data-target="#signupModal">Sign up to Participate</button>';
            }
            ?>


            <div id="results">

                <!--will be filled with Ajax Call-->
            </div>



        </div>

    </div>

</div>

<!--Login form-->


<form method="post" id="loginform">
    <div class="modal" id="loginModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" padding-top="200px">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h4 id="myModalLabel">
                        Login:
                    </h4>
                </div>
                <div class="modal-body">

                    <!--Login message from PHP file-->
                    <div id="loginmessage"></div>


                    <div class="form-group">
                        <label for="loginemail" class="sr-only">Email:</label>
                        <input class="form-control" type="email" name="loginemail" id="loginemail" placeholder="Email" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label for="loginpassword" class="sr-only">Password</label>
                        <input class="form-control" type="password" name="loginpassword" id="loginpassword" placeholder="Password" maxlength="30">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="rememberme" id="rememberme">
                            Remember me
                        </label>
                        <a class="pull-right" style="cursor: pointer" data-dismiss="modal" data-target="#forgotpasswordModal" data-toggle="modal">
                            Forgot Password?
                        </a>
                    </div>

                </div>
                <div class="modal-footer">
                    <input class="btn green" name="login" type="submit" value="Login">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">
                        Register
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>



<!--Sign up form-->
<form method="post" id="signupform">
    <div class="modal" id="signupModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h4 id="myModalLabel">
                        Sign up today and Start using our Trip Sharing App!
                    </h4>
                </div>
                <div class="modal-body">

                    <!--Sign up message from PHP file-->
                    <div id="signupmessage"></div>

                    <div class="form-group">
                        <label for="username" class="sr-only">Username:</label>
                        <input class="form-control" type="text" name="username" id="username" placeholder="Username" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="sr-only">Firstname:</label>
                        <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Firstname" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="sr-only">Lastname:</label>
                        <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Lastname" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="email" class="sr-only">Email:</label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="Email Address" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label for="password" class="sr-only">Choose a password:</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Choose a password" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="password2" class="sr-only">Confirm password</label>
                        <input class="form-control" type="password" name="password2" id="password2" placeholder="Confirm password" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label for="phonenumber" class="sr-only">Telephone:</label>
                        <input class="form-control" type="text" name="phonenumber" id="phonenumber" placeholder="Telephone Number" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label><input type="radio" name="gender" id="male" value="male">Male</label>
                        <label><input type="radio" name="gender" id="female" value="female">Female</label>
                    </div>
                    <div class="form-group">
                        <label for="moreinformation">Comments: </label>
                        <textarea name="moreinformation" class="form-control" rows="5" maxlength="300"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="btn green" name="signup" type="submit" value="Sign up">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!--Forgot password form-->
<form method="post" id="forgotpasswordform">
    <div class="modal" id="forgotpasswordModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h4 id="myModalLabel">
                        Forgot Password? Enter your email address:
                    </h4>
                </div>
                <div class="modal-body">

                    <!--forgot password message from PHP file-->
                    <div id="forgotpasswordmessage"></div>


                    <div class="form-group">
                        <label for="forgotemail" class="sr-only">Email:</label>
                        <input class="form-control" type="email" name="forgotemail" id="forgotemail" placeholder="Email" maxlength="50">
                    </div>
                </div>
                <div class="modal-footer">
                    <input class="btn green" name="forgotpassword" type="submit" value="Submit">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">
                        Register
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Footer -->
<div class="footer" style="background-color: rgb(255,255,255)">
    <div class="container">
        <a style="color: #000000; width:10%; line-height: 60px; float: left;" href="mainpagefaq.php">FAQ</a>
        <a style="color: #030303; width:10%; line-height: 60px; float: left; margin-left: 10px;" href="contactus.php">Contact Us</a>
        <p style="color: #000000; width:10%; line-height: 60px; float: right;">CypRIDE 2023</p>
        <img class="footerlogo" src="logo.png" style="float: right;">
    </div>
</div>


<!--Spinner-->
<div id="spinner">
    <img src='ajax-loader.gif' width="64" height="64" />
    <br>Loading..
</div>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="map.js"></script>
<script src="javascript.js"></script>
</body>
</html>