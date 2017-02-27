<?php 
	session_start();

	if(!isset($_SESSION["uName"]))
	{
		echo "<script type='text/javascript'>alert('Unauthorised Access!');</script>";
		echo "<meta http-equiv='refresh' content='0.01;URL=index.php'>";
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
    <title>Database Operations</title>
    <!-- Core CSS - Include with every page -->
    <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
   <link href="assets/css/style.css" rel="stylesheet" />
      <link href="assets/css/main-style.css" rel="stylesheet" />



</head>


<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
            <!-- navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">
                    <img src="assets/img/logo - Copy.png" alt="" />
                </a>
            </div>
            <!-- end navbar-header -->
            <!-- navbar-top-links -->
            <ul class="nav navbar-top-links navbar-right">
                <!-- main dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-3x"></i>
                    </a>
                    <!-- dropdown user-->
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
                        </li>
                    </ul>
                    <!-- end dropdown-user -->
                </li>
                <!-- end main dropdown -->
            </ul>
            <!-- end navbar-top-links -->

        </nav>
        <!-- end navbar top -->

        <!-- navbar side -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <!-- sidebar-collapse -->
            <div class="sidebar-collapse">
                <!-- side-menu -->
                <ul class="nav" id="side-menu">
                    <li>
                        <!-- user image section-->
                        <div class="user-section">
                            <div class="user-info">
                                <div><strong><?php echo $_SESSION["uName"]?></strong></div>
                                <div class="user-text-online">
                            </div>
                        </div>
                        <!--end user image section-->
                    </li>
                    <li >
                        <a href="tables.php"><i class="fa fa-table fa-fw"></i>Tables</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-files-o fa-fw"></i>Database Operations<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li class="selected">
                                <a href="db_op_admin.php">System Administrator</a>
                            </li>
                            <li>
                                <a href="db_op_restaurant.php">Restaurant Information</a>
                            </li>
                        </ul>
                        <!-- second-level-items -->
                    </li>
                </ul>
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        <!-- end navbar side -->
	<!-- page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">System Administrator Database Operations</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Form
                        </div>
                        <div class="panel-body">
                            <div class="row">
				<!--Left-->
                                <div class="col-lg-6">
                                    <form role="form" id="inputForm" action="" name="inputForm" method="post">
                                        <div class="form-group">
                                            <label>Type of Operation</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionCheck" id="optionsRadios1" class = "optionCheck" value="update" onclick="disableElement(false)" checked>Update Your Information
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionCheck" id="optionsRadios2" class = "optionCheck" value="register" onclick="disableElement(true)">Register New System Administrator
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Staff ID</label>
                                            <input id="staffID" name="staffID" class="form-control" value=<?php echo $_SESSION["uID"];?> readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Staff Name</label>
                                            <input id="staffName" name="staffName" class="form-control" placeholder="Enter text" type="text" >
                                        </div>
                                        <div class="form-group">
                                            <label>Staff Contact Number</label>
                                            <input id="staffContactNo" name="staffContactNo" class="form-control" placeholder="Enter text" type="text" >
                                        </div>
                                        <div class="form-group">
                                            <label>Staff Email</label>
                                            <input id="staffEmail" name="staffEmail" class="form-control" placeholder="Enter text" type="text" >
                                        </div>
											<hr>
											<label>
												<input id="updatePass" type="checkbox" value="updatePass" onclick="disableUpdate()"/>
													Update Your Password
											</label>
                                        <div class="form-group">
                                            <label>Current Password</label>
                                            <input id="currPass" name="currPass" class="form-control" placeholder="Enter text" type="password">
                                        </div>
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input id="newPass" name="newPass" class="form-control" placeholder="Enter text" type="password">
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm New Password</label>
                                            <input id="confNewPass" name="confNewPass" class="form-control" placeholder="Enter text" type="password">
                                        </div>
					<br>
                                        <button type="submit" class="btn btn-primary">Submit Button</button>
                                    </form>
                                </div>
				<!--End of left-->
                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/plugins/pace/pace.js"></script>
    <script src="assets/scripts/siminta.js"></script>
    <script type="text/javascript">
	$(document).ready(function()
	{
	    document.getElementById("currPass").disabled=true;
	    document.getElementById("newPass").disabled=true;
	    document.getElementById("confNewPass").disabled=true;	
	    
	    var date = new Date();
	    var time = date.getDate() + "/"+ (date.getMonth()+1) + "/" + date.getFullYear() + " - " +date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
	    var temp0, temp1, temp2, temp3;

	    var tableName = "staff_data";
	    var isAdmin = true;

	    $.ajax(
	    {
		url: 'ajax.php',
		type: 'POST',
	        data: JSON.stringify({"tableName":tableName,"isAdmin":isAdmin,"data":$("#staffID").val()}),
	        async: false,
	        success: function(msg)
	    	{
				console.log(msg)
	            msg = JSON.parse(msg);
	            $("#staffID").val(msg["staffID"]);
	            $("#staffName").val(msg["staffName"]);
	            $("#staffContactNo").val(msg["staffContactNo"]);
	            $("#staffEmail").val(msg["staffEmail"]);
	        },
	        error: function(xhr, ajaxOptions, thrownError)
	        {
	            alert(thrownError);
	        }
	    });
	});

	$("#inputForm").submit(function (event)
	{
	    if(!preventEmptyRegister())
		return false;
	    else
	    {
		if($(".optionCheck:checked").val() == "register")
		{
		    var json = {"staffName":$("#staffName").val(),"staffContactNo":$("#staffContactNo").val(),"staffEmail":$("#staffEmail").val()};
		    var json2 = JSON.stringify({"tableName":"staff_data","isAdmin":true,"data":json});

	    	    $.ajax(
	    	    {
		    	url: 'ajax.php',
		    	type: 'POST',
	            	data: json2,
	            	async: false,
	            	success: function(msg)
	    	    	{
	            	    msg = JSON.parse(msg);
			    $("#txtAr").val($("#txtAr").val()+"\n"+msg);
	            	    $("#staffID").val(msg["staffID"]);
	            	    $("#staffName").val(msg["staffName"]);
	            	    $("#staffContactNo").val(msg["staffContactNo"]);
	            	    $("#staffEmail").val(msg["staffEmail"]);

			    alert("A new System Administrator has been added to the database");
	            	},
	            	error: function(xhr, ajaxOptions, thrownError)
	                {
	                    alert(thrownError);
	            	}
	            });
		}
		else
		{
		    if($("#updatePass").prop("checked"))
		    {
			var json = {"staffID":$("#staffID").val(),"staffName":$("#staffName").val(),"staffContactNo":$("#staffContactNo").val(),"staffEmail":$("#staffEmail").val(),"staffLogin":$("#newPass").val(),"staffLoginCurr":$("#currPass").val()};
			var json2 = JSON.stringify({"tableName":"staff_data","isAdmin":true,"data":json});
		    }
		    else
		    {
			var json = {"staffID":$("#staffID").val(),"staffName":$("#staffName").val(),"staffContactNo":$("#staffContactNo").val(),"staffEmail":$("#staffEmail").val(),"staffLogin":""};
			var json2 = JSON.stringify({"tableName":"staff_data","isAdmin":true,"data":json});
		    }

	    	    $.ajax(
	    	    {
		    	url: 'ajax.php',
		    	type: 'POST',
	            	data: json2,
	            	async: false,
	            	success: function(msg)
	    	    	{
			    alert(msg);
	            	},
	            	error: function(xhr, ajaxOptions, thrownError)
	                {
	                    alert(thrownError);
	            	}
	            });
		}

		return false;
	    }
	});

	function preventEmptyRegister()
	{
	    if(document.getElementById("optionsRadios2").checked && (document.getElementById("staffName").value == "" || document.getElementById("staffContactNo").value == "" || document.getElementById("staffEmail").value == ""))
	    {
		alert("Please fill in all empty fields");
		return false;
	    }
	    else
		return true;
	}
	function disableElement(disable)
	{
	    if(disable)
	    {
		temp0 = document.getElementById("staffID").value;
		temp1 = document.getElementById("staffName").value;
		temp2 = document.getElementById("staffContactNo").value;
		temp3 = document.getElementById("staffEmail").value;

		document.getElementById("staffID").value = "";
		document.getElementById("staffName").value = "";
		document.getElementById("staffContactNo").value = "";
		document.getElementById("staffEmail").value = "";

		document.getElementById("updatePass").disabled=true;
		document.getElementById("currPass").disabled=true;
		document.getElementById("newPass").disabled=true;
		document.getElementById("confNewPass").disabled=true;
	    }
	    else
	    {
		document.getElementById("staffID").value = temp0;
		document.getElementById("staffName").value = temp1;
		document.getElementById("staffContactNo").value = temp2;
		document.getElementById("staffEmail").value = temp3;

		document.getElementById("updatePass").disabled=false;
	    }
	}

	function disableUpdate()
	{
	    if(document.getElementById("currPass").disabled == true)
	    {
			document.getElementById("currPass").disabled=false;
			document.getElementById("newPass").disabled=false;
			document.getElementById("confNewPass").disabled=false;
	    }
	    else
	    {
			document.getElementById("currPass").disabled=true;
			document.getElementById("newPass").disabled=true;
			document.getElementById("confNewPass").disabled=true;
			
			document.getElementById("currPass").value = "";
			document.getElementById("newPass").value = "";
			document.getElementById("confNewPass").value = "";
	    }
	}
    </script>
</body>
</html>
<?php
}
?>