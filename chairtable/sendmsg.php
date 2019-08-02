<?php
	session_start();
	if(!isset($_SESSION["auname"])){
		header("location:../index.php");
	}else{
		include_once("../include/connect.php");
		$uname = $_SESSION["auname"];
		$pwd = $_SESSION["pass"];
		$sql = "SELECT password FROM admin_credentials WHERE username='$uname' LIMIT 1";
		$query = mysqli_query($db_conn,$sql);
		$row = mysqli_fetch_assoc($query);
		if($row["password"]!=$pwd){
			header("location:../index.php");
		}	
	}

?>
<?php
	if(isset($_POST["submit"])){
		include_once("../include/connect.php");
		$quesno = $_POST['quesno'];
		$msg = $_POST['msg'];
		date_default_timezone_set("Asia/Kolkata");
		$curr_date = date("Y-m-d H:i:s");
		//echo $quesno.' '.$msg;
		$sql = "UPDATE players_progress SET msg = '$msg' WHERE question_no='$quesno' AND start_time <= DATE_SUB('$curr_date', INTERVAL 4 HOUR)";
		mysqli_query($db_conn,$sql);
		//die(mysqli_error($db_conn));
	}

?>
<!doctype html>
<html>
	<head>
		<title>Send Message</title>
	</head>
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
	<body>
	<div class="container">
		<div class="row">
			<div class="col-md-2">
				<nav class="navbar bg-light"><!-- Links -->
				  <ul class="navbar-nav">
					<li class="nav-item">
					  <a class="nav-link active" href="questionsans.php">Upload Questions</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="users.php">Users</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="sendmsg.php">Send Message</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" href="logout.php">Log Out</a>
					</li>
				  </ul>

				</nav>
			</div>
			<div class="col-md-10">
				<form action="" method="post">
				  <div class="form-group">
					<label for="quesno">Question No:</label>
					<input type="number" class="form-control" id="quesno" name="quesno">
				  </div>
				  <div class="form-group">
					<label for="pwd">Message:</label>
					  <textarea class="form-control" id="msg" name="msg"></textarea>
				  </div>
				  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
				</form>		
			</div>
		</div>
	</div>
	</body>
</html>