<?php
	if(!empty($_POST["registrationData"]))
	{
		$register = explode("||", $_POST["registrationData"]);
		$register[1] = hash("sha256", $register[1]);

		include "../DB_CONN/db_conn.php";
		REGISTER($register, False);
	}
	else
		echo "";
?>