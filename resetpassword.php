<?php 
	session_start();

	if(!isset($_SESSION["id"]))
	{
		echo "<script type='text/javascript'>alert('No reset code was provided!');</script>";
		echo "<meta http-equiv='refresh' content='0.01;URL=resetcode.php'>";
	}
	else
	{
		//The rest of the code will happen below
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InRestaurant Administrator Reset Password Page</title>
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
      <link href="assets/css/main-style.css" rel="stylesheet" />

</head>

<body class="body-Login-back">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center logo-margin ">
              <img src="assets/img/logo - Copy.png" alt="" />
                </div>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Fill All Required Information</h3>
                    </div>

		    <?php
			if(empty($_POST["newPassword"]) && empty($_POST["confPassword"])){
		    ?>
		    <script type="text/javascript">
			function checkField()
                        {
							if((document.getElementById("newPassword").value == "") || (document.getElementById("confPassword").value == ""))
                            {
                                alert("Please fill in both fields");
                                return false;
                            }
							else if(document.getElementById("newPassword").value != document.getElementById("confPassword").value)
							{
								alert("Both fields are not the same");
								return false;
							}
                            else
                                return true;
                        }
		    </script>

                    <div class="panel-body">
                        <form role="form" id="restPass_form" action="" method="post" onsubmit="return checkField();">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="New Password" id="newPassword" name="newPassword" type="password" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Confirm New Password" id="confPassword" name="confPassword" type="password" value="">
                                </div>
								<div class="form-group">
									<button class="btn btn-lg btn-success btn-block" type="submit">Reset Password</button>
								</div>
								<a href="resetcode.php">I have reset code</a>
                            </fieldset>
                        </form>
                    </div>
		    <?php
			}else {
				$data = array("", $_POST["newPassword"], $_SESSION["id"], $_POST["confPassword"]);
				
				include "/DB_Conn/db_conn.php";
				RESET_PASSWORD($data, true);
			}
		    ?>
                </div>
            </div>
        </div>
    </div>

     <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
</body>
</html>
<?php
	}
?>
