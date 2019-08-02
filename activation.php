<?php
	if(isset($_POST['submit'])){
		include_once("include/connect.php");
		$pin = $_POST['pin'];
		$uname = $_GET['uname'];
		$sql = "SELECT pid,verification_code FROM players WHERE uname = '$uname' LIMIT 1";
		$query = mysqli_query($db_conn,$sql);
		//die(mysqli_error($db_conn));
		$row = mysqli_fetch_assoc($query);
		$verification_code = $row['verification_code'];
		if($verification_code == $pin){
			$sql = "UPDATE players SET activated = '1' WHERE uname = '$uname'";
			mysqli_query($db_conn,$sql);
			//echo '<script>alert("Successful!!! Welcome to the game");</script>';
			header("location:index.php?errmsg=Successful!!! Welcome to the game.You can Login now");
		}else{
			echo '<script>alert("Wrong Pin Code Given");</script>';
		}
	}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<!-- Font Awesome CDN -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
	  <div class="container">
		  <a class="navbar-brand" href="index.php"><h3 style="line-height: 20px;">&nbsp; Game of Troves<br><mayank style="font-size: 55%">An Event of Neo Drishti-Ojass'18</mayank></h3></a>

		  <!-- Toggler/collapsibe Button -->
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <!-- Navbar links -->
		  <div class="collapse navbar-collapse mr-auto" id="collapsibleNavbar">
			<ul class="navbar-nav ml-auto">
			  <li class="nav-item">
				<a class="nav-link active" href="home.php">Home</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="rules.php">Rules</a>
			  </li>
			  
			</ul>
		  </div> 
	  </div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
			<br><br><br>
				<?php
					if(isset($_GET['uname'])){
						$uname=$_GET['uname'];
						include_once("include/connect.php");
						$sql = "SELECT pid,activated FROM players WHERE uname = '$uname' LIMIT 1";
						$query = mysqli_query($db_conn,$sql);
						$count = mysqli_num_rows($query);
						if($count == 0){
							header("location:index.php");
						}
						$row = mysqli_fetch_assoc($query);
						$activated = $row['activated'];
						if($activated == 1){
							header("location:index.php?errmsg=Successful!!! Welcome to the game.You can Login now");
						}else{
							echo '<form action="" method="post">';
							echo '<div class="form-group">
									<label for="pincode">Enter Your Unique PIN Code:</label>
									<input type="text" class="form-control" id="pincode" name="pin">
								  </div>';
							echo '<input type="submit" name="submit" class="btn btn-primary">';
							echo '</form>';
						}
					}

				?>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>
</body>
</html>