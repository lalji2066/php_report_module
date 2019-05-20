<?php
include "config.php";

if(isset($_SESSION['uname'])){
    /*$user_query = "update tbl_city_users set login_flag = 1 where email_id='".$uname."'";
    mysqli_query($con,$user_query);*/
    
    header('Location: sales_incentives_process.php');
}

if(isset($_POST['but_submit'])){

    $uname = mysqli_real_escape_string($con,$_POST['txt_uname']);
    $password = mysqli_real_escape_string($con,$_POST['txt_pwd']);

    if ($uname != "" && $password != ""){
        
        $sql_query = "select count(*) as cntUser,user_name,login_flag from tbl_city_users where email_id='".$uname."' and password='".md5($password)."'";
        $result = mysqli_query($con,$sql_query);
        $row = mysqli_fetch_array($result);
                
        $count = $row['cntUser']; 
        if($count > 0){
            $_SESSION['uname'] = $uname;
            $_SESSION['username'] = $row['user_name'];
            $_SESSION['loggedin_time'] = time();

            /*$user_query = "update tbl_city_users set login_flag = 1 where email_id='".$uname."'";
            mysqli_query($con,$user_query);
            
            if($row['login_flag'] == 1){
              echo "<div style='margin-left:619px;color:red;font-style: italic;'>User Is Already Logged In.</div>";
            } else {
               
            }*/
            header('Location: sales_incentives_process.php');
            
        }else{
            echo "<div style='margin-left:619px;color:red;font-style: italic;'>Invalid username and password</div>";
        }

    }

}
?>
<html>
    <head>
        <title>Sale & incentive Data module</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    
    <body>
        <div class="container">
            <form method="post" action="">
                <div id="div_login">
                    <h1>Login</h1>
                    <div>
                        <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Username" required/>
                    </div>
                    <div>
                        <input type="password" class="textbox" id="txt_pwd" name="txt_pwd" placeholder="Password" required/>
                    </div>
                    <div>
                        <input type="submit" value="Submit" name="but_submit" id="but_submit" />
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>

