<?php
	include "db_conn.php";
	
	$dbConn = mysqli_connect($host, $username, $password, $database);
	$today = date("j/n/Y");
	
	echo $today;
	
	if($dbConn)
	{
		//set expired
		$query = "UPDATE coupon_data SET (CouponExpiry) VALUES('Expired')";
		//dispose
		$query2 = "SELECT CouponExpiry FROM coupon_data WHERE CouponStatus='Expired'";
		
		$testQ = "SELECT CouponExpiry FROM coupon_data";
		$result = mysqli_query($dbConn, $testQ);
		
		if($result)
			while($row=mysqli_fetch_row($result))
				echo "<br>".$row[0];
		else
			echo mysqli_error($dbConn);

	}
	else
		echo mysqli_error($dbConn);
	
?>