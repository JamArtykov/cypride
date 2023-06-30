<?php
session_start();
include('connection.php');

//logout
include('logout.php');

//remember me
include('remember.php');
$user_id = $_SESSION['user_id'];

//get username and email
$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($link, $query);
$user = mysqli_fetch_assoc($result);

// Check if user exists

$picture = $user['profilepicture'];

$sql = "SELECT * FROM notifications WHERE user_id = " . $user_id . " ORDER BY created_at DESC";
$results = mysqli_query($link, $sql);
$notifications = array();

while ($row = mysqli_fetch_assoc($results)) {
    $notifications[] = $row;
}

$sql = "SELECT * FROM wallet WHERE user_id = " . $user_id;
$results = mysqli_query($link, $sql);
$wallet = mysqli_fetch_assoc($results);
$balance = $wallet['balance'];



?>
<head>
<link rel="shortcut icon" type="image/png" href="/images/favicon.png">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src='https://kit.fontawesome.com/49abe375a7.js' crossorigin='anonymous'></script>

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
            <li class="navigationbutton"><a href="wallet.php">Transactions</a></li>
        </ul>


    </div>


    <div class="navbar-right">
        <div class="dropdown-profile dropdown">
            <button class="dropbtn" ><b style="color: black; font-size: 85%;">Hi!</b> <?php echo $user['first_name'];?> </button>
                <div class="dropdown-menu profile-content">

                    <a href="profile.php?u=<?php echo $user_id; ?>">Profile</a>
                    <a href="index.php?logout=1" data-toggle="modal">Log Out</a>
                </div>
        </div>
        <a href="wallet.php" class="btn btn-primary custom-button" style="background-color: #035613; white-space: nowrap; text-align: center;">
<!--            <span class="fw-bold">&#8853;</span>-->
            <span class="ms-2" style="margin-left: 2px"><?php echo $balance; ?></span>
            <img src="/images/coins-solid.svg" style="filter: invert(100%); height: 15px;" >


        </a>

        <div class="propicture">
            <a>
                <?php
                if (empty($picture)) {
                    echo "<div class='image_preview'><img class='previewing2' src='profilepicture/noimage.jpg' /></div>";
                } else {
                    echo "<div class='image_preview'><img class='previewing2' src='$picture' /></div>";
                }
                ?>
            </a>

        </div>
        
        
        <!-- Display notifications -->
        <div class="dropdown-notifications">
            <a id="dLabel" role="button" data-toggle="dropdown" data-target="#">
                <i class="glyphicon glyphicon-bell"></i>
            </a>
  
            <div class="dropdown-menu notifications">
                <div class="notification-heading">
                    <h4 class="menu-title">Notifications</h4>
                    
                </div>
                <div class="notifications-wrapper">
                    <?php foreach ($notifications as $notification): ?>
                        <a class="content" href="viewtrip.php?trip_id=<?php echo $notification['trip_id']; ?>">
                            <div class="notification-item">
                                <h4 class="item-title"><?php echo $notification['message']; ?></h4>
                                <p class="item-info"><?php echo $notification['created_at']; ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                    <?php if (empty($notifications)): ?>
                        <div class="notification-item">
                            <p class="no-notification">No new notifications</p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="notification-footer">
                    <h4 class="menu-title">View all<i class="glyphicon glyphicon-circle-arrow-right"></i></h4>
                </div>
            </div>
        </div>



<style>
nav {
    position: fixed;
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

.navigationbutton {
    text-decoration-color: chocolate;
}

.small-font {
    font-size: 12px;
    color: gray;
}

.dropdown-wallet {
    display: inline-block;
    margin-left: 0px;
    margin-right: -50px;
    padding: 20px;
}

.dropdown-profile {
    display: inline-block;
    margin-left: -20px;
    margin-right: 0px;
    padding: 20px;
}

.dropdown-notifications {
    display: inline-block;
    margin-left: -60px;
    margin-right: 20px;
    padding: 20px;
}

.glyphicon-bell {
    margin-left: 10px;
    font-size: 1.5rem;
}

.notifications {
    min-width: 420px;
}

.notifications-wrapper {
    overflow: auto;
    max-height: 250px;
}

.menu-title {
    font-size: 1.5rem;
    display: flex;
    align-items: center;
}

.glyphicon-circle-arrow-right {
    margin-left: 10px;
    font-size: 1.5rem;
}

.item-title {
    font-size: 1.3rem;
    color: #000;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.notification-heading,
.notification-footer {
    padding: 2px 10px;
}

.dropdown-menu.divider {
    margin: 5px 0;
}


.notifications a.content {
    text-decoration: none;
    background: #ccc;
}

.notification-item {
    padding: 10px;
    margin: 5px;
    background: #ccc;
    border-radius: 4px;
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
    height: 50px;
    margin-right: 10px;
    margin-left: 0px;
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

.navbar-right .dropdown-wallet {
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

.dropdown-wallet-content {
    display: none;
    position: absolute;
    z-index: 1;
    top: 100%;
    left: 0;
    background-color: #fff;
    min-width: 120px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.dropdown-wallet-content a {
    color: #3aa951;
    padding: 10px 20px;
    display: block;
    text-decoration: none;
    font-size: 16px;
}

.dropdown-wallet:hover .dropdown-wallet-content {
    display: block;
}

.navbar-right .dropdown-profile {
    position: relative;
}

.dropdown-profile .dropbtn {
    background-color: transparent;
    color: #3aa951;
    font-size: 18px;
    border: none;
    cursor: pointer;
    margin-right: 20px;
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

.dropdown-profile:hover .dropdown-content {
    display: block;
}

.navbar-fixed-top {
    position: fixed;
    top: 0px;
    width: 100%;
    z-index: 9999;
}

.dropdown {
    position: relative;
}

.dropbtn {
    background-color: transparent;
    color: #3aa951;
    font-size: 18px;
    border: none;
    cursor: pointer;
    margin-right: 20px;
}

.dropdown-menu {
    display: none;
    position: absolute;
    z-index: 1;
    top: 100%;
    right: 0;
    background-color: #fff;
    min-width: 120px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.dropdown-menu a {
    color: #3aa951;
    padding: 10px 20px;
    display: block;
    text-decoration: none;
    font-size: 16px;
}

.dropdown:hover .dropdown-menu {
    display: block;
}

.custom-button {
    width: 100px; 
    margin-bottom: 5px;
    margin-right: 75px;
}

/* Mobile compatibility */
@media (max-width: 767px) {
    nav {
        height: 60px;
        padding: 0 10px;
    }

    .menu-title {
        font-size: 1.2rem;
    }

    .glyphicon-circle-arrow-right {
        margin-left: 5px;
        font-size: 1.2rem;
    }

    .item-title {
        font-size: 1.1rem;
    }

    .propicture {
        margin-right: 5px;
    }

    .image_preview {
        top: 8px;
    }

    .previewing2 {
        width: 30px;
        height: 30px;
    }

    .navbar-left img {
        height: 40px;
        margin-right: 5px;
    }

    .navbar-left .navbar-text {
        font-size: 18px;
    }

    .navbar-right .dropbtn {
        font-size: 16px;
        margin-right: 30px;
    }

    .dropdown-menu {
        min-width: 100px;
    }

    .dropdown-menu a {
        font-size: 14px;
        padding: 8px 15px;
    }
}
</style>

</nav>