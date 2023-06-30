<?php ob_start(); ?>
<!--This file receives the user_id and key generated to create the new password-->
<!--This file displays a form to input new password-->

<?php
session_start();
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Password Reset</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style>
            body{
                background-color: #0c4899;
            }

            .container{
                background: #0c4899;
            }
            h1{
                color:purple;   
            }
            .contactForm{
                border:1px solid #7c73f6;
                margin-top: 50px;
                border-radius: 15px;
            }
        </style> 

    </head>
        <body>

        <nav>
            <div class="navbar-left">
                <a href="index.php">
                    <img src="logo.png">
                    <span class="navbar-text">CypRIDE</span>
                </a>
            </div>
            <div class="navbar-right">

            </div>

            <style>
                nav {
                    position:fixed;
                    top: 0px;
                    width: 100%;
                    z-index: 9999;
                    background-color: #fff;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    height: 80px;
                    padding: 0 20px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                }

                .navbar-left a {
                    display: flex;
                    align-items: center;
                    text-decoration: none;
                }

                .navbar-left img {
                    height: 40px;
                    margin-right: 10px;
                    margin-left: 50px;
                }

                .navbar-left .navbar-text {
                    color: #3aa951;
                    font-size: 24px;
                }

                .navbar-right .dropdown {
                    position: relative;
                }

                .navbar-right .dropbtn {
                    background-color: transparent;
                    color: #3aa951;
                    font-size: 18px;
                    border: none;
                    cursor: pointer;
                    margin-right: 50px;
                }

                .navbar-right .dropdown-content {
                    display: none;
                    position: absolute;
                    z-index: 1;
                    top: 100%;
                    right: 0;
                    background-color: #fff;
                    min-width: 120px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                }

                .navbar-right .dropdown-content a {
                    color: #3aa951;
                    padding: 10px 20px;
                    display: block;
                    text-decoration: none;
                    font-size: 16px;
                }

                .navbar-right .dropdown:hover .dropdown-content {
                    display: block;
                }

                .navbar-fixed-top{
                    position:fixed;
                    top: 0px;
                    width: 100%;
                    z-index: 9999;

                }

            </style>
        </nav>

<div class="container-fluid" style="margin-top: 60px;">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 contactForm" style="background: linear-gradient(to top, rgb(217,237,247),#ecf3fa,rgb(217,237,247));">
            <h1><b> Reset Password:</b></h1>
            <div id="resultmessage"></div>
<?php
//If user_id or key is missing
if(!isset($_GET['user_id']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email.</div>'; exit;
}
//else
    //Store them in two variables
$user_id = $_GET['user_id'];
$key = $_GET['key'];
$time = time() - 86400;
    //Prepare variables for the query
$user_id = mysqli_real_escape_string($link, $user_id);
$key = mysqli_real_escape_string($link, $key);
    //Run Query: Check combination of user_id & key exists and less than 24h old
$sql = "SELECT user_id FROM forgotpassword WHERE rkey='$key' AND user_id='$user_id' AND time > '$time' AND status='pending'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>'; exit;
}
//If combination does not exist
//show an error message
$count = mysqli_num_rows($result);
if($count !== 1){
    echo '<div class="alert alert-danger">Please try again.</div>';
    exit;
}
//print reset password form with hidden user_id and key fields
echo "
<form method=post id='passwordreset' style='margin-bottom: 20px;'>
<input type=hidden name=key value=$key>
<input type=hidden name=user_id value=$user_id>
<div class='form-group'>
    <label for='password'>Enter your new Password:</label>
    <input type='password' name='password' id='password' placeholder='Enter Password' class='form-control' style='border: 1px solid #000; border-radius: 9px;  padding: 5px;'>
</div>
<div class='form-group'>
    <label for='password2'>Re-enter Password::</label>
    <input type='password' name='password2' id='password2' placeholder='Re-enter Password' class='form-control' style='border: 1px solid #000; border-radius: 9px;  padding: 5px;'>
</div>
<input type='submit' name='resetpassword' class='btn btn-success btn-lg' value='Reset Password'>


</form>
";


?>
            
        </div>
    </div>
</div>

        


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
            <!--Script for Ajax Call to storeresetpassword.php which processes form data-->
            <script>
             //Once the form is submitted
            $("#passwordreset").submit(function(event){ 
                //prevent default php processing
                event.preventDefault();
                //collect user inputs
                var datatopost = $(this).serializeArray();
            //    console.log(datatopost);
                //send them to signup.php using AJAX
                $.ajax({
                    url: "storeresetpassword.php",
                    type: "POST",
                    data: datatopost,
                    success: function(data){

                        $('#resultmessage').html(data);
                    },
                    error: function(){
                        $("#resultmessage").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");

                    }

                });

            });           
            
            </script>

        <!-- Footer-->
        <?php
        include("footer.php");
        ?>
        </body>
</html>
<?php ob_flush(); ?>
