<?php
	if(!empty($_POST["use"]))
	{
		include "..\DB_Conn\db_conn.php";
		CLAIM_COUPON($_POST["use"]);
	}
	else
		echo "";
?>