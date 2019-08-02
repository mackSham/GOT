<?php
	include_once('include/connect.php');
	if(isset($_POST['submit'])){
		$uoe = $_POST["uoe"];
		//echo $_POST['pass'].'<br>';
		$pass = md5($_POST['pass']);
		
		if($uoe == "" || $pass == ""){
			echo "Fill all Data";
			exit();
		}else{
			$sql = "SELECT pid,pass,uname FROM players WHERE uname = '$uoe' OR email='$uoe' LIMIT 1";
			$query = mysqli_query($db_conn,$sql);
			$row = mysqli_fetch_assoc($query);
			$db_pid = $row['pid'];
			$db_pass = $row['pass'];
			$db_uname = $row['uname'];
			//echo $db_pass.'<br> '.$pass;
			if($db_pass != $pass){
				echo 'Login Failed';
			}else{
				session_start();
				$_SESSION['pid'] = $db_pid;
				$_SESSION['uname'] = $db_uname;
				setcookie("pid", $db_pid, strtotime( '+30 days' ), "/", "", "", TRUE);
				setcookie("user", $db_uname, strtotime( '+30 days' ), "/", "", "", TRUE);
				header('location:home.php');
			}
		}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GOT | Login</title>
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
	<form action="" method="post">
	  <div class="form-group">
		<label for="email">Email address or Username:</label>
		<input type="text" class="form-control" id="uoe" name="uoe">
	  </div>
	  <div class="form-group">
		<label for="pass">Password:</label>
		<input type="password" class="form-control" id="pass" name="pass">
	  </div>
	  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
	</form>

</body>
</html>