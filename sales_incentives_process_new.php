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
?>
<html>
<head>
	

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	
	
	

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/offline-js/0.7.19/themes/offline-theme-slide.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/offline-js/0.7.19/themes/offline-language-english.min.css" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/offline-js/0.7.19/offline.min.js"></script>
	
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
	
	<!--script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script-->
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
	
	<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
	
	
	
</head>	
<style>
.row {margin-bottom:5px;font-size: 12px;}
table th{padding: 5px;text-align: center;font-size: 15px;}
table td{padding: 3px;text-align: center;font-size: 12px;}
.lightBlue{background-color:#D1E0FF}
.gray{background-color: #E6E6E6}
.lightOrange{background-color: #FFCEB5}
.darkBlue{background-color: #B2B2D1}

</style>

<script type="text/javascript">
	
$(function() {
	
	
	 $("#fDate,#tDate").datepicker({
        dateFormat: 'M-y',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,

        onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('M-y', new Date(year, month, 1)));
        }
    });

    $("#fDate,#tDate").focus(function () {
        $(".ui-datepicker-calendar").hide();
       // $("#ui-datepicker-div").position({
       //     my: "center top",
       //     at: "center bottom",
       //     of: $(this)
     //   });
    });

  	//$("#fDate,#tDate").datepicker({
	//	dateFormat: 'M-y',maxDate:0
  //	});

});	


function ajaxFunction() {
	var ajaxRequest;  // The variable that makes Ajax possible!
   	try{
    	// Opera 8.0+, Firefox, Safari
      	ajaxRequest = new XMLHttpRequest();
   	} catch (e) {
      // Internet Explorer Browsers
      	try{
        	ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
      	} catch (e) {
         	try{
            	ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
         	} catch (e) {
            	// Something went wrong
            	alert("Your browser broke!");
            	return false;
         	}
      	}
   	}
   
   
	ajaxRequest.onreadystatechange = function(){
	  	if(ajaxRequest.readyState == 4){
			
			
			var ajaxDisplay = document.getElementById('ajaxdiv');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
			$('#preloader').hide();
			
			
			
			$("#example").load(function(){
				//alert("table ready");
			$("#example").DataTable( {
				dom: "Bfrtip",
				buttons: [
					"copyHtml5",
					"excelHtml5",
					"csvHtml5",
					"pdfHtml5"
				]
				} );
		} );
			
			
	  	}
	  	
	}
   
   
		
	var city = document.getElementById('city').value;
	var fDate = document.getElementById('fDate').value;
	var tDate = document.getElementById('tDate').value;
	var sel_team = document.getElementById('sel_team').value;
	
	
	
	var ckb_module_clear_sales = $('#ckb_clear_sales').is(":checked");	
	var ckb_module_incentive_paid = $('#ckb_incentive_paid').is(":checked");
	
	if(!(ckb_module_clear_sales || ckb_module_incentive_paid)){
		alert("Please checked 'Clear Sales' or 'Incentive Paid' checkbox");
		return false;
	}
	
	var ckb_team_type_tme = $('#ckb_tme').is(":checked") ; 
	var ckb_team_type_me = $('#ckb_me').is(":checked") ; 
	var ckb_team_type_jda = $('#ckb_jda').is(":checked") ; 
	
	if(!(ckb_team_type_tme || ckb_team_type_me || ckb_team_type_jda)){
		alert("Please checked 'TME' or 'TME' or 'JDA' checkbox");
		return false;
	}
	
	var queryString = "?city=" + city ;
	
	if(ckb_module_clear_sales){
		queryString +=  "&tbl_clear_sales=" + ckb_module_clear_sales ;
	}
	if(ckb_module_incentive_paid){
		queryString +=  "&tbl_incentives=" + ckb_module_incentive_paid ;
	}
	if(ckb_team_type_tme){
		queryString +=  "&tme=" + ckb_team_type_tme ;
	}
	if(ckb_team_type_me){
		queryString +=  "&me=" + ckb_team_type_me ;
	}
	if(ckb_team_type_jda){
		queryString +=  "&jda=" + ckb_team_type_jda ;
	}
		

	if(city == 'Select'){
		alert('Please Select City');
		return false;
	}
	
	if(sel_team == 'Select'){
		alert('Please Select Team');
		return false;
	}

	if(fDate.length == 0){
		alert('Please Enter From Date');
		return false;
	}

	if(tDate.length == 0){
		alert('Please Enter To Date');
		return false;
	}

	

	//queryString +=  "&fDate=" + fDate + "&tDate=" + tDate + "&std_team_name=" + sel_team;
	//$('#preloader').show();
	//ajaxRequest.open("GET", "sales_process_ajaxchanges.php" + queryString, true);
	//ajaxRequest.open("GET", "sales_incentives_process.php" + queryString, true);
	//ajaxRequest.send(null);
	
	
	
}




Offline.options = {checks: {xhr: {url: '/tiny-image.gif'}}};


function fnExcelReport()
{
  // $("#example").tableExport();
  $("#example").table2excel({
		exclude: ".excludeThisClass",
		name: "Worksheet Name",
		filename: "sales_incentives_process.xls" //do not include extension
    });
    
   
}

 $(document).ready(function () {
$("#example").DataTable( {
				dom: "Bfrtip",
				buttons: [
					"copyHtml5",
					"excelHtml5",
					"csvHtml5",
					"pdfHtml5"
				]
				} );

} );



</script>



<body>
	
<div class="container" style="padding: 5px;" >
	<div class="col-xs-5">
		<a href="http://www.justdial.com"><img src="http://images.jdmagicbox.com/email_banners/Justdial_logo.gif" /></a>
	</div>
	<div class="col-xs-4">
		<a href='file_upload.php' title='Upload File' target="_blank" >Upload File</aa>

	</div>
	
	<div style="margin-left: 1020px; "><?php echo 'Hi,'.$_SESSION['username'];?></div>
    <div style="padding: 14px;margin-left: 1000px; margin-top: -11px;">
    <?php if($_SESSION['username'] == 'Balakrishna Thumma' || $_SESSION['username'] == 'Lalji Yadav'){?>
        <a href='add_user.php' title='Add User'>Add User</a> |
        <?php } ?> <a href='logout.php' title='Logout'>Logout</a>
   	</div>
   	
</div>

<hr style="width: 100%; color: black; height: 1px; background-color:black;" />

<div class="container" style="padding: 5px;"><h3>Sales & Incentive Reports</h3> 
	 <form class="form-horizontal" action="sales_incentives_process.php"  enctype="multipart/form-data">
		<div class="col-xs-4">
			<!-- Default inline 1-->
			<div class="custom-control custom-checkbox custom-control-inline">
				  <input type="checkbox" class="custom-control-input" id="ckb_clear_sales" name="ckb_clear_sales" value="clear_sales">
				  <label class="custom-control-label" for="defaultInline1">Clear Sales</label>
				
				
				  <input type="checkbox" class="custom-control-input" id="ckb_incentive_paid" name="ckb_incentive_paid" value="incentives">
				  <label class="custom-control-label" for="defaultInline2">Incentive Paid</label>
			
				
				  <!--input type="checkbox" class="custom-control-input" id="ckb_both" value="both">
				  <label class="custom-control-label" for="defaultInline3">Both</label-->
			</div>
		</div>
		<div class="col-xs-4">
		<div class="col-md-4"><label>From Month </label></div>
			<div class="col-md-6">
				<div class="input-group">
					<input type="text" class="form-control" id="fDate" name="fDate" placeholder="" required />
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
		</div>
		<div class="col-xs-4">
		<div class="col-md-4"><label>To Month </label></div>
			<div class="col-md-6">
				<div class="input-group">
					<input type="text" class="form-control" id="tDate" name="tDate" placeholder="" required />
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
		</div>
			
		<br>	<br>
		
		<div class="col-xs-4">
			
			<div class="custom-control custom-checkbox custom-control-inline">
				  <!--input type="checkbox" class="custom-control-input" id="ckb_all" value="all">
				  <label class="custom-control-label" for="defaultInline1">ALL</label-->
		
				  <input type="checkbox" class="custom-control-input" id="ckb_tme" name="ckb_tme" value="tme">
				  <label class="custom-control-label" for="defaultInline2">TME</label>
		
				
				  <input type="checkbox" class="custom-control-input" id="ckb_me" name="ckb_me" value="me">
				  <label class="custom-control-label" for="defaultInline3">ME</label>
				  
				  <input type="checkbox" class="custom-control-input" id="ckb_jda" name="ckb_jda"  value="jda">
				  <label class="custom-control-label" for="defaultInline3">JDA</label>
			</div>
		</div>
		
		<div class="col-xs-4">
			
			<div class="col-md-4"><label>Select City </label></div>
			<div class="col-md-5">
				<select class="form-control" id="city" name="city">
					<option value="Select" style="color: graytext;">Select City</option>
					<?php foreach($branch_array as $branch){ ?>
						
					<option value="<?php echo $branch ?>"><?php echo ucfirst($branch) ?></option>
					
					<?php } ?>
					<option value="All">All</option>
				</select>
			</div>
			
		</div>
		
		<div class="col-xs-4">
			
			<div class="col-md-4"><label>Select Team </label></div>
			<div class="col-md-5">
				<select class="form-control" id="sel_team" name="sel_team">
					<option value="Select" style="color: graytext;">Select Team</option>
					<?php foreach($team_array as $team){ ?>
						
					<option value="<?php echo $team ?>"><?php echo ucfirst($team) ?></option>
					
					<?php } ?>
					<option value="All">All</option>
				</select>
			</div>
			
		</div>
		
			<br></br>
			<br>
			
			<div style="margin-left: 550px; ">
					<input type="submit" class="btn btn-primary" id="getResults" name="getResults" value="Submit" onclick='javascript:ajaxFunction();'/>
			</div>
			
<hr style="width: 100%; color: black; height: 1px; background-color:black;" />		
			
			</form>
			<div id="preloader" style="display:none"><b> Loading Results <img src ="image.gif"> </b></div>
			
			<br>
			<div id="ajaxdiv"> 
				
				<?php 
				//print_r($_GET);
				if( isset($_GET["fDate"])  &&  isset($_GET["tDate"])  &&  isset($_GET["city"])  && isset($_GET["sel_team"])  &&  (  isset($_GET["ckb_clear_sales"]) ||  isset($_GET["ckb_incentive_paid"]) )  && ( isset($_GET["ckb_tme"]) || isset($_GET["ckb_me"]) || isset($_GET["ckb_jda"]) ) ){
				
									$curr_start_date  = $_GET["fDate"];
									$curr_end_date 	 = $_GET["tDate"];
									$city  = $_GET["city"];
									$std_team_name 	 = $_GET["sel_team"];

									//TRUE OR FALSE
									$tbl_clear_sales 	 = $_GET["ckb_clear_sales"];
									$tbl_incentives 	 = $_GET["ckb_incentive_paid"];

									$table_array  = array();
									array_push($table_array, 'tbl_clear_sales');
									array_push($table_array, 'tbl_incentives');

									//print_r($table_array);


									$tme  = $_GET["ckb_tme"];
									$me  = $_GET["ckb_me"];
									$jda  = $_GET["ckb_jda"];




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
										
										if($tbl_name == 'tbl_clear_sales'){
											$select_smt = "SELECT x.*,y.added_on,y.date_of_leaving,y.status FROM(";
											$select_smt .= "SELECT DATE_FORMAT(sales_month, '%b-%y') as sales_month,branch,emp_code,emp_name,dept,std_team_name,ecs_cont_count,ecs_cont_amt,nonecs_cont_count,nonecs_cont_amt,ecs_clearance,total_cont_count,total_sales_excl_ecs_accrued,total_sales_incl_ecs_accrued from test.$tbl_name WHERE ";
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
											$select_smt= "SELECT DATE_FORMAT(expense_month, '%b-%y') as expense_month,branch,emp_code,emp_name,dept,incentive_type,
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
										$html='';
										$html.= '<table id="example" name="example" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%" data-project-id="3" >';
											$columns = array();
											$resultset = array();
											while ($row = mysqli_fetch_assoc($exec_qry)) { //print_r($row);exit;
												$data[$tbl_name][$i++] = $row;
												if (empty($columns)) {
													$columns = array_keys($row);
													
													$html.= '<tr><th>'.implode('</th><th>',array_map('ucwords', $columns)).'</th></tr>';
												}
												$resultset[$tbl_name][] = $row;
												$html.='<tr><td>'.implode('</td><td>', $row).'</td></tr>';
										}
									
										$html.= '</table>
												<div id="ExcelReport" style="margin-left: 550px; ">
														<input type="button" class="btn btn-primary" id="getResults" name="getResults" value="Export" onclick="javascript:fnExcelReport();"/>
												</div>';
											
										
										

									print_r( $html);


			}
				
				?>
			
	
		  </div>
			<br></br>
			
			
	</div>
</body>
</html>


<script>
function ExportToExcel() {
    var contents = $("#ajaxdiv").html();
    alert(contents)
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent(contents));
}

		$(document).ready(function () {
$("#example").DataTable( {
				dom: "Bfrtip",
				buttons: [
					"copyHtml5",
					"excelHtml5",
					"csvHtml5",
					"pdfHtml5"
				]
				} );

} );	

	</script>



