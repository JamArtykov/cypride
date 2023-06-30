<?php
//The user is re-directed to this file after clicking the activation link
//Signup link contains two GET parameters: email and activation key
session_start();
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Account Activation</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style>
            h1{
                color:purple;   
            }
            .contactForm{
                border:1px solid #7c73f6;
                margin-top: 50px;
                border-radius: 15px;
            }

            body{
                background-color: #0c4899;
            }
        </style> 

    </head>
        <body>
<!--Navigation bar-->
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
            <h1><b>Account Activation</b></h1>
<?php
//If email or activation key is missing show an error
if(!isset($_GET['email']) || !isset($_GET['key'])){
    echo '<div class="alert alert-danger">There was an error. Please click on the activation link you received by email.</div>'; exit;
}



//else
    //Store them in two variables
$email = $_GET['email'];
$key = $_GET['key'];
    //Prepare variables for the query
$email = mysqli_real_escape_string($link, $email);
$key = mysqli_real_escape_string($link, $key);
    //Run query: set activation field to "activated" for the provided email
$sql = "UPDATE users SET activation='activated' WHERE (email='$email' AND activation='$key') LIMIT 1";
$result = mysqli_query($link, $sql);
    //If query is successful, show success message and invite user to login
if(mysqli_affected_rows($link) == 1){
    echo '<div class="alert alert-success">Your account has been activated.</div>';
    echo '<a href="index.php" type="button" class="btn-lg btn-sucess" style="margin-bottom: 30px;"><b> Log in</b><a/>';
    
    echo '<div style="margin-bottom: 30px;"></div>';
    
}else{
    //Show error message
    echo '<div class="alert alert-danger">Your account could not be activated. Please try again later.</div>';
    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
    
}
?>
            
        </div>
    </div>
</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        </body>
        <style>
            .button{
                margin-top: 20px;
                color: green;
                border: 1px solid green;
            }
        </style>
</html>