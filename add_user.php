<?php
include "config.php";

// Check user login or not
if(!isset($_SESSION['uname'])){
    header('Location: index.php');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: index.php');
}

$diff = time() - $_SESSION['loggedin_time'];
if($diff >= 7200){
    header('Location: logout.php');
}

if(isset($_POST['but_submit'])){

    $uname = mysqli_real_escape_string($con,$_POST['txt_uname']);
    $email = mysqli_real_escape_string($con,$_POST['txt_email']);
    $password = mysqli_real_escape_string($con,$_POST['txt_pwd']);




    if ($uname != "" && $password != ""){

        $sql = "select count(*) as cntUser,user_name from tbl_city_users where email_id='".$email."' and active_flag = 1";

        $sq_result = mysqli_query($con,$sql);
        $sq_row = mysqli_fetch_array($sq_result);
        $count = $sq_row['cntUser']; 
        if($count > 0){
            echo "<div style='margin-left:619px;color:red;font-style: italic;'>User is Already Added</div>";
        } else {
            $sql_query = "INSERT INTO tbl_city_users(user_name,email_id,password,active_flag)VALUES('".$uname."','".$email."','".md5($password)."',1)";
            $result = mysqli_query($con,$sql_query);
            $id = mysqli_insert_id($con);
            if($id){
                echo "<div style='margin-left:619px;color:red;font-style: italic;'>User Added successfully</div>";
            }

        }

        

    }

}
?>
<html>
    <head>
        <title>City Pending Backlog Report</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <div style=" margin-left: 1250px; "><?php echo 'Hi, '.$_SESSION['username'];?></div>
    <div style=" margin-left: 1320px; ">
    <a href="city_backlog_process.php" title="Home">Home</a>| <a href='logout.php' title='Logout'>Logout</a>
    </div>
   
    <body>
        <div class="container">
            <form method="post" action="">
                <div id="div_login" style="width: 550px; height: 346px;">
                    <h1>Add User</h1>
                    <div>
                      Name :  <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Name" required/>
                    </div>
                    <div>
                      Email :  <input type="email" class="textbox" id="txt_email" name="txt_email" placeholder="Email" required/>
                    </div>
                    <div>
                     Password :    <input type="password" class="textbox" id="txt_pwd" name="txt_pwd" placeholder="Password" required/>
                    </div>
                    <div>
                        <input type="submit" value="Submit" name="but_submit" id="but_submit" />
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>

