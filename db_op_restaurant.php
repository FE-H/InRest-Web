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
                                <div class="user-text-online"></div>
                            </div>
                        </div>
                        <!--end user image section-->
                    </li>
                    <li class="">
                        <a href="tables.php"><i class="fa fa-table fa-fw"></i>Tables</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-files-o fa-fw"></i>Database Operations<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="db_op_admin.php">System Administrator</a>
                            </li>
                            <li class="selected">
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
                    <h1 class="page-header">Restaurant Database Operations</h1>
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
									<form role="form" id="inputForm" name="inputForm" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Type of Operation</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionCheck" class="optionCheck" id="optionsRadios1" value="update" onclick="disableElement('selectName', false)" checked>Update Existing Restaurant
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionCheck" class="optionCheck" id="optionsRadios2" value="register" onclick="disableElement('selectName', true);">Register New Restaurant
                                                </label>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <label>Restaurant ID</label>
                                            <input id="id" name="id" class="form-control" placeholder="Enter text" disabled>
                                        </div>
										<!--ori
										<div class="form-group">
											<div class="tooltips">
												<label>Restaurant ID&nbsp;&nbsp;&nbsp;</label>
												<span>Choose the restaurant you want to modify</span>
											</div>
                                            <select id="selectID" class="form-control">
												<_?php
												//	echo "<option></option>";
												//	ob_start();
												//	include "/DB_CONN/bridge.php";
													
												//	$result = ob_get_clean();
												//	$result = explode(", ", $result);
												//	foreach($result as $key)
												//		echo "<option>".$key."</option>";
												?>
                                            </select>
                                        </div>-->
                                        <div class="form-group">
											<div class="tooltips">
												<label>Restaurant Name&nbsp;&nbsp;&nbsp;</label>
												<span id="tooltip">Choose the restaurant you want to modify</span>
											</div>
                                            <select id="selectName" class="form-control">
												<?php
													echo "<option></option>";
													ob_start();
													include "/DB_CONN/bridge.php";
													
													$result = ob_get_clean();
													$result = explode(", ", $result);
													foreach($result as $key)
														echo "<option>".$key."</option>";
												?>
                                            </select>
											<input id="name" name="name" class="form-control" placeholder="Enter text" style="display:none">
                                        </div>
										<!--ori
                                        <div class="form-group">
                                            <label>Restaurant Name</label>
                                            <input id="name" name="name" class="form-control" placeholder="Enter text">
                                        </div>-->
                                        <div class="form-group">
                                            <label>Restaurant Type</label>
                                            <input id="type" name="type" class="form-control" placeholder="Enter text">
                                        </div>
                                        <div class="form-group">
                                            <label>Restaurant Lot Number</label>
                                            <input id="lot" name="lot" class="form-control" placeholder="Enter text">
                                        </div>
                                        <div class="form-group">
                                            <label>Restaurant Owner</label>
                                            <input id="owner" name="owner" class="form-control" placeholder="Enter text">
                                        </div>
                                        <div class="form-group">
                                            <label>Restaurant Contact Number</label>
                                            <input id="contact" name="contact" class="form-control" placeholder="Enter text">
                                        </div>
                                        <div class="form-group">
                                            <label>Restaurant Email Address</label>
                                            <input id="email" name="email" class="form-control" placeholder="Enter text">
                                        </div>
										<div class="form-group">
											<label>Logo</label>
											<input type="file" id="file" accept="image/*" name="file" class="form-control" onchange="loadFile(this)">
											<img id="output" src="#" alt="logo"/>
											<input type="text" id="fileInfo" name="fileInfo" class="form-control">
										</div>
										<br>
                                        <button id="submit" type="button" class="btn btn-primary">Submit Button</button>
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
		var filename = "";
		
		var fileBase64 = "";
		
		$(document).ready(function()
		{
			var date = new Date();

			var tableName = "restaurant_data";


			$("#fileInfo").hide();
			$("#selectName").change(function()
			{
				$.ajax(
				{
					url: 'ajax.php',
					type: 'POST',
					data: JSON.stringify({"tableName":tableName,"data":$("#selectName option:selected").text()}),
					async: false,
					success: function(msg)
					{
						console.log(msg);
						msg = JSON.parse(msg);
						$("#id").val(msg["restaurantID"]);
						$("#name").val(msg["restaurantName"]);
						$("#type").val(msg["restaurantType"]);
						$("#lot").val(msg["restaurantLot"]);
						$("#owner").val(msg["restaurantOwner"]);
						$("#contact").val(msg["restaurantContact"]);
						$("#email").val(msg["restaurantEmail"]);
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(thrownError);
					}
				});
			});
		});
			
		$("#submit").click(function ()
		{
			if(preventEmptyRegister())
			{
				if($(".optionCheck:checked").val() == "register")
					var json = {"restaurantName":$("#name").val(),"restaurantType":$("#type").val(),"restaurantLot":$("#lot").val(),"restaurantOwner":$("#owner").val(),"restaurantContact":$("#contact").val(),"restaurantEmail":$("#email").val(), "imageData":fileBase64, "imageMetadata":filename};				
				else
					var json = {"restaurantID":$("#id").val(),"restaurantName":$("#name").val(),"restaurantType":$("#type").val(),"restaurantLot":$("#lot").val(),"restaurantOwner":$("#owner").val(),"restaurantContact":$("#contact").val(),"restaurantEmail":$("#email").val(), "imageData":fileBase64, "imageMetadata":filename};
				
				var json2 = JSON.stringify({"tableName":"restaurant_data","data":json});
				
				$.ajax(
				{
					url: 'ajax.php',
					type: 'POST',
					data: json2,
					async: false,
					success: function(msg)
					{
						console.log(msg);
						alert(msg);
					},
					error: function(xhr, ajaxOptions, thrownError)
					{
						alert(thrownError);
					}
				});
			}
		});


		function preventEmptyRegister()
		{
			if(document.getElementById("optionsRadios2").checked && (fileBase64 == "" || document.getElementById("name").value == "" || document.getElementById("type").value == "" || document.getElementById("lot").value == "" || document.getElementById("owner").value == "" || document.getElementById("contact").value == "" || document.getElementById("email").value == ""))
			{
				alert("Please fill in all empty fields");
				return false;
			}
			else if(document.getElementById("optionsRadios1").checked && (document.getElementById("name").value == "" || document.getElementById("type").value == "" || document.getElementById("lot").value == "" || document.getElementById("owner").value == "" || document.getElementById("contact").value == "" || document.getElementById("email").value == ""))
			{
				alert("Please fill in all empty fields");
				return false;
			}
			else
				return true;
		}

		function disableElement(docID, disable)
		{
			var docDisable = document.getElementById(docID);
			
			document.getElementById("id").value = "";
			document.getElementById("name").value = "";
			document.getElementById("type").value = "";
			document.getElementById("lot").value = "";
			document.getElementById("owner").value = "";
			document.getElementById("contact").value = "";
			document.getElementById("email").value = "";
			
			if(disable)
			{
				docDisable.selectedIndex=0;
				docDisable.disabled=true;
				docDisable.style.display="none";
				
				document.getElementById("name").style.display="initial";
				document.getElementById("tooltip").innerHTML = "Name of the restaurant you wish to register";
			}
			else
			{
				docDisable.disabled=false;
				
				docDisable.style.display="initial";
				
				document.getElementById("name").style.display="none";
				document.getElementById("tooltip").innerHTML = "Choose the restaurant you want to modify";
			}
		}
		
		function loadFile(input) 
		{	
			var MAX_SIZE = 200;
			var fileTypes = ["jpeg", "jpg", "png"];
			var newWidth = 0;
			
			if(input.files)
			{
				var extension = input.files[0].name.split('.').pop().toLowerCase();
				var isSuccess = fileTypes.indexOf(extension) > -1;
		
				if(isSuccess)
				{
					filename = input.files[0].name;
					
					var reader = new FileReader();
					reader.onload = function()
					{
						var image = new Image();
						image.src = reader.result;
						image.onload = function (imageEvent)
						{
							var canvas = document.createElement("canvas");
						
							var width = image.width;
							var height = image.height;
							
							var ori_AR_W = width/height;
							var ori_AR_H = height/width;
							console.log("width, height PRE:"+width+", "+height);
							
							width = (width > MAX_SIZE && width >= height)? MAX_SIZE : (width > MAX_SIZE && width < height)? ori_AR_W * MAX_SIZE : width;
							height = (height > MAX_SIZE && height >= image.width)? MAX_SIZE : (height > MAX_SIZE && height < image.width)? ori_AR_H * MAX_SIZE : (height/width != ori_AR_H)? ori_AR_H * MAX_SIZE : height;
							console.log("width, height POST:"+width+", "+height);
							
							canvas.width = width;
							canvas.height = height;
							
							canvas.getContext("2d").drawImage(image, 0, 0, width, height);
							
							fileBase64 = canvas.toDataURL("image/"+extension);
							console.log("dataURL: "+fileBase64);
							fileBase64 = fileBase64.replace(/^data:image\/(png|jpg);base64,/, "");
							console.log("dataURL: "+fileBase64);
							
							$("#output").attr("src", canvas.toDataURL("image/"+extension));
							console.log("width, height POST:"+width+", "+height);
							console.log("output size:"+$("#output").width()+", "+$("#output").height());
						}
					};
					
					$("#fileInfo").val(input.files[0].name+" "+Math.round(1000*input.files[0].size/1024)/1000+"KB");
					$("#fileInfo").show();
						
					reader.readAsDataURL(event.target.files[0]);
				}
				else
				{
					alert("Invalid File Type! Only image files of JPEG or PNG extensions");
					try
					{
						document.getElementById("file").value = null;
					}
					catch(ex)
					{
						if(document.getElementById("file").value)
							document.getElementById("file").parentNode.replaceChile(document.getElementById("file").cloneNode(true), document.getElementById("file"));
					}
				}
			}
		};
    </script>

</body>
</html>
<?php
}
?>