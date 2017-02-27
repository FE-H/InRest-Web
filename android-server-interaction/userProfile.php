<?php 
	include "../DB_CONN/db_conn.php";

	if(!empty($_POST["dataArray"]))
	{
		$dataArray = explode("||", $_POST["dataArray"]);
		$mode = $dataArray[0];

 		if(count($dataArray) > 2 && !in_array("edit", $dataArray))
		{
			$data = array();
			for($ctr = 1; $ctr < count($dataArray); $ctr++)//starts at index 1
			{
				$data[] = $dataArray[$ctr];
			}
		}
		else if(count($dataArray) == 2)
			$data = $dataArray[1];
		
		if($mode == "view")
			GET_DATA("user_data", false, $data);
		else if($mode == "edit")
		{
			if($dataArray[count($dataArray)-1] != "NaN")
				UPDATE_DATA("user_data", false, $dataArray);
			else if($dataArray[count($dataArray)-1] == "NaN")
				RESET_PASSWORD($dataArray, false);
		}
		else
			echo ""; 
	}
	else 
		echo "";
?>