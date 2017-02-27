<?php
	header('Content-type=application/json; charset=utf-8');

	include "../DB_Conn/db_conn.php";
	GET_DATA("restaurant_data", False);
?>