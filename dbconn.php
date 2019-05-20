<?php
class dbconn 
{
	### Generlised #######
	function getConn_general()	
	{
		$server='192.168.12.46';
				
			$link =mysql_connect($server, 'rupalid', 'rupali!@#') or die("Could not connect: ".mysql_error());
			mysql_select_db("db_product");
	}
	
		function execQry_general($sqlstr)
		{
		$this->getConn_general();
		$result = mysql_query($sqlstr) or die(mysql_error());
		$this->destroy();
		return $result;
		}
	
	function destroy() 
	{
		mysql_close();
	}
}

	

?>