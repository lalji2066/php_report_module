<?php 

include "config.php";
//print_r($_REQUEST);

// Check user login or not
if(!isset($_SESSION['uname'])){
    header('Location: index.php');
}

// logout
if(isset($_POST['but_logout'])){
    session_destroy();
    header('Location: index.php');
}

//include_once 'dbconn.php';
//$conn = new dbconn();



//VALUES
$curr_start_date  = $_GET["fDate"];
$curr_end_date 	 = $_GET["tDate"];
$city  = $_GET["city"];
$std_team_name 	 = $_GET["std_team_name"];

//TRUE OR FALSE
$tbl_clear_sales 	 = $_GET["tbl_clear_sales"];
$tbl_incentives 	 = $_GET["tbl_incentives"];

$table_array  = array();
array_push($table_array, 'tbl_clear_sales');
array_push($table_array, 'tbl_incentives');

//print_r($table_array);


$tme  = $_GET["tme"];
$me  = $_GET["me"];
$jda  = $_GET["jda"];




$start_data = date('Y-m-d',strtotime("01 ".$curr_start_date));
$end_data =  date('Y-m-d',strtotime("01 ".$curr_end_date));


//$date = "01/06/2018";
//$date = DateTime::createFromFormat("d/m/Y" , $date);
//echo $date->format('Y-m-d');

//echo "date:" . gmdate('Y-m-d',strtotime('01/06/2018'));exit;

//SELECT QUERY
foreach($table_array as $key => $tbl_name){ //echo $tbl_name;
	if($city == 'All')	
		$value ="";
	else
		$value = " branch='$city' AND ";
	$value .= " dept in ( ";
		if($tme) $value .= "'TME',";
		if($me) $value .= "'ME',";
		if($jda) $value .= "'JDA',";
	$value = trim($value,',');
	$value .= " ) ";
/*	
	if($tbl_name == 'tbl_clear_sales'){
		$select_smt = "SELECT x.*,y.added_on,y.date_of_leaving,y.status FROM(";
		$select_smt .= "SELECT DATE_FORMAT(sales_month, '%b-%Y') as sales_month,branch,emp_code,emp_name,dept,std_team_name,ecs_cont_count,ecs_cont_amt,nonecs_cont_count,nonecs_cont_amt,ecs_clearance,total_cont_count,total_sales_excl_ecs_accrued,total_sales_incl_ecs_accrued from test.$tbl_name WHERE ";
		$value .= " AND sales_month >= '$start_data' AND sales_month <= '$end_data' ";
		if($std_team_name == 'All')
		$value .="";
		else
		$value .= " AND std_team_name = '$std_team_name'";
		$value .= ") x 
					LEFT JOIN
					(
					SELECT empcode,added_on, if(date_of_leaving ='0000-00-00 00:00:00','',date_of_leaving) as date_of_leaving,IF(delete_flag=0 and resign_flag=1 ,'Active','Non-Active') as status from global_mis.hr_all_daily) y
					ON x.emp_code=y.empcode";
		
	}else{
		$select_smt= "SELECT DATE_FORMAT(expense_month, '%b-%Y') as expense_month,branch,emp_code,emp_name,dept,incentive_type,
						MAX(CASE WHEN incentive_type = 'ECS Incentive' THEN incentives END) ECS_Incentive,
						MAX(CASE WHEN incentive_type = 'NON-ECS Incentive' THEN incentives END)NON_ECS_Incentive,
						MAX(CASE WHEN incentive_type = 'JDA' THEN incentives END) JDA,
						MAX(CASE WHEN incentive_type = 'Manager Incentive' THEN incentives END) Manager_Incentive,
						MAX(CASE WHEN incentive_type = 'Addon' THEN incentives END) Addon,
						sum(incentives) as Total_Incentives from test.$tbl_name WHERE ";
		$value .= " AND expense_month >= '$start_data' AND expense_month <= '$end_data' group by expense_month,emp_code,dept ";
	}
	*/
	
	if($tbl_name == 'tbl_clear_sales'){
		$select_smt .= "SELECT DATE_FORMAT(a.sales_month, '%b-%Y') as sales_month,a.branch,a.emp_code,a.emp_name,a.dept,a.std_team_name,a.ecs_cont_count,a.ecs_cont_amt,a.nonecs_cont_count,a.nonecs_cont_amt,a.ecs_clearance,a.total_cont_count,total_sales_excl_ecs_accrued,a.total_sales_incl_ecs_accrued,b.empcode,b.added_on, if(b.date_of_leaving ='0000-00-00 00:00:00','',b.date_of_leaving) as date_of_leaving,IF(b.delete_flag=0 and b.resign_flag=1 ,'Active','Non-Active')as `status`
	FROM test.tbl_clear_sales a
	JOIN	global_mis.hr_all_daily b ON a.emp_code = b.empcode
	WHERE ";
		$value .= " AND sales_month >= '$start_data' AND sales_month <= '$end_data' ";
		if($std_team_name == 'All')
		$value .="";
		else
		$value .= " AND std_team_name = '$std_team_name'";
		
		
	}else{
		$select_smt= "SELECT DATE_FORMAT(expense_month, '%b-%Y') as expense_month,branch,emp_code,emp_name,dept,incentive_type,
						MAX(CASE WHEN incentive_type = 'ECS Incentive' THEN incentives END) ECS_Incentive,
						MAX(CASE WHEN incentive_type = 'NON-ECS Incentive' THEN incentives END)NON_ECS_Incentive,
						MAX(CASE WHEN incentive_type = 'JDA' THEN incentives END) JDA,
						MAX(CASE WHEN incentive_type = 'Manager Incentive' THEN incentives END) Manager_Incentive,
						MAX(CASE WHEN incentive_type = 'Addon' THEN incentives END) Addon,
						sum(incentives) as Total_Incentives from test.$tbl_name WHERE ";
		$value .= " AND expense_month >= '$start_data' AND expense_month <= '$end_data' group by expense_month,emp_code,dept ";
	}

	$query[$tbl_name]  = $select_smt . $value."";
	
}
###################################################END###############################################
$join_select_query = "SELECT a.sales_month,a.branch,a.emp_code,a.emp_name,a.dept,a.std_team_name,DATE_FORMAT(a.added_on,'%Y-%m-%d') as Date_of_Joining,DATE_FORMAT(a.date_of_leaving,'%Y-%m-%d') as Date_of_Leaving,a.status as Status,";
if($tbl_clear_sales){
	$join_select_query .=" ecs_cont_count,nonecs_cont_count,ecs_cont_count,ecs_cont_amt,nonecs_cont_count,nonecs_cont_amt,ecs_clearance,total_cont_count,total_sales_excl_ecs_accrued,total_sales_incl_ecs_accrued,";
}
if($tbl_incentives){
	$join_select_query .=" ECS_Incentive,NON_ECS_Incentive,JDA,Manager_Incentive,Addon,Total_Incentives,";
}
$join_select_query = trim($join_select_query,',');


	  $fnl_query = $join_select_query." FROM (".$query['tbl_clear_sales'].") a JOIN (".$query['tbl_incentives'].") b ON a.emp_code=b.emp_code AND a.dept=b.dept AND a.branch=b.branch AND a.sales_month = b.expense_month ORDER BY a.branch";

//exit;
		
	$exec_qry = mysqli_query($con,$fnl_query) or die(mysql_error());									   

	$i=0;
	$html='<div id="searchDiv" style="margin-left: 550px; ">
				<div class="col-md-4">
					<input type="text" class="form-control" id="search_emp_name" name="search_emp_name" placeholder="EmpName Search" required /> 
				</div>
				<div class="col-md-4">
					<input type="text" class="form-control" id="search_emp_code" name="search_emp_code" placeholder="EmpCode Search" required /> 
				</div>
				<div class="col-md-4">
				</div>
			</div>
			<br/><br/>';
	$html.= '<table id="example" name="example" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" data-project-id="3" >';
		$columns = array();
		$resultset = array();
		while ($row = mysqli_fetch_assoc($exec_qry)) { //print_r($row);exit;
			$data[$tbl_name][$i++] = $row;
			if (empty($columns)) {
				$columns = array_keys($row);
				
				$html.= '<thead><tr><th>'.implode('</th><th>',array_map('ucwords', $columns)).'</th></tr></thead>';
			}
			$resultset[$tbl_name][] = $row;
			$html.='<tr><td>'.implode('</td><td>', $row).'</td></tr>';
	}
	$html.= '</table>
			<!--div id="searchDiv" style="margin-left: 550px; ">
				<div class="col-xs-4">
					<input type="text" class="form-control" id="search_emp_name" name="search_emp_name" placeholder="EmpName Search" required /> 
				</div>
				<div class="col-xs-4">
					<input type="text" class="form-control" id="search_emp_code" name="search_emp_code" placeholder="EmpCode Search" required /> 
				</div>
			</div-->';
		
	
	

echo $html;


//print_r($data);exit;





function curlCall($apiurl) {
	$ch = curl_init($apiurl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	$jsonn = curl_exec($ch);
	//echo "<pre>";
	//print_r(curl_getinfo($ch));
	curl_close($ch);
	$api_data = json_decode($jsonn,true);
	return $api_data;
}


?>
