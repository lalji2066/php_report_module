<?php

session_start();

//print_r($_SESSION);

$host = "192.168.12.145"; /* Host name */
$user = "globalmis"; /* User */
$password = "glob@lmis"; /* Password */
$dbname = "db_taskmgr"; /* Database name */
//array('192.168.12.145','globalmis','glob@lmis','db_taskmgr'); tbl_users
$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

///File uploade
function getdb(){
$servername = "192.168.12.219";
$username = "laljiy";
$password = "L@lj!y";
$db = "test";
try {

    $conn = mysqli_connect($servername, $username, $password, $db);
     //echo "Connected successfully"; 
    }
catch(exception $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
}

//print_r($con);exit;
 $init_query1="select distinct branch from test.tbl_clear_sales";	
 $init_exec_qry1 = mysqli_query($con,$init_query1) or die(mysql_error());
//$branch_array = mysqli_fetch_assoc($init_exec_qry1);
$i=0;
while ($row = mysqli_fetch_assoc($init_exec_qry1)) { 
	$branch_array[$i++]=$row['branch'];

}
//print_r($branch_array);
$init_query="select distinct std_team_name as team  from test.tbl_clear_sales";	
$init_exec_qry = mysqli_query($con,$init_query) or die(mysql_error());
//$team_array= mysqli_fetch_assoc($init_exec_qry);
$i=0;
while ($row = mysqli_fetch_assoc($init_exec_qry)) { 
	$team_array[$i++]=$row['team'];

}
//print_r($team_array);


