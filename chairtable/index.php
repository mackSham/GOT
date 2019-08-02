<?php
	if(isset($_POST["submit"])){
		include_once("../include/connect.php");
		$uname = $_POST["auname"];
		$pwd = md5($_POST["pwd"]);
		//echo $uname.'<br>';
		//echo $pwd;
		$sql = "SELECT password FROM admin_credentials WHERE username='$uname' LIMIT 1";
		$query = mysqli_query($db_conn,$sql);
		//
		$row = mysqli_fetch_assoc($query);
		//die(mysqli_error($db_conn));
		//echo $count;
		if($row["password"]==$pwd){
			session_start();
			$_SESSION["auname"] = $uname;
			$_SESSION["pass"] = $pwd;
			header("location:questionsans.php");
		}else{
			echo '<script>alert("Invalid Credentials");</script>';
		}
	}

?>
<!doctype html>
<html>
<head>
	<title>Admin | GOT</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="row>">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<form action="" method="post">
				  <div class="form-group">
					<label for="auname">Username:</label>
					<input type="text" class="form-control" id="auname" name="auname">
				  </div>
				  <div class="form-group">
					<label for="pwd">Password:</label>
					<input type="password" class="form-control" id="pwd" name="pwd">
				  </div>
				  <input type="submit" class="btn btn-default" value="Submit" name="submit">
				</form>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
</body>
</html>