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
    <title>Contact Us - Cypride</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="styling.css?v=<?php echo time(); ?>" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/sunny/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=YOUR_GOOGLE_MAPS_API_KEY"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Add your custom styles here */
    </style>
</head>
<style>

    @import url(https://fonts.googleapis.com/css?family=Lato:300,400,700);
    body {
        color: #fff;
        font-weight: 400;
        margin:0;
        padding:0;
        padding-bottom:60px;
    }
    .ccheader {
        margin: 0 auto;
        padding: 2em;
        text-align: center;
    }

    .ccheader h1 {
        margin: 0;
        font-weight: 300;
        font-size: 2.5em;
        line-height: 1.3;
    }
    .ccheader {
        margin: 0 auto;
        padding: 2em;
        text-align: center;
    }

    .ccheader h1 {
        margin: 0;
        font-weight: 300;
        font-size: 2.5em;
        line-height: 1.3;
    }

    /* Form CSS*/
    .ccform {
        margin: 0 auto;
        width: 800px;
    }
    .ccfield-prepend{
        margin-bottom:10px;
        width:100%;
    }

    .ccform-addon{
        color: #000000;
        float:left;
        padding:8px;
        width:8%;
        background:#FFFFFF;
        text-align:center;
    }

    .ccformfield {
        color:#000000;
        background:#FFFFFF;
        border:none;
        padding:15.5px;
        width:78%;
        display:block;
        font-family: 'Lato',Arial,sans-serif;
        font-size:14px;
    }

    .ccformfield {
        font-family: 'Lato',Arial,sans-serif;
    }
    .ccbtn{
        display:block;
        border:none;
        background: #ee9415;
        color:#FFFFFF;
        padding:12px 25px;
        cursor:pointer;
        text-decoration:none;
        font-weight:bold;
    }
    .ccbtn:hover{
        background: #ff0000;

    }
    .credit {
        color:#fff;
        width: 800px;
        clear:both;
        margin:0 auto;
        line-height:25px;
        padding: 25px 50px;
    }
    .credit em{
        margin-right:5px;
    }
    .credit a {
        color: #0d2ed5;
        font-weight: bold;
        text-decoration: none;
    }
    .wrapper {
        background: linear-gradient(to bottom, #23f5ce, #028069);
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

</style>



<body>
<!-- Navigation Bar -->
<?php
if (isset($_SESSION["user_id"])) {
    include("navigationbarconnected.php");
} else {
    include("navigationbarnotconnected.php");
}
?>

<div class="container-fluid" id="myContainer">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="slogan" id="slogan">
                <div class="row">

                </div>


            </div>
            <div id="message"></div>

            <!-- Contact Form -->
            <link href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

            <header class="ccheader">
                <h1>Contact Us</h1>
            </header>

            <div class="wrapper" style=" padding: 20px;">
                <form method="post" action="" class="ccform">
                    <div class="ccfield-prepend">
                        <span class="ccform-addon"><i class="fa fa-user fa-2x"></i></span>
                        <input class="ccformfield" type="text" placeholder="Full Name" required>
                    </div>
                    <div class="ccfield-prepend">
                        <span class="ccform-addon"><i class="fa fa-envelope fa-2x"></i></span>
                        <input class="ccformfield" type="text" placeholder="Email" required>
                    </div>
                    <div class="ccfield-prepend">
                        <span class="ccform-addon"><i class="fa fa-mobile-phone fa-2x"></i></span>
                        <input class="ccformfield" type="text" placeholder="Phone">
                    </div>
                    <div class="ccfield-prepend">
                        <span class="ccform-addon"><i class="fa fa-info fa-2x"></i></span>
                        <input class="ccformfield" type="text" placeholder="Subject" required>
                    </div>
                    <div class="ccfield-prepend">
                        <span class="ccform-addon"><i class="fa fa-comment fa-2x"></i></span>
                        <textarea class="ccformfield" name="comments" rows="8" placeholder="Message" required></textarea>
                    </div>
                    <div class="ccfield-prepend">
                        <input class="ccbtn" type="submit" value="Submit">
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle the form submission
        $("#contactForm").submit(function(event) {
            event.preventDefault();

            // Clear previous messages
            $("#message").html("");

            // Get form data
            var name = $("#name").val();
            var email = $("#email").val();
            var message = $("#message").val();

            // Make an AJAX call to the server
            $.ajax({
                url: "contact.php",
                method: "POST",
                data: {
                    name: name,
                    email: email,
                    message: message
                },
                success: function(data) {
                    // Display success message
                    $("#message").html("<div class='alert alert-success'>" + data + "</div>");

                    // Clear form fields
                    $("#name").val("");
                    $("#email").val("");
                    $("#message").val("");
                },
                error: function() {
                    // Display error message
                    $("#message").html("<div class='alert alert-danger'>There was an error while submitting the form. Please try again later.</div>");
                }
            });
        });
    });
</script>
</body>
</html>