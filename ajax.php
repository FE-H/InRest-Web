<?php
	header('Content-type=application/json; charset=utf-8');
	$rawDat = json_decode(file_get_contents('php://input'), true);

	include "/DB_CONN/db_conn.php";
	ADMIN_OP($rawDat["tableName"], $rawDat["data"]);	
?>