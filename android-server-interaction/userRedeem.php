<?php
	include "../DB_CONN/db_conn.php";
	
	if(!empty($_POST["data"]))
	{	
		$data = explode("||", $_POST["data"]);
		GEN_COUPON($data);
	}
	else
		echo "Error! Failed to receive data";
?>