<?php 
	if(!empty($_POST["loginData"]))
	{
		$loginData = explode("||", $_POST["loginData"]);
		$loginData[1] = hash("sha256", $loginData[1]);
		
		include "..\DB_Conn\db_conn.php";
		VALIDATE($loginData[0], $loginData[1], false);
	}
	else
		echo "Server Error! Failed receive data";
?>

