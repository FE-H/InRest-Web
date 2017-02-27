<?php
	$host = "localhost";
	$username = "root";
	$password = "rootacc";
	
	$database = "inrestaurant";

	$restDat = "restaurant_data";
	$userDat = "user_data";
	$staffDat = "staff_data";

	$dbConn = mysqli_connect($host, $username, $password, $database);
	
	define("dirSave", "E:/Server/wamp64/www/fyp/assets/img/restaurant_logo/");

	//Output
	function GET_DATA($tableName, $isAdmin, $data = null)
	{
		global $dbConn;

		if(!$dbConn)
		{
			//Invalid Connection
			echo "Unable to establish a connection to host\n\n".mysqli_connect_errno().PHPEOL."<br>";
		}
		else
		{
			//Valid Connection
			if($tableName == "restaurant_data" && $data == null)
				GET_RESTDAT($dbConn, $isAdmin);
			else if($tableName == "staff_data"&& $data == null)
				GET_STAFFDAT($dbConn);
			else if(!$isAdmin && $tableName == "user_data")
				GET_DAT_SINGLE($dbConn, $tableName, $data);
		}
	}
	
	//Called by ajax.php
	//Serves as the updater & getter for admin web portal
	function ADMIN_OP($tableName, $data)
	{
		global $dbConn;
		
		if($dbConn)
		{
			if ($tableName == "staff_data")
			{
				if(count($data) == 3)
					REGISTER($data, true);
				else if(count($data) > 3)
					UPDATE_DATA($tableName, true, $data);
				else if(count($data) < 3)
					GET_DAT_SINGLE($dbConn, $tableName, $data);

			}
			else if($tableName == "restaurant_data")
			{
				if($data != "FetchNumRows")
				{
					if(count($data) == 9)
						UPDATE_DATA($tableName, true, $data);
					else if(count($data) < 3)
						GET_DAT_SINGLE($dbConn, $tableName, $data);
					else if(count($data) == 8)
						REGISTER($data, true, $tableName);	
				}	
				else if($data == "FetchNumRows")
					GET_NUM_ROWS($dbConn, $data);
			}
		}
	}

	//Input
	//REQUIRES ATTENTION
	function UPDATE_DATA($tableName ,$isAdmin, $dataArray, $dbConn = null)
	{
		if($dbConn == null)
			global $dbConn;	

		if($dbConn && !$isAdmin)
		{
			if($tableName == "user_data")
			{
				if(in_array("No", $dataArray) || in_array("Yes", $dataArray))
				{
					UPDATE_USER_CHECKIN($dbConn, $dataArray);
				}
				else
				{
					$dataCount = count($dataArray);
				
					//Cleans up the first two input, username and useremail
					for($ctr = 0; $ctr < count($dataArray); $ctr++)
					{
						$dataArray[$ctr] = ($ctr == count($dataArray)-1)? hash("sha256", $dataArray[$ctr]) : mysqli_real_escape_string($dbConn, $dataArray[$ctr]);
					}
					
					$prev = "SELECT uName, userEmail, uPword FROM user_data WHERE userID='".$dataArray[2]."';";
					$prevResult = mysqli_query($dbConn, $prev);
					if($prevResult)
						$prevRow = mysqli_fetch_array($prevResult);
					else
						echo mysqli_error($dbConn);
				
					$column = ($dataCount > 5)? "SET uName='".$dataArray[3]."', userEmail='".$dataArray[4]."'" : "SET uPword='".hash("sha256",$dataArray[3])."'"; 
					$condition = "userID='".$dataArray[2]."' AND uPword='".$dataArray[$dataCount-1]."';"; 
					
					$query = "UPDATE user_data ".$column." WHERE ".$condition;
					$result = mysqli_query($dbConn, $query);
					
					if($result)
					{
						if(mysqli_affected_rows($dbConn) == 0)
						{
							$new = $prev;
							$newResult = mysqli_query($dbConn, $new);
							if($newResult)
							{
								$newRow = mysqli_fetch_array($newResult);
								if($prevRow[0] == $newRow[0] || $prevRow[1] == $newRow[1] || $prevRow[2] == $newRow[2] )
									echo "No new data has been provided";
								else
									echo "Invalid Password";
							}
							else 
								echo mysqli_error($dbConn);
						}
						else
							echo "success";
					}
					else
						echo mysqli_error($dbConn);
				}
			}
			else
				echo "";
		}
		else if($dbConn && $isAdmin)
		{
			$prevFile = "";
			
			if($tableName == "staff_data")
			{
				$success = "Your account information has been updated successfully";
				$fail = "Your account information has failed to be updated";

				$dataArray["staffName"] = mysqli_real_escape_string($dbConn, $dataArray["staffName"]);
				$dataArray["staffContactNo"] = mysqli_real_escape_string($dbConn, $dataArray["staffContactNo"]);
				$dataArray["staffEmail"] = mysqli_real_escape_string($dbConn, $dataArray["staffEmail"]);
			
				if($dataArray["staffLogin"] == "")
				{
					$column = " SET staffName='".$dataArray["staffName"]."', staffContactNo='".$dataArray["staffContactNo"]."', staffEmail='".$dataArray["staffEmail"];
					$condition ="staffID='".$dataArray["staffID"]."'";
				}
				else
				{
					$column = " SET staffName='".$dataArray["staffName"]."', staffContactNo='".$dataArray["staffContactNo"]."', staffEmail='".$dataArray["staffEmail"]."', staffLogin='".hash("sha256", $dataArray["staffLogin"]);
					$condition ="staffID='".$dataArray["staffID"]."' AND staffLogin='".hash("sha256", $dataArray["staffLoginCurr"])."'";
				}
			}
			else 
			{
				$dataArray["restaurantName"] = mysqli_real_escape_string($dbConn, $dataArray["restaurantName"]);
				$dataArray["restaurantType"] = mysqli_real_escape_string($dbConn, $dataArray["restaurantType"]);
				$dataArray["restaurantLot"] = mysqli_real_escape_string($dbConn, $dataArray["restaurantLot"]);
				$dataArray["restaurantOwner"] = mysqli_real_escape_string($dbConn, $dataArray["restaurantOwner"]);
				$dataArray["restaurantContact"] = mysqli_real_escape_string($dbConn, $dataArray["restaurantContact"]);
				$dataArray["restaurantEmail"] = mysqli_real_escape_string($dbConn, $dataArray["restaurantEmail"]);
				$dataArray["imageMetadata"] = mysqli_real_escape_string($dbConn, $dataArray["imageMetadata"]);
				
				$success = "This restaurant's information has been updated successfully";
				$fail = "This information's information has failed to be updated";

				$column = " SET restaurantName='".$dataArray["restaurantName"]."', restaurantType='".$dataArray["restaurantType"]."', restaurantLot='".$dataArray["restaurantLot"]."', restaurantOwner='".$dataArray["restaurantOwner"]."', restaurantContact='".$dataArray["restaurantContact"]."', restaurantEmail='".$dataArray["restaurantEmail"]."', restaurantLogoURL='".$dataArray["imageMetadata"];
				$condition ="restaurantID= '".$dataArray["restaurantID"]."'";
				
				//Get previous logo filename
				$prevFileQuery = "SELECT restaurantLogoURL FROM restaurant_data WHERE ".$condition;
				$prevResult = mysqli_query($dbConn, $prevFileQuery);
				
				if($prevResult)
				{
					if(mysqli_affected_rows($dbConn) == 0)
						echo "Server Error : ID given does not exist in database\nID Given\t:".$dataArray["restaurantID"];
					else
					{
						$row = mysqli_fetch_row($prevResult);
						$prevFile = $row[0];
					}
				}
				else
					echo $prevFileQuery."\n".mysqli_error($dbConn)."\n\n";
			}
			
			$query = "UPDATE ".$tableName.$column."' WHERE ".$condition;
			$result = mysqli_query($dbConn, $query);

			//successful query
			if($result)
			{
				//no rows affected
				if(mysqli_affected_rows($dbConn) == 0)
				{
					if($prevFile == "")
						echo "No new data has been provided";
					else
					{
						//gets the image extension from the posted data
						$imageExtension = explode(".", $dataArray["imageMetadata"]);
						
						//gets the base 64 string of the file n th
						$prevBase64 = base64_encode(file_get_contents(dirSave.$prevFile));
						$prevBase64 = str_replace('data:image/'.$imageExtension[1].'base64,', '', $prevBase64);
						
						//check if the two files are the same
						if($prevBase64 == $dataArray["imageData"])
							echo "No new data has been provided";
						else
						{
							if(unlink(dirSave.$prevFile))
							{
								$img = base64_decode($dataArray["imageData"]);
								file_put_contents(dirSave.$dataArray["imageMetadata"], $img);
								
								echo $success;
							}
							else
								echo "Logo update has failed";
						}
					}
				}
				else
				{
					//more than 0 rows affected
					if($tableName == "restaurant_data")
					{
						//gets the image extension from the previous ile
						$imageExtension = explode(".", $prevFile);
						
						if($prevFile != "")
						{
							//gets the base 64 string of the file
							$prevBase64 = base64_encode(file_get_contents(dirSave.$prevFile));
							$prevBase64 = str_replace('data:image/'.$imageExtension[1].'base64,', '', $prevBase64);
						}
						
						if($prevFile != "" && $prevBase64 == $dataArray["imageData"])
							echo $success." No logo has been provided";
						else if($dataArray["imageMetadata"] == "")
						{
							$restoreQuery = "UPDATE ".$tableName." SET restaurantLogoURL='".$prevFile."' WHERE ".$condition;
							$restore = mysqli_query($dbConn, $restoreQuery);
							
							if($restore)
							{
								if(mysqli_affected_rows($dbConn) != 0)
									echo "No new data provided";
								else
									echo "Error-Failed to reset value to previous value";
							}
							else
								echo "Error-Failed to reset value to previous value";
						}
						else if($prevFile == "")
						{
							$img = base64_decode($dataArray["imageData"]);
							file_put_contents(dirSave.$dataArray["imageMetadata"], $img);
							
							echo $success;
						}
						else
						{
							if(unlink(dirSave.$prevFile))
							{
								$img = base64_decode($dataArray["imageData"]);
								file_put_contents(dirSave.$dataArray["imageMetadata"], $img);
								
								echo $success;
							}
							else
								echo $success." Failed to update logo";
						}
					}
					else
						echo $success;
				}
			}
			else
				echo $query."\n".mysqli_error($dbConn);
		}
		else if(!$dbConn && (!$isAdmin||$isAdmin))
			echo "Error - Invalid Connection";
		else
			echo "Error - Invalid Parameter";
	}

	//Get restaurant data
	function GET_RESTDAT($dbConn, $isAdmin)
	{
		global $restDat;

		if(!$isAdmin)
		{
			//Retrieve all fields in restaurant data table
			$query = "SELECT * FROM ".$restDat;
		}
		else if($isAdmin)
		{
			$query = "SELECT restaurantName, restaurantLot, restaurantVacancy FROM ".$restDat;	
		}

		$result = mysqli_query($dbConn, $query);

		//Valid query
		if($result)
		{
			if(mysqli_num_rows($result) != 0)
			{
				//Query has results
				//Returns all result
				RESULT_LOOP($isAdmin, $result, $restDat);
			}
			else
			{
				//Empty
				echo "Error - Empty Result";
			}
		}
		else
		{
			//Invalid query
			echo "Error - Invalid Query";
		}
	}

	//Only Sys Admin will make this query, hence no $isAdmin here.
	function GET_STAFFDAT($dbConn)
	{
		global $staffDat;

		//Retrieve name, contact number, email from staff data table
		$query = "SELECT staffName, staffContactNo, staffEmail FROM ".$staffDat;	
		$result = mysqli_query($dbConn, $query);

		if($result)
		{
			if(mysqli_num_rows($result) != 0)
			{
				RESULT_LOOP(True, $result, $staffDat);
			}
			else
			{
				//Empty
				echo "Error - Empty Result";
			}
		}
		else
		{
			//Invalid query
			echo "Error - Invalid Query";
		}
	}

	//Helper function to loop table
	function RESULT_LOOP($isAdmin, $result, $tableName, $data = null)
	{
		$loopTime = 1;

		while($row = mysqli_fetch_assoc($result))
		{
			if($isAdmin && $tableName == "staff_data" && $data == null)
				echo "<tr><td>".$loopTime."</td>"."<td>".$row['staffName']."</td>"."<td>".$row['staffContactNo']."</td>"."<td>".$row['staffEmail']."</td>"."</tr>";
			else if($isAdmin && $tableName == "restaurant_data" && $data == null)
				echo "<tr><td>".$loopTime."</td>"."<td>".$row['restaurantName']."</td>"."<td>".$row['restaurantLot']."</td>"."<td>".$row['restaurantVacancy']."</td>"."</tr>";
			else if((!$isAdmin && $tableName == "restaurant_data")||($isAdmin && $tableName == "restaurant_data" && $data == "FetchNumRows"))
			{
				$output[] = $row;
			}

			$loopTime = $loopTime + 1;
		}

		if(isset($output) && $data == null)
			echo json_encode($output);
		else if(isset($output) && $data == "FetchNumRows")
		{
			for($ctr=0; $ctr < count($output); $ctr++)
			{
				echo $output[$ctr]["restaurantName"];
				if($ctr < count($output)-1)
					echo ", ";
			}
		}
	}

	function UPDATE_USER_CHECKIN($dbConn, $dataArray)
	{
		global $userDat, $restDat;
		$dataArray[0] = mysqli_real_escape_string($dbConn, $dataArray[0]);

		if($dataArray[2] == "No")
		{
			$statusVal = 2;
			$columnUp = " SET userStatus = ".$statusVal." ";
			$updateVal = "restaurantVacancy+1";
		}
		else if ($dataArray[2] = "Yes")
		{
			$statusVal = 1;
			$columnUp = " SET userStatus = ".$statusVal.", userPoint = userPoint+5 ";
			$updateVal = "restaurantVacancy-1";
		}
		else
			echo "0";

		$query = "UPDATE ".$userDat.$columnUp."WHERE uName = '".$dataArray[0]."' AND userID = '".$dataArray[1]."'";
		$query2 = "UPDATE ".$restDat." SET restaurantVacancy = ".$updateVal." WHERE restaurantID = '".$dataArray[3]."'";
		$checkQuery = "SELECT restaurantVacancy FROM ".$restDat." WHERE restaurantID = '".$dataArray[3]."'";

		$result = mysqli_query($dbConn, $query);
		if($result)
		{
			$result = mysqli_query($dbConn, $checkQuery);
			if($result)
			{
				if(mysqli_num_rows($result) != 0)
				{
					$row = mysqli_fetch_row($result);
					if($row[0] < 100)
					{
						$result = mysqli_query($dbConn, $query2);
						if($result)
							echo $statusVal;
						else
							echo "";
					}
					else
						echo "";
				}
				else
					echo "";
			}
			else
				echo "";
		}
		else
			echo "";
	}

	//Validates the login credentials		
	function VALIDATE($username, $password, $isAdmin)
	{
		global $dbConn;

		if($dbConn)
		{
			$username = mysqli_real_escape_string($dbConn, $username);

			if($isAdmin)
			{
				global $staffDat;

				$columnNames = "staffName";
				$tableName = $staffDat;
				$name = "staffName";
				$login = "staffLogin";

				$message = "<script>alert('Invalid User Login Credentials');</script><meta http-equiv='refresh' content='0.01;URL=index.php'>";
			}
			else
			{
				global $userDat;
			
				$columnNames = "uName";	
				$tableName = $userDat;
				$name = "uName";
				$login = "uPword";

				$message = "Invalid username and/or password";
			}

			$query = "SELECT ".$columnNames." From ".$tableName." WHERE ".$name." = '".$username."' AND ".$login." = '".$password."'";
			$result = mysqli_query($dbConn, $query);

			if($result)
			{
				if(mysqli_num_rows($result) != 0)
				{
					if($isAdmin)
					{
						$query = "SELECT staffID FROM ".$tableName." WHERE ".$name." = '".$username."' AND ".$login." = '".$password."'";
						$result = mysqli_query($dbConn, $query);

						if($result)
						{
							$row = mysqli_fetch_row($result);
							session_start();
							$_SESSION["uID"] = $row[0];
							$_SESSION["uName"] = $username;		
							header("LOCATION:tables.php");
						}
						else
						{
							echo $query;
						}
					}
					else
					{
						$query = "SELECT userID FROM ".$tableName." WHERE ".$name." = '".$username."' AND ".$login." = '".$password."'";
						$result = mysqli_query($dbConn, $query);
						
						if($result)
						{
							if(mysqli_num_rows($result) > 0)
							{
								$row = mysqli_fetch_row($result);
								echo $row[0];
							}
							else
								echo "Server Error! Failed to retrieve account information";
						}
						else
						{
							echo "Server Error! Failed to retrieve account information";
						}
					}
				}
				else
				{
					echo $message;
					//echo "<script>alert('Invalid User Login Credentials')</script>";
					//echo "<meta http-equiv='refresh' content='0.01;URL=index.php'>";
				}
			}
			else
			{
				echo "<script>alert('Unable to establish connection to database! Please try again')</script>";
			}
		}
		else
			echo "Unable to establish connection to database. Please try again later.";
	}

	//Registers mobile users
	function REGISTER($registrationData, $isAdmin, $tableName = null)
	{
		global $dbConn;

		if(!$isAdmin)
		{
			global $userDat;			
			$tableName = $userDat;

			$uName = mysqli_real_escape_string($dbConn, $registrationData[0]);
			$uPword = $registrationData[1];
			$uEmail = mysqli_real_escape_string($dbConn, $registrationData[2]);

			$columnNames = "uName, uPword, userEmail";
			$values = "VALUES ('".$uName."', '".$uPword."', '".$uEmail."');";
			$message = "";
		}
		else
		{
			if($tableName == null)
			{
				global $staffDat;
				$tableName = $staffDat;

				$uName = mysqli_real_escape_string($dbConn, $registrationData["staffName"]);
				$uContact = mysqli_real_escape_string($dbConn, $registrationData["staffContactNo"]);
				$uPword = hash("sha256", $uName);
				$uEmail = mysqli_real_escape_string($dbConn, $registrationData["staffEmail"]);

				$columnNames = "staffName, staffLogin, staffEmail, staffContactNo";
				$values = "VALUES ('".$uName."', '".$uPword."', '".$uEmail."', '".$uContact."')";
				$message = "Failed";
			}
			else
			{
				$rName = mysqli_real_escape_string($dbConn, $registrationData["restaurantName"]);
				$rType = mysqli_real_escape_string($dbConn, $registrationData["restaurantType"]);
				$rOwner = mysqli_real_escape_string($dbConn, $registrationData["restaurantOwner"]);
				$rLot = mysqli_real_escape_string($dbConn, $registrationData["restaurantLot"]);
				$rContact = mysqli_real_escape_string($dbConn, $registrationData["restaurantContact"]);
				$rEmail = mysqli_real_escape_string($dbConn, $registrationData["restaurantEmail"]);
				$rFname = mysqli_real_escape_string($dbConn, $registrationData["imageMetadata"]);

				if(!array_key_exists("imageData", $registrationData))
				{
					$columnNames = "restaurantName, restaurantType, restaurantOwner, restaurantLot, restaurantContact,restaurantEmail";
					$values = "VALUES ('".$rName."', '".$rType."', '".$rOwner."', '".$rLot."', '".$rContact."', '".$rEmail."')";
				}
				else
				{
					$columnNames = "restaurantName, restaurantType, restaurantOwner, restaurantLot, restaurantContact,restaurantEmail, restaurantLogoURL";
					$values = "VALUES ('".$rName."', '".$rType."', '".$rOwner."', '".$rLot."', '".$rContact."', '".$rEmail."', '".$rFname."')";
				}
				
				$message = "Failed";
			}
		}

		$query = "INSERT INTO ".$tableName." (".$columnNames.") ".$values;
		$result = mysqli_query($dbConn, $query);

		if($result)
		{
			if($isAdmin)
			{
				if($tableName == "staff_data")
				{
					$query = "SELECT staffName, staffContactNo, staffEmail, staffID FROM ".$staffDat." WHERE staffName ='".$uName."' AND staffLogin = '".hash("sha256", $uName)."'";
					$result = mysqli_query($dbConn, $query);

					if($result)
					{
						if(mysqli_num_rows($result) != 0)
						{
							$row = mysqli_fetch_assoc($result);
							echo json_encode($row);
						}
						else
							echo "Succeeded in data insertion.Error : Failed to retrieve the record.";
					}
					else
						echo "Error!".mysqli_error($dbConn);
				}
				else
				{
					$img = base64_decode($registrationData["imageData"]);
					file_put_contents(dirSave.$registrationData["imageMetadata"], $img);
					
					echo "A new Restaurant has been added to the database";
				}
			}
			else
			{
				if(mysqli_affected_rows($dbConn) > 0)
					echo "Successful Insertion";
				else
					echo "Error! Failed to insert data";
			}
		}
		else
		{
			echo mysqli_error($dbConn);
		}
	}

	//Get a single row of data
	function GET_DAT_SINGLE($dbConn, $tableName, $data)
	{
		$additonalQuery = "";
		$additionalResult = false;
		
		if($tableName == "staff_data")
		{
			$columnNames = "staffID, staffName, staffContactNo, staffEmail";
			$col = "staffID";
		}
		else if($tableName == "restaurant_data")
		{
			$columnNames = "restaurantID, restaurantName, restaurantType, restaurantLot, restaurantOwner, restaurantContact, restaurantEmail";
			$col = "restaurantName";
		}
		
		if($tableName == "user_data")
		{
			$columnNames = "userID, uName, userEmail, userPoint";
			$col = "userID";
			
			$additionalQuery = "SELECT CouponCode, CouponValue, CouponExpiry FROM coupon_data WHERE ClaimedUserID='".$data."';";
		}

		$query = "SELECT ".$columnNames." FROM ".$tableName." WHERE ".$col."='".$data."'";
		$result = mysqli_query($dbConn, $query);

		if($result)
		{
			if(mysqli_num_rows($result) != 0 )
			{
				$row = mysqli_fetch_assoc($result);

				if($tableName == "user_data")
				{
					$additionalResult = mysqli_query($dbConn, $additionalQuery);
				
					if($additionalResult)
					{
						if(mysqli_num_rows($additionalResult) == 0)
							echo json_encode($row);
						else 
						{
							while($additional = mysqli_fetch_assoc($additionalResult))
							{
								$additionalRow[] = $additional;
							}
						
							$row["CouponData"] = $additionalRow;
							echo json_encode($row);
						}
					}
				}
				else
					echo json_encode($row);
			}
			else
			{
				echo "Failed to retrieve a valid data";
			}
		}
		else
			echo "Server Error! Failed to retrieve data";
	}

	//Get multiple rows of data
	function GET_NUM_ROWS($dbConn, $data)
	{
		global $restDat;
	
		$query = "SELECT restaurantName FROM ".$restDat;
		$result = mysqli_query($dbConn, $query);

		if($result)
		{
			if(mysqli_num_rows($result) != 0)
			{
				RESULT_LOOP(True, $result, $restDat, $data);
			}
			else
				echo "This premise does not have a restaurant yet! Please register them as soon as possible";
		}
		else
			echo "Invalid Input";
	}
	
	//sendmail
	function SEND_RESET_EMAIL($isAdmin, $mailInf)
	{
		global $dbConn;
		
		if($isAdmin)
		{
			$success = "<script>alert('Password Reset email has been succesfully sent');</script><meta http-equiv='refresh' content='0.01;URL=resetcode.php'>";
			$fail = "<script>alert('Failed to send password reset email to your email. Please try again later');</script><meta http-equiv='refresh' content='0.01;URL=index.php'>";
			$invalid = "<script>alert('Invalid username and email combination.');</script><meta http-equiv='refresh' content='0.01;URL=forgotpassword.php'>";
			
			$condition = "WHERE staffName='".$mailInf[0]."' AND staffEmail='".$mailInf[1]."';";
			$pwordCol = "staffLogin";
			$table = "staff_data";
		}
		else
		{
			$success = "A password reset email has been sent to your email";
			$fail = "Failed to send password reset email to your email. Please try again later";
			$invalid = "Invalid username and email combination";
			
			$condition = "WHERE uName='".$mailInf[0]."' AND userEmail='".$mailInf[1]."';";
			$pwordCol = "uPword";
			$table = "user_data";
		}
		
		$query = "SELECT ".$pwordCol." FROM ".$table." ".$condition;
		$result = mysqli_query($dbConn, $query);
		
		if($result)
		{
			if(mysqli_num_rows($result) == 0)
			{
				echo $invalid;
			}
			else
			{
				$email_to = $mailInf[1];
				$subject = "Password Reset";
				$headers = "From: hofookeng.uca@gmail.com\r\nReply-To: hofookeng.uca@gmail.com\r\nX-Mailer: PHP/".phpversion();
				$rand = substr(md5(microtime()),rand(0,26),6);
				$body = "This is auto generated message please do not reply. Below is your new password. Please do reset your password once your are logged in for security purposes.<br><br><span style='font-size:3em;text-align:center'>".$rand."</span><br><br>";
	
				//disable (change condition to true) to assume mail has been sent successfully
				if(mail($email_to, $subject, $body, $headers))
				{
					$getIDQuery = ($table == "user_data")? "SELECT userID FROM user_data " : "SELECT staffID FROM staff_data ";
					$getIDQuery .= $condition;
					
					$getIDResult = mysqli_query($dbConn, $getIDQuery);
					
					$fail = ($table == "user_data")? "Server Error! Failed to retrieve account information" : "<script type='text/javascript'>alert('Server Error! Failed to retrieve account information');</script>";
					
					if($getIDResult)
					{
						$fail = ($table == "user_data")? "Server Error! Failed to retrieve account information" : "<script type='text/javascript'>alert('Server Error! Failed to retrieve account information');</script>";
						if(mysqli_num_rows($getIDResult) > 0)
						{	
							$fail = ($table == "user_data")? "Server Error! Failed to update information" : "<script type='text/javascript'>alert('Server Error! Failed to update information');</script>";
							$id = mysqli_fetch_row($getIDResult);
							
							$queryCheck = ($table == "user_data")? "SELECT userID FROM user_data " : "SELECT staffID FROM staff_data ";
							$queryCheck .= "INNER JOIN reset_code ON ";
							$queryCheck .= ($table == "user_data")? "user_data.userID" : "staff_data.staffID";
							$queryCheck .= "=reset_code.CodeUserID WHERE reset_code.CodeUserID='".$id[0]."'";
							
							$resultCheck = mysqli_query($dbConn, $queryCheck);
							
							if($resultCheck)
							{
								$fail = ($table == "user_data")? "Error! You already have a reset code!" : "<script type='text/javascript'>alert('Error! You already have a reset code!');</script><meta http-equiv='refresh' content='1;URL=resetcode.php'";
								
								if(mysqli_num_rows($resultCheck) == 0)
								{
									$fail = ($table == "user_data")? "Server Error! Failed to update information" : "<script type='text/javascript'>alert('Error! You already have a reset code!Server Error! Failed to update information');</script>";
									
									$queryReset = "INSERT INTO reset_code (CodeValue, CodeUserID, AssocTable) VALUES('".$rand."', '".$id[0]."', '".$table."');";
									$resultReset = mysqli_query($dbConn, $queryReset);
									
									if($resultReset)
									{
										if(mysqli_affected_rows($dbConn) > 0)
											echo $success;
										else
											echo $fail;
									}
									else
										echo $fail;
								}
								else
									echo $fail;
							}
							else
								echo $fail."3".mysqli_error($dbConn);
						}
						else
							echo $fail."2".mysqli_error($dbConn);
					}
					else
						echo $fail."1".mysqli_error($dbConn);

				}
				else
					echo $fail;
			}
		}
		else
			echo mysqli_error($dbConn);
	}
	
	function VERIFY_RESET_CODE($data, $isAdmin)
	{
		global $dbConn;
		
		$query = "SELECT CodeUserID, AssocTable FROM reset_code WHERE CodeValue='".$data."';";
		$result = mysqli_query($dbConn, $query);
		$fail = (!$isAdmin)? "Server Error! Failed to retrieve account information" : "<script type='text/javascript'>alert('Server Error! Failed to retrieve account information');</script><meta http-equiv='refresh' content='0.1;URL=forgotpassword.php'>";
		
		if($result)
		{
			$fail = (!$isAdmin)? "Invalid Reset Code" : "<script type='text/javascript'>alert('Invalid Reset Code');</script><meta http-equiv='refresh' content='0.1;URL=forgotpassword.php'>";
			if(mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_array($result);
				
				if(!$isAdmin)
				{
					echo $row[0];
				}
				else
				{
					session_start();
					
					$_SESSION["id"] = $row[0];
					header("LOCATION:resetpassword.php");
				}
			}
			else
				echo $fail;
		}
		else
			echo "Server Error! Failed to retrieve account information";
	}
	
	function GEN_COUPON($data)
	{
		global $dbConn;
		
		$rand_STR = substr(md5(microtime()),rand(0,26),6);
		
		$queryCheck = "SELECT CouponCode FROM coupon_data WHERE CouponCode='".$rand_STR."';";
		$result = mysqli_query($dbConn, $queryCheck);
		
		if($result)
		{
			while(mysqli_affected_rows($dbConn) > 0)
			{
				$result = mysqli_query($dbConn, $queryCheck);				
				$rand_STR = substr(md5(microtime()),rand(0,26),6);
			}
			
			$queryAdd = "INSERT INTO coupon_data ( CouponCode, CouponValue, CouponExpiry, ClaimedUserID ) VALUES('".$rand_STR."', '".$data[1]."', '".date("j, n, Y", strtotime("+15days"))."', '".$data[0]."');";
			$resultAdd = mysqli_query($dbConn, $queryAdd);
			
			if($resultAdd)
			{
				if(mysqli_affected_rows($dbConn) > 0)
				{
					$points = ($data[1] == "5%")? 10 : (($data[1] == "10%")? 30 : 50);
					
					$queryMinus = "UPDATE user_data SET userPoint = userPoint-".$points." WHERE userID = '".$data[0]."';";
					$resultMinus = mysqli_query($dbConn, $queryMinus);
					
					if($resultMinus)
					{
						if(mysqli_affected_rows($dbConn) > 0)
						{
							$querySelect = "SELECT userPoint FROM user_data WHERE userID='".$data[0]."';";
							$resultSelect = mysqli_query($dbConn, $querySelect);
							
							if($resultSelect)
							{
								if(mysqli_num_rows($resultSelect) > 0)
								{
									$row = mysqli_fetch_array($resultSelect, MYSQLI_ASSOC);
									
									$querySelect2 = "SELECT CouponCode, CouponValue, CouponExpiry FROM coupon_data WHERE ClaimedUserID='".$data[0]."';";
									$resultSelect2 = mysqli_query($dbConn, $querySelect2);
									
									if($resultSelect2)
									{
										for($counter = 0; $counter < mysqli_num_rows($resultSelect2); $counter++)
											$row2[] = mysqli_fetch_array($resultSelect2, MYSQLI_ASSOC);
										
										$row["CouponData"] = $row2;
										echo json_encode($row);
									}
									else
										echo $querySelect2."\n".mysqli_error($dbConn);
								}
								else
									echo "fail-4";
							}
							else
								echo $querySelect."\n".mysqli_error($dbConn);
						}
						else
							echo "fail-3";
					}
					else
						echo $queryMinus."\n".mysqli_error($dbConn);
				}
				else
					echo "fail-2";
			}
			else
				echo $queryAdd."\n".mysqli_error($dbConn);
		}
		else
			echo $queryCheck."\n".mysqli_error($dbConn);
	}
	
	function RESET_PASSWORD($data, $isAdmin)
	{
		global $dbConn;
		
		if($isAdmin)
		{
			$query = "UPDATE staff_data SET staffLogin='".hash("sha256", $data[3])."' WHERE staffID='".$data[2]."';";
		}
		else
			$query = "UPDATE user_data SET uPword='".hash("sha256", $data[3])."' WHERE userID='".$data[2]."';";
		
		$result = mysqli_query($dbConn, $query);
		
		$fail = (!$isAdmin)? "Server Error!".mysqli_error($dbConn) : "<script type='text/javascript'>alert('Server Error!'".mysqli_error($dbConn)."');</script>";			
		
		if($result)
		{
			$fail = (!$isAdmin)? "Server Error! Failed to retrieve account information" : "<script type='text/javascript'>alert('Server Error! Failed to retrieve account information".mysqli_error($dbConn)."');</script>";
			
			if(mysqli_affected_rows($dbConn) > 0)
			{
				$fail = (!$isAdmin)? "Server Error!".mysqli_error($dbConn) : "<script type='text/javascript'>alert('Server Error!'".mysqli_error($dbConn)."');</script>";
				
				$queryRemove = "DELETE FROM reset_code WHERE CodeUserID='".$data[2]."';";
				
				$resultRemove = mysqli_query($dbConn, $queryRemove);
				
				if($resultRemove)
				{
					$success = (!$isAdmin)? "Successfully updated the account" : "<script type='text/javascript'>alert('Successfully updated the account');</script>";
					$fail = (!$isAdmin)? "No changes were done to the account" : "<script type='text/javascript'>alert('No changes were done to the account');</script>";
					
					if(mysqli_affected_rows($dbConn) > 0)
					{
						echo $success;
						
						if($isAdmin)
						{
							session_unset();
							session_destroy();
							echo "<meta http-equiv='refresh' content='1;URL=index.php'>";
						}
					}
					else
						echo $fail;
				}
				else 
					echo $fail; 
			}
			else
				echo $fail;
		}
		else
			echo "Server Error!".mysqli_error($dbConn);
	}
	
	function CLAIM_COUPON($data)
	{
		global $dbConn;
		
		$queryDate = "SELECT CouponExpiry FROM coupon_data WHERE CouponCode='".$data."';";
		$resultDate = mysqli_query($dbConn, $queryDate);
		
		if($resultDate)
		{
			if(mysqli_num_rows($resultDate) > 0)
			{
				$row = mysqli_fetch_row($resultDate);
				
				$dateNow = date("j, n, Y");
				$dateNow = date_create_from_format("j, n, Y" , $dateNow);
				
				$dateExpr = date_create_from_format("j, n, Y", $row[0]);
				
				if($dateExpr > $dateNow)
				{
					$queryDEL = "DELETE FROM coupon_data WHERE CouponCode='".$data."';";
				
					$resultDEL = mysqli_query($dbConn, $queryDEL);
					
					if($resultDEL)
					{
						if(mysqli_affected_rows($dbConn) > 0)
						{
							echo "Successfully claimed coupon";
						}
						else
							echo "Error! No such coupon existed";
					}
					else
						echo "Server Error! Failed to retrieve coupon information";
				}
				else
					echo "Error! Coupon requested has expired";
			}
			else
				echo "Error! Coupon queried does not exist";
		}
		else
			echo "Server Error! Failed to retrieve coupon information";
	}
?>