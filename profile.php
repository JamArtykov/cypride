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
    <title>Profile</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="styling.css?v=<?php echo time(); ?>" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
      <style>

          #image_preview{
              left: 100px;
          }

        container{
            margin-top:100px;
        }

        notePad, #allNotes, #done{
            display: none;
        }

        .buttons{
            margin-bottom: 20px;
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

          tr{
             cursor: pointer;
          }
          #previewing{
              max-width: 100%;
              height: auto;
              border-radius: 50%;
          }
          .previewing2{
              margin: auto;
              height: 20px;
              border-radius: 50%;
          }
          #spinner{
              display: none;
              position: static;
              top: 0;
              left: 0;
              bottom: 0;
              right: 0;
              height: 85px;
              text-align: center;
              margin: auto;
              z-index: 1100;
          }



/*          .profile {*/
/*  max-width: 800px;*/
/*  margin: 100px auto;*/
/*  padding: 20px;*/
/*              */
/*}*/

          .profile {
              max-width: 800px;
              margin: 100px auto;
              padding: 20px;
              background-color: #efefef;
              border: none;
              cursor: pointer;
              transition: all 0.5s;

          }

.user-info {
  display: flex;
  align-items: center;
}

.user-picture {
  width: 150px;
  height: 150px;
  margin-right: 40px;
}

.user-picture img {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
  border: 3px solid #fff;
  box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.3);
}

.user-details h1 {
  font-size: 36px;
  margin: 0;
  margin-bottom: 10px;
}

.user-details p {
  font-size: 18px;
  margin: 0;
  margin-bottom: 5px;
}

.user-details p:first-child {
  margin-top: 10px;
}

@media screen and (max-width: 767px) {
  .user-info {
    flex-direction: column;
  }
  
  .user-picture {
    margin: 0 auto;
    margin-bottom: 20
}

.user-details {
text-align: center;
margin-top: 20px;
}
}
      </style>
  </head>
  <body>
    <?php if(isset($_SESSION["user_id"])){
    include("navigationbarconnected.php");
}else{
    include("navigationbarnotconnected.php");
}
   

$user_id = $_GET['u'];




//get user details
$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($link, $query);
$user = mysqli_fetch_assoc($result);



$picture = $user['profilepicture']; ?>
    <form method="post" enctype="multipart/form-data" id="updatepictureform">
        <div class="modal" id="updatepicture" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">
                            &times;
                        </button>
                        <h4 id="myModalLabel">
                            Upload Picture:
                        </h4>
                    </div>
                    <div class="modal-body">

                        <!--Update picture message from PHP file-->
                        <div id="updatepicturemessage"></div>
                        <?php
                        if(empty($picture)){
                            echo "<div class='image_preview'><img id='previewing' src='profilepicture/noimage.jpg' /></div>";
                        }else{
                            echo "<div class='image_preview'><img id='previewing' src='$picture' /></div>";
                        }

                        ?>
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="picture">Select a picture:</label>
                                <input type="file" name="picture" id="picture">
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <input class="btn green" name="updatepicture" type="submit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

<!--Container-->



<div class="profile">
  <?php if(!$user) { ?>
    <h1><?php echo "User was not found"; ?></h1>
  <?php } else if ($user_id == $_SESSION["user_id"]) { ?>
    <div class="user-info">
      <div class="user-picture">
        <a href="#" data-target="#updatepicture" data-toggle="modal">
          <?php
            if(empty($picture)){
              echo "<img class='previewing2' src='noimage.jpg' />";
            } else {
              echo "<img class='previewing2' src='$picture' />";
            }
          ?>
        </a>
      </div>
      <div class="user-details">
        <h1><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h1>
        <p>Username: <?php echo $user['username']; ?></p>
        <p>Email: <?php echo $user['email']; ?></p>
        <p>Gender: <?php echo $user['gender']; ?></p>
        <p>Phone Number: <?php echo $user['phonenumber']; ?></p>
        <p>More Information: <?php echo $user['moreinformation']; ?></p>
            <?php echo $user["user_id"]; echo '/' .$_SESSION["user_id"];?>
      </div>
    </div>
  <?php } else if ($user["user_id"] != $_SESSION["user_id"]) { ?>
    <div class="user-info">
      <div class="user-picture">
        
          <?php
            if(empty($picture)){
              echo "<img class='previewing2' src='noimage.jpg' />";
            } else {
              echo "<img class='previewing2' src='$picture' />";
            }
          ?>
        
      </div>
      <div class="user-details">
        <h1><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h1>
        <p>Username: <?php echo $user['username']; ?></p>
        <p>Gender: <?php echo $user['gender']; ?></p>
      </div>
    </div>
  <?php } ?>
</div>




    <!-- Footer-->
    <div class="footer" style="background-color: rgba(255,107,1,0.57)">



        <div class="container">
            <a style="color: white;  width:10%; line-height: 60px; float: left;"  href="mainpagefaq.php">FAQ</a>
            <p style="color: white;  width:10%; line-height: 60px; float: right;">CypRIDE 2023</p>
            <img  class="footerlogo" src="logo.png" style="float: right;">

        </div>

    </div>


      <!--Spinner-->
      <div id="spinner">
         <img src='ajax-loader.gif' width="64" height="64" />
         <br>Loading..
      </div>
      

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
      <script src="profile.js"></script>
  </body>
</html>