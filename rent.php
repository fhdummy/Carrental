<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Form</title>

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
	
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
		var numberplate2 = "";
		var startDate2 = "";
		var endDate2 = "";
		var locationString2 = "";
		var location2 = "";
		
		var dataToSend = [];
		var queryString = new Array();
		
		$( document ).ready(function() {
			console.log( "Ready!" );

			if (queryString.length == 0) {
				if (window.location.search.split('?').length > 1) {
					var params = window.location.search.split('?')[1].split('&');
					for (var i = 0; i < params.length; i++) {
						var key = params[i].split('=')[0];
						var value = decodeURIComponent(params[i].split('=')[1]);
						queryString[key] = value;
					}
				}
			}
			if (queryString["numberplate"] != null && queryString["startDate"] != null && queryString["endDate"] != null && queryString["locationString"] != null && queryString["location"] != null) 
			{
				numberplate2 = queryString["numberplate"];
				startDate2 = queryString["startDate"];
				endDate2 = queryString["endDate"];
				locationString2 = queryString["locationString"];
				location2 = queryString["location"];
				
				dataToSend = 
				{
					startDate: startDate2,
					endDate: endDate2,
					location: location2,
					numberplate: numberplate2
				}
				
				$("#jqNumberplate").html(numberplate2);
				$("#jqStartDate").html(startDate2);
				$("#jqEndDate").html(endDate2);
				$("#jqLocationString").html(locationString2);
			}
			else
			{
				$("#mainbox").html("Oops an Error occured, return to previous page.");
			}
			
			/* Check if the car is still available */
			
			console.log(dataToSend);

			$.ajax( 
			{                                      
				url: 'check_exact_car.php', data: dataToSend, success: function(data)
				{
					if(data === 'You forgot to choose either start date, end date or location')
					{
						$("#mainbox").html(data);
						//$("#submitButton2").hide();
						console.log("No start date.");
					}
					else if(data === 'There are no cars available')
					{
						$("#mainbox").html(data);
						//$("#submitButton2").hide();
						console.log("No cars.");
					}
					else
					{
						//$("#mainbox").html(data);
						//$("#submitButton2").show();
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
	</script>

</head>

<body>
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
                <a class="navbar-brand" href="index.html">Business Casual</a>
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
			<div class="box">
				<div id="mainbox" class="col-lg-6 col-lg-offset-3">
					<h4>Fill out the form</h4><br>
					<h5>Bereits ausgewählt:</h5><br>
					<b>Numberplate: </b><span id="jqNumberplate"></span><br>
					<b>Startdate: </b><span id="jqStartDate"></span><br>
					<b>Enddate: </b><span id="jqEndDate"></span><br>
					<b>Start destination: </b><span id="jqLocationString"></span><br><br>
					
					<form id="form1" class="form-horizontal">
						<div class="form-group">
							<label for="inputName1" class="col-lg-2 control-label">Name</label>
							<div class="col-lg-10">
								<input type="name" class="form-control" id="inputName1" placeholder="Name">
							</div>
						</div>
						<!--div class="form-group">
							<label for="inputEmail1" class="col-lg-2 control-label">Email</label>
							<div class="col-lg-10">
								<input type="email" class="form-control" id="inputEmail1" placeholder="Email">
							</div>
						</div-->
						<div class="form-group">
							<label for="inputMileage1" class="col-lg-2 control-label">Start Mileage</label>
							<div class="col-lg-10">
								<input type="name" class="form-control" id="inputMileage1" placeholder="Start Mileage">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-10">
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</div>
					</form>
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
		$("#form1").submit(function(e)
		{
			e.preventDefault();
			
			if(!$("#inputName1").val() || !$("#inputMileage1").val())
			{
				alert("You have to fill out every field.");
				return false;
			}
			
			if(!$.isNumeric($("#inputMileage1").val()) || $("#inputMileage1").val() < 0)
			{
				alert("Mileage must contain only numbers and must be positive.");
				return;
			}
			
			dataToSend = 
			{
				name: $("#inputName1").val(),
				email: $("#inputEmail1").val(),
				mileage: $("#inputMileage1").val(),
				numberplate: numberplate2,
				startDate: startDate2,
				endDate: endDate2,
				locationString: locationString2
			}
			
			console.log(dataToSend);
			
			$.ajax( 
			{                                      
				url: 'insertRental.php', data: dataToSend, success: function(data)
				{
					if(data.indexOf("Error") >= 0)
					{
						//console.log("An Error occured");
						alert(data);
						return false;
					} else
					{
						$("#mainbox").html("<h2>The rental was successful.</h2><br>");
						$("#mainbox").append("Back to <a href='cars.php'>car selection</a>");
					}
				},
				error: function(data, status)
				{
				console.log(data);
				console.log(status);
				}	
			});
		});
	</script>
	
</body>

</html>
