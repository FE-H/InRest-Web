<?php
	
	if(!empty($_POST["mailInf"]))
	{
		$mailInf = explode("||", $_POST["mailInf"]);
		
		include "..\DB_Conn\db_conn.php";
		SEND_RESET_EMAIL(false, $mailInf);
	}
	else
		echo "Failed to contact server. Please try again";
?>