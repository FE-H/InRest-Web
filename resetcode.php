<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InRestaurant Administrator Reset Code Page</title>
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
			if(empty($_POST["resetcode"])){
		    ?>
		    <script type="text/javascript">
			function checkField()
                        {
			    if((document.getElementById("resetcode").value == ""))
                            {
                                alert("Please fill in the reset code field");
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
                                    <input class="form-control" placeholder="Reset Code" id="resetcode" name="resetcode" type="text" autofocus>
                                </div>
								<div class="form-group">
									<button class="btn btn-lg btn-success btn-block" type="submit">Verify Code</button>
								</div>
                            </fieldset>
                        </form>
                    </div>
		    <?php
			}else {
				include "/DB_Conn/db_conn.php";
				VERIFY_RESET_CODE($_POST["resetcode"], true);
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
