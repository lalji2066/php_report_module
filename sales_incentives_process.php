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
        $("#ui-datepicker-div").position({
            my: "center top",
            at: "center bottom",
            of: $(this)
        });
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
   
   
//	ajaxRequest.onreadystatechange = function(){
//	  	if(ajaxRequest.readyState == 4){
//			
//			
//			var ajaxDisplay = document.getElementById('ajaxdiv');
//			//ajaxDisplay.innerHTML = ajaxRequest.responseText;
//			var ajaxRes = ajaxRequest.responseText;
//			//console.log(ajaxRes);
//			$('#ajaxdiv').append(ajaxRes);
//			$('#preloader').hide();
//			
//			$("#example").load(function(){
//				//alert("table ready");
//			$("#example").DataTable( {
//				dom: "Bfrtip",
//				buttons: [
//					"copyHtml5",
//					"excelHtml5",
//					"csvHtml5",
//					"pdfHtml5"
//				]
//				} );
//		} );
			
			
//	  	}
//	  	console.log('TTTTTT');
//	  	console.log($("#example"));
	  	
//	}
		
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

	

	queryString +=  "&fDate=" + fDate + "&tDate=" + tDate + "&std_team_name=" + sel_team;
	$('#preloader').show();
	//ajaxRequest.open("GET", "sales_process_ajaxchanges.php" + queryString, true);
	//ajaxRequest.send(null);
	$.ajax({
            type: 'GET',
            url: "sales_process_ajaxchanges.php" + queryString,
            success:function(data){
             $('#ajaxdiv').html(data);
             $('#preloader').hide();
             $("#example").dataTable().fnDestroy();
             
             var table = $("#example").DataTable( {
				dom: "Bfrtip",
				bFilter: false,
				searching: true,
				//dom: "t",
				buttons: [
					{
						extend: 'copyHtml5',
						title: 'report_'+Math.round(+new Date()/1000)
					},
					{
						extend: 'excelHtml5',
						title: 'report_'+Math.round(+new Date()/1000),
						extension: '.xls'
					},
					{
						extend: 'csvHtml5',
						title: 'report_'+Math.round(+new Date()/1000)
					},
					{
						extend: 'pdfHtml5',
						title: 'report_'+Math.round(+new Date()/1000),
						orientation: 'landscape',
						pageSize: 'A1'
					}
					//"copyHtml5",
				//	"excelHtml5",
					//"csvHtml5",
					//"pdfHtml5"
				]
				} );
				
				
				 
						// #column3_search is a <input type="text"> element
						$('#search_emp_name').on( 'keyup', function () { //console.log(table.columns( 3 )); alert(table.columns( 3 ));
							
							table
								.columns( 3 )
								.search( this.value )
								.draw();
						} );
						
						$('#search_emp_code').on( 'keyup', function () { //console.log(table.columns( 3 )); alert(table.columns( 3 ));
							
							table
								.columns( 2 )
								.search( this.value )
								.draw();
						} );
            }
        });
	
}

Offline.options = {checks: {xhr: {url: '/tiny-image.gif'}}};


function fnExcelReport()
{
  $("#example").table2excel({
		exclude: ".excludeThisClass",
		name: "Worksheet Name",
		filename: "sales_incentives_process.xls" //do not include extension
    });
    
   
}
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
		<div class="col-xs-4">
			<!-- Default inline 1-->
			<div class="custom-control custom-checkbox custom-control-inline">
				  <input type="checkbox" class="custom-control-input" id="ckb_clear_sales" value="clear_sales">
				  <label class="custom-control-label" for="defaultInline1">Clear Sales</label>
				
				
				  <input type="checkbox" class="custom-control-input" id="ckb_incentive_paid" value="incentives">
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
		
				  <input type="checkbox" class="custom-control-input" id="ckb_tme" value="tme">
				  <label class="custom-control-label" for="defaultInline2">TME</label>
		
				
				  <input type="checkbox" class="custom-control-input" id="ckb_me" value="me">
				  <label class="custom-control-label" for="defaultInline3">ME</label>
				  
				  <input type="checkbox" class="custom-control-input" id="ckb_jda" value="jda">
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
					<input type="button" class="btn btn-primary" id="getResults" name="getResults" value="Submit" onclick='javascript:ajaxFunction();'/>
			</div>
			
<hr style="width: 100%; color: black; height: 1px; background-color:black;" />		
			

			<div id="preloader" style="display:none"><b> Loading Results <img src ="image.gif"> </b></div>
			
			<br>
			<div id="ajaxdiv"> </div>
			<br></br>
			
			
	</div>
</body>
</html>





