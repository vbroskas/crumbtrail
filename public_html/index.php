<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-COMPATIBLE" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-------------Bootstrap links all here---------->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
				integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
				crossorigin="anonymous"/>

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
				integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
				crossorigin="anonymous"/>

		<!---------------jQuery------------------------>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				  integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				  crossorigin="anonymous"></script>

		<!---------------Font Awesome Links------------------->
		<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">


		<!---------------Custom CSS here----------------------->
		<link href="css/style.css" rel="stylesheet" type="text/css"/>

		<title>
			CrumbTrail   <!----add cool icon for tabs here ------->
		</title>
	</head>

	<!-----------------------Beginning of user content--------------------------------->
	<body>
		<header>
			<div class="navbar navbar-default navbar-fixed-top nav-pad">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand hidden-xs" href="#">CrumbTrail</a>
						<a class="navbar-brand visible-xs" href="#">CT</a>
						<form class="navbar-form pull-left" role="search">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="What do you seek?">
								<div class="input-group-btn">
									<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
								</div>
							</div>
						</form>
					</div>
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="active"><a href="#">Home</a></li>
							<li><a href="#about">See All Trucks</a></li>
							<li><a href="#contact">Settings</a></li>
							<li><a href="#contact">Logout</a></li>
						</ul>
					</div>
					<!--/.navbar-collapse -->
				</div>
			</div>
		</header>

		<!-- Main body-->
		<div class="container-fluid">
<!--			title row-->
			<div class="row">
				<h1 class="company-name">Company Name here</h1>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<div class="serving-icon"></div>
					<h5>SERVING NOW</h5>

				</div>
				<div col-xs-6></div>
			</div>

		</div>

	</body>