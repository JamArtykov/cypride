<?php
//leave username as "root" and password as empty if hosting on localhost. Change the dbname accordingly.
$link = mysqli_connect("localhost", "username", "password", "db_name");
if(mysqli_connect_error()){
    die('ERROR: Unable to connect:' . mysqli_connect_error()); 
    echo "<script>window.alert('Hi!')</script>";
}
    ?>