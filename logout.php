<?php

include "config.php";
/*$user_query = "update tbl_city_users set login_flag = 0 where email_id='".$_SESSION['uname']."'";
mysqli_query($con,$user_query);*/

session_destroy();
header('Location: index.php');

?>
        
   
