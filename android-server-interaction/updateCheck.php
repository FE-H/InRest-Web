<?php
	if(!empty($_POST["dataArray"])){
		$dataArray = explode("||", $_POST["dataArray"]);
		
		include "../DB_CONN/db_conn.php";
		UPDATE_DATA("user_data", False, $dataArray);
	}
	else
		echo "";

?>