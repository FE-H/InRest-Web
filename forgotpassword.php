<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InRestaurant Administrator Forgot Password Page</title>
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
			if(empty($_POST["staffName"]) && empty($_POST["staffEmail"])){
		    ?>
		    <script type="text/javascript">
			function checkField()
                        {
			    if((document.getElementById("staffName").value == "") || (document.getElementById("staffEmail").value == ""))
                            {
                                alert("Please fill in both Username and Email fields");
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
                                    <input class="form-control" placeholder="Username" id="staffName" name="staffName" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Email" id="staffEmail" name="staffEmail" type="text" value="">
                                </div>
								<div class="form-group">
									<button class="btn btn-lg btn-success btn-block" type="submit">Send Email</button>
								</div>
								<a href="resetcode.php">I have reset code</a>
                            </fieldset>
                        </form>
                    </div>
		    <?php
			}else {
				$mailInf = array($_POST["staffName"], $_POST["staffEmail"]);
				
				include "/DB_Conn/db_conn.php";
				SEND_RESET_EMAIL(true, $mailInf);
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
