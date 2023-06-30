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
    <link rel="shortcut icon" type="image/png" href="/images/favicon2.ico">
    <meta property="og:image" content="/images/favicon.png" />
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
        width: %100;
    }
    .ccfield-prepend{
        margin-bottom:10px;
        width:100%;
        display: flex;
        flex-wrap: nowrap;
    }

    .ccform-addon{
        color: #000000;
        height: 51px;
        float:left;
        padding:8px;
        width:50px;
        background:#FFFFFF;
        text-align:center;
        border-radius: 5px 0 0 5px;
    }

    .ccformfield {
        color:#000000;
        background: linear-gradient(to bottom, rgb(232, 232, 232), rgba(236, 236, 236, 0.87));
        border:none;
        padding:15.5px;
        width:92%;
        display:block;
        font-family: 'Lato',Arial,sans-serif;
        font-size:14px;
        border-radius: 0px 5px 5px 0px;

    }

    .ccformfield {
        font-family: 'Lato',Arial,sans-serif;
    }
    .ccbtn{
        display:block;
        border:none;
        background: rgba(255, 255, 255, 0.94);
        border-radius: 5px 5px 5px 5px;
        color: #000000;
        padding:12px 25px;
        cursor:pointer;
        text-decoration:none;
        font-weight:bold;
    }
    .ccbtn:hover{
        color: white;
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
        align-items: center;
        background: linear-gradient(to bottom, rgba(19, 162, 137, 0.6), rgba(5, 30, 128, 0.65));
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        width: %60;
    }

    .container-fluid {

        align-items: center;
        height: 100vh;
    }
    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 9999;
    }

    .popup-content {
        color: white;
        border-radius: 5px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: linear-gradient(to bottom, rgba(19, 162, 137, 0.6), rgba(5, 30, 128, 0.65));
        padding: 20px;
        text-align: center;
    }

    .popup h3 {
        border-radius: 50px;
        margin-top: 0;
    }

    .popup p {
        border-radius: 50px;
        margin-bottom: 0;
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
            <script src="https://kit.fontawesome.com/49abe375a7.js" crossorigin="anonymous"></script>


            <header class="ccheader">
                <h1 style="color: white">Contact Us</h1>
                <p style="color: white">We are here to assist you. Please fill out the form below to get in touch with our support team.</p>
            </header>


            <div class="wrapper" style=" padding: 20px; align-content: center">
                <form method="post" action="" class="ccform" style="">
                    <div class="ccfield-prepend">
                        <span class="ccform-addon"><i class="fa fa-user fa-2x"></i></span>
                        <input class="ccformfield" name="fullname" type="text" placeholder="Full Name" required>
                    </div>
                    <div class="ccfield-prepend">
                        <span class="ccform-addon"><i class="fa fa-envelope fa-2x"></i></span>
                        <input class="ccformfield" name="email" type="text" placeholder="Email" required>
                    </div>
                    <div class="ccfield-prepend">
                        <span class="ccform-addon"><i class="fa fa-mobile-phone fa-2x"></i></span>
                        <input class="ccformfield" name="phone" type="text" placeholder="Phone">
                    </div>
                    <div class="ccfield-prepend">
                        <span class="ccform-addon"><i class="fa fa-info fa-2x"></i></span>
                        <input class="ccformfield" name="subject" type="text" placeholder="Subject" required>
                    </div>
                    <div class="ccfield-prepend">
                        <span class="ccform-addon"><i class="fa fa-comment fa-2x"></i></span>
                        <textarea class="ccformfield" name="comments" rows="8" placeholder="Message" required style="height: 51px"></textarea>
                    </div>
                    <div class="ccfield-prepend">
                        <input class="ccbtn" type="submit" value="Submit">
                    </div>
                </form>
            </div>

        </div>
        <!-- Success Pop-up -->
        <div class="popup">
            <div class="popup-content">
                <div class="topofpop" style="border-radius: 3px; padding: 10px;">
                    <h3>Success</h3>
                    <p>We have received your message. Thank you!</p>
                </div>
                <hr>
                <i class="fa-solid fa-hand-holding-heart fa-2xl" style="color: ;font-size: 130px; padding-top: 60px; "></i>
                <p style="padding-top: 60px; color: azure"> We are deeply committed to delivering timely and responsive assistance to our users, making it our top priority to promptly address and resolve any challenges they may encounter.</p>
                <p style="padding-top: 2px; color: azure"> Through our unwavering dedication and efficient resource allocation, we strive to provide comprehensive support, ensuring that every user's needs are met with the utmost care and attention.</p>
                <hr>
                <div style="font-size: x-small;">Click anywhere to leave this messeage</div>
            </div>
        </div>
    </div>
    <div>

    </div>
</div>

<!-- Footer -->
<div class="footer" style="background-color: rgb(255,255,255); right: 0; margin-top: 100px;">
    <div class="container">
        <a style="color: #000000; width:10%; line-height: 60px; float: left;" href="mainpagefaq.php">FAQ</a>
        <a style="color: #030303; width:10%; line-height: 60px; float: left; margin-left: 10px;" href="contactus.php">Contact Us</a>
        <p style="color: #000000; width:10%; line-height: 60px; float: right;">CypRIDE 2023</p>
        <img class="footerlogo" src="logo.png" style="float: right;">
    </div>
</div>



<!-- JavaScript code -->
<script>
    const form = document.querySelector(".ccform");
    $(document).ready(function() {
        $(".popup").click(function() {
            $(this).fadeOut();
        });
    });

    form.addEventListener("submit",(e) =>{
        console.log("form",e);
        e.preventDefault();

        //pop message to server request
        const formData = Object.fromEntries(new FormData(form));

        //console for testing
      $.ajax({
        type: "POST",
        url: "iletisim.php",
        data: formData,
        success: function(response) {
          // Show the success popup
          $(".popup").fadeIn();

          // Reset the form
          $(".ccform")[0].reset();
        },
        error: function(xhr, status, error) {
          // Handle the error if the request fails
          console.log(xhr.responseText);
        }
      });



    })

</script>
</body>
</html>