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
      <link rel="shortcut icon" type="image/png" href="/images/favicon2.ico">
      <meta property="og:image" content="/images/favicon.png" />
      <style>

          #image_preview{
              left: 100px;
          }

          .col-sm-9{
              margin-top: 8px;
              color: #9a9a9a;
          }

        container{
            margin-top:100px;
            text-align: center;
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
        .row{
            color: white;
            text-align: center;
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

          .footer {
              position: absolute;
              bottom: 0;
              text-align: center;
              width: 100%;
              padding-top: 10px;
              background-color: #000000;
              left: 0;
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
              background: linear-gradient(to bottom, rgb(5, 70, 122), rgba(2, 8, 33, 0.65));
              border: none;
              cursor: pointer;
              transition: all 0.5s;
              border-radius: 10px;

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



<div class="profile" style="margin-bottom: 190px;">
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
        </a><h5 data-toggle="modal" data-target="#updatepicture" style="cursor: pointer; text-align: center; color: white;">Change picture</h5>




      </div>
<!--<div class="user-details">-->
<!--    <h1>--><?php //echo $user['first_name'] . ' ' . $user['last_name']; ?><!--</h1>-->
<!--    <p>Username: --><?php //echo $user['username']; ?><!--</p>-->
<!--    <p>Email: --><?php //echo $user['email']; ?><!--</p>-->
<!--    <p>Gender: --><?php //echo $user['gender']; ?><!--</p>-->
<!--    <p>Phone Number: --><?php //echo $user['phonenumber']; ?><!--</p>-->
<!--    <p>More Information: --><?php //echo $user['moreinformation']; ?><!--</p>-->
<!--    <a href="#" class="edit-button" data-target="#editProfileModal" data-toggle="modal">Edit Profile</a>-->
<!--    <a href="#" class="password-button" data-target="#updatepassword" data-toggle="modal" style="margin-left:350px;">Change Password</a>-->
<!--</div>-->

        <div class='col-md-8'>
            <div class='card mb-3'>
                <div class='card-body'>
                    <div class='row'>
                        <div class='col-sm-3'>
                            <h6 class='mb-0'>Full Name</h6>
                        </div>
                        <div class='col-sm-9 text-secondary'>
                            <p><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-sm-3'>
                            <h6 class='mb-0'>Email</h6>
                        </div>
                        <div class='col-sm-9 text-secondary'>
                            <p><?php echo $user['email']; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-sm-3'>
                            <h6 class='mb-0'>Phone</h6>
                        </div>
                        <div class='col-sm-9 text-secondary'>
                            <p><?php echo $user['phonenumber']; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-sm-3'>
                            <h6 class='mb-0'>Gender</h6>
                        </div>
                        <div class='col-sm-9 text-secondary'>
                            <p><?php echo $user['gender']; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-sm-3'>
                            <h6 class='mb-0'>More Information</h6>
                        </div>
                        <div class='col-sm-9 text-secondary'>
                            <?php echo $user['moreinformation']; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-sm-12' style="display: flex;flex-wrap: nowrap;">
                            <a href='#' class='btn btn-info' data-target='#editProfileModal' data-toggle='modal' style=" background: #337AB7; border-color: transparent;">Edit Profile</a>
                            <a href='#' class="btn btn-info" data-target="#updatepassword" data-toggle="modal" style="margin-left:225px; background: #337AB7; border-color: transparent;">Change Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <form method="post" id="updateprofileform">
    <div class="modal" id="editProfileModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">
                        &times;
                    </button>
                    <h4 id="myModalLabel">
                        Edit Profile:
                    </h4>
                </div>
                <div class="modal-body">

                    <!-- Update profile message from PHP file -->
                    <div id="updateprofilemessage"></div>

                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input class="form-control" type="text" name="username" id="username" maxlength="30" value="<?php echo $user['username']; ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label for="email">Username:</label>
                        <input class="form-control" type="text" name="email" id="email" maxlength="30" value="<?php echo $user['email']; ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select class="form-control" name="gender" id="gender">
                            <option value="Male" <?php if ($user['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if ($user['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input class="form-control" type="text" name="phone" id="phone" maxlength="15" value="<?php echo $user['phonenumber']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="more_information">More Information:</label>
                        <textarea class="form-control" name="more_information" id="more_information"><?php echo $user['moreinformation']; ?></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <input class="btn green" name="updateprofile" type="submit" value="Submit">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Update password form -->
<form method="post" id="updatepasswordform">
        <div class="modal" id="updatepassword" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal">
                    &times;
                  </button>
                  <h4 id="myModalLabel">
                    Enter Current and New password:
                  </h4>
              </div>
              <div class="modal-body">
                  
                  <!--Update password message from PHP file-->
                  <div id="updatepasswordmessage"></div>
                  

                  <div class="form-group">
                      <label for="currentpassword" class="sr-only" >Your Current Password:</label>
                      <input class="form-control" type="password" name="currentpassword" id="currentpassword" maxlength="30" placeholder="Your Current Password">
                  </div>
                  <div class="form-group">
                      <label for="password" class="sr-only" >Choose a password:</label>
                      <input class="form-control" type="password" name="password" id="password" maxlength="30" placeholder="Choose a password">
                  </div>
                  <div class="form-group">
                      <label for="password2" class="sr-only" >Confirm password:</label>
                      <input class="form-control" type="password" name="password2" id="password2" maxlength="30" placeholder="Confirm password">
                  </div>
                  
              </div>
              <div class="modal-footer">
                  <input class="btn green" name="updateusername" type="submit" value="Submit">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  Cancel
                </button> 
              </div>
          </div>
      </div>
      </div>
      </form>

      <!-- Edit Profile Modal -->
<!--      <div class="modal" id="editProfileModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">-->
<!--          <div class="modal-dialog">-->
<!--              <div class="modal-content">-->
<!--                  <div class="modal-header">-->
<!--                      <button class="close" data-dismiss="modal">-->
<!--                          &times;-->
<!--                      </button>-->
<!--                      <h4 id="myModalLabel">Edit Profile</h4>-->
<!--                  </div>-->
<!--                  <div class="modal-body">-->
<!--                      Profile edit form -->
<!--                      <form method="post" id="updateusernameform">-->
<!--                          <tr data-target="#updateusername" data-toggle="modal">-->
<!--                              <td>Username</td>-->
<!--                              <td></td>-->
<!--                              <input type="text" class="form-control" id="username" name="username" value="--><?php //echo $user['username']; ?><!--">-->
<!---->
<!--                          </tr>-->

<!--                      </form>-->
<!--                  </div>-->
<!---->
<!--                  <div class="modal-footer">-->
<!--                      <input class="btn green" name="updateusername" type="submit" value="Submit">-->
<!--                      <button class="btn btn-primary" id="saveChangesBtn">Save Changes</button>-->
<!--                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>-->
<!--                  </div>-->
<!--              </div>-->
<!--          </div>-->
<!--      </div>-->





      <script>
          $(document).ready(function() {
              // Handle form submission
              $('#saveChangesBtn').click(function() {
                  // Get the values from the form fields
                  var firstName = $('#firstName').val();
                  var lastName = $('#lastName').val();
                  // Add more variables for other fields

                  // Make an AJAX request to save the changes
                  $.ajax({
                      url: 'save_profile_changes.php', // Replace with the actual file to handle the saving of profile changes
                      method: 'POST',
                      data: {
                          firstName: firstName,
                          lastName: lastName
                          // Add more fields to send to the server
                      },
                      success: function(response) {
                          // Handle the success response, e.g., display a success message
                          alert('Profile updated successfully');
                          // Close the modal
                          $('#editProfileModal').modal('hide');
                      },
                      error: function(xhr, status, error) {
                          // Handle the error response, e.g., display an error message
                          alert('An error occurred while updating the profile');
                      }
                  });
              });
          });
      </script>




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
<!--      <div class="user-details">-->
<!--        <h1>--><?php //echo $user['first_name'] . ' ' . $user['last_name']; ?><!--</h1>-->
<!--        <p>Username: --><?php //echo $user['username']; ?><!--</p>-->
<!--        <p>Gender: --><?php //echo $user['gender']; ?><!--</p>-->
<!--      </div>-->


        <div class='col-md-8'>
            <div class='card mb-3'>
                <div class='card-body'>
                    <div class='row'>
                        <div class='col-sm-3'>
                            <h6 class='mb-0'>Full Name</h6>
                        </div>
                        <div class='col-sm-9 text-secondary'>
                            <p><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-sm-3'>
                            <h6 class='mb-0'>Phone</h6>
                        </div>
                        <div class='col-sm-9 text-secondary'>
                            <p><?php echo $user['phonenumber']; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-sm-3'>
                            <h6 class='mb-0'>Gender</h6>
                        </div>
                        <div class='col-sm-9 text-secondary'>
                            <p><?php echo $user['gender']; ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class='row'>
                        <div class='col-sm-3'>
                            <h6 class='mb-0'>More Information</h6>
                        </div>
                        <div class='col-sm-9 text-secondary'>
                            <?php echo $user['moreinformation']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
  <?php } ?>
</div>




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


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
      <script src="profile.js"></script>
  </body>
</html>