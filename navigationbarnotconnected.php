<nav>
  <div class="navbar-left">
    <a href="index.php">
      <img src="logo.png">
      <span class="navbar-text">CypRIDE</span>
    </a>
  </div>
  <div class="navbar-right">
    <div class="dropdown">
      <button class="dropbtn">Join Now</button>
      <div class="dropdown-content">
        <a href="#loginModal" data-toggle="modal">Login</a>
        <a href="#signupModal" data-toggle="modal">Sign Up</a>
      </div>
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