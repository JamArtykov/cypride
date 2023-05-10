<?php
$user_id = $_SESSION['user_id'];

//get username and email
$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($link, $query);
$user = mysqli_fetch_assoc($result);

// Check if user exists

$picture = $user['profilepicture'];
?>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
<nav>
    <div class="navbar-left">
        <a href="index.php">
            <img src="logo.png">
            <span class="navbar-text">CypRIDE</span>
        </a>
    </div>

    <div class="navbar-collapse collapse" id="navbarCollapse">
        <ul class="nav navbar-nav">
            <li class="navigationbutton"><a href="index.php">Search</a></li>
            <li class="navigationbutton"><a href="mainpageloggedin.php">My Trips</a></li>
        </ul>


    </div>


    <div class="navbar-right">

        <div class="propicture">
            <a href="#">
                <?php
                if (empty($picture)) {
                    echo "<div class='image_preview'><img class='previewing2' src='profilepicture/noimage.jpg' /></div>";
                } else {
                    echo "<div class='image_preview'><img class='previewing2' src='$picture' /></div>";
                }
                ?>
            </a>

            <a href="#"><b><?php echo $username?></b></a>
        </div>

        <div class="dropdown">
            <button class="dropbtn">Profile</button>
            <div class="dropdown-content">
            <a href="profile.php?u=<?php echo $user_id; ?>">Profile</a>
                <a href="index.php?logout=1" data-toggle="modal">Log Out</a>
            </div>
        </div>
        
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Notifications <span class="badge bg-danger">3</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Notification 1</a></li>
            <li><a class="dropdown-item" href="#">Notification 2</a></li>
            <li><a class="dropdown-item" href="#">Notification 3</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">View all notifications</a></li>
          </ul>
            </div>
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

        .navigationbutton{

            text-decoration-color:  chocolate;
        }





        .dropdown {
            float: left;
            margin-top: 10px;
        }

        .dropbtn {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 10px 12px;
            text-decoration: none;
            display: block;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .propicture {
            float: left;
            margin-right: 8px;

        }
        .image_preview {
            display: inline-block;
            position: relative;
            overflow: hidden;
            top: 13px;
        }

        .previewing2 {
            width: 35px;
            height: 35px;
            border-radius: 50%;
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