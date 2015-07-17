<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Return</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-datetimepicker.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/business-casual.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<!-- For calendar -->
	<script type="text/javascript" src="js/moment.js"></script>
	<script type="text/javascript" src="js/transition.js"></script>
	<script type="text/javascript" src="js/collapse.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>

</head>

<body>
	<?php
		$servername = "pwnhofer.at";
		$username = "binna";
		$password = "affe123456!";
		$dbname = "binna";

		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);

		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		//echo "Connected successfully";
		
		$conn->query ('SET NAMES UTF8;');
		$conn->query ('SET COLLATION_CONNECTION=utf8_general_ci;');
		/* change character set to utf8 */
		if (!$conn->set_charset("utf8")) {
			//printf("Error loading character set utf8: %s\n", $conn->error);
		} else {
			//printf("Current character set: %s\n", $conn->character_set_name());
		}
	?>
	
    <!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="index.html">Car Rental 2015</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a href="cars.php">Rent</a>
                    </li>
					<li>
                        <a href="return.php">Return</a>
                    </li>
                    <li>
                        <a href="about.html">About</a>
                    </li>					
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">
	
		<div class="row">
			<div class="box" id="mainbox">
				<div class="col-lg-6 col-lg-offset-3">
					<h4>Enter your name</h4><br>
					<form id="form1" class="form-horizontal">
						<div class="form-group">
							<label for="inputName1" class="col-lg-2 control-label">Name</label>
							<div class="col-lg-10">
								<input type="name" class="form-control" id="inputName1" placeholder="Name">
							</div>
						</div>
						<br>
						<div class="form-group">
							<button id="submitButton" type="submit" class="btn btn-default">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="box" id="secondbox">
				<div class="col-lg-8 col-lg-offset-2">
					<div class='col-lg-12'>
						<form id="form2" class="form-horizontal">
							<div class="form-group">
								<div id="carsDiv">
								</div>
								<div class="form-group">
									<button id="submitButton2" type="submit" class="btn btn-default" style="display: none;">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
    <!-- /.container -->
	</div>
	
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Car Rental 2015</p>
                </div>
            </div>
        </div>
    </footer>
	
	<script type="text/javascript">
		/* Global variables */
		var dataToSend = [];
		
		$("#form1").submit(function(e) 
		{
			e.preventDefault();
			
			var compareString = "There are no cars available.";
			
			dataToSend = 
			{
				id: "getName",
				name: $("#inputName1").val()
			}

			$.ajax( 
			{                                      
				url: 'api.php', data: dataToSend, success: function(data)
				{
					if(data === 'There are no rentals available.')
					{
						$("#carsDiv").html(data);
						$("#submitButton2").hide();
						console.log("No start date.");
					}
					else
					{
						$("#carsDiv").html(data);
						$("#submitButton2").show();
						console.log("Normal execution.");
					}
					
				},
				error: function(data, status)
				{
				console.log(data);
				console.log(status);
				}	
			});
		});
		
		$("#form2").submit(function(e)
		{
			e.preventDefault();
			console.log("Form2 submitted");
			
			var selectedVal = "";
			var selected = $("#radioDiv input[type='radio']:checked");
			if (selected.length > 0) 
			{
				selectedVal = selected.val();
			}
			
			console.log(selectedVal);	//selectedVal is the NUMBERPLATE of the selected cars
			
			var url = "return_form.php?rentalid=" + selectedVal;
			window.location.href = url;
			
		});

	</script>
	
</body>

</html>
