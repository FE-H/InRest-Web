<?php
	if(!empty($_POST["verifyCode"]))
	{

		include "../DB_CONN/db_conn.php";
		VERIFY_RESET_CODE($_POST["verifyCode"], false);
	}
	else
		echo "";
?>