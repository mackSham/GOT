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
		$msg = $_POST["msg"];
		$ppid = $_POST["pid"];
		$sql = "UPDATE players_progress SET msg = '$msg' WHERE ppid = '$ppid' LIMIT 1";
		mysqli_query($db_conn,$sql);
	}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ADMIN | User Details</title>
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
			<?php
				include_once("../include/connect.php");
				echo '<table>
						<tr>
							<th>Id.</th>
							<th>User Name</th>
							<th>Full Name</th>
							<th>College</th>
							<th>Registration No.</th>
							<th>Question No.</th>
							<th>Points</th>
							<th>Message</th>
							<th>Message to Sent</th></tr>';
				$sql = "SELECT * FROM players INNER JOIN players_progress ON players.pid = players_progress.ppid ORDER BY players_progress.question_no DESC, players_progress.points DESC, players_progress.start_time ASC";
				$query = mysqli_query($db_conn,$sql);
				while($row = mysqli_fetch_assoc($query)){
					$uname = $row['uname'];
					$pass = $row['pass'];
					$pid = $row['pid'];
					$fullname = $row['fname'].' '.$row['lname'];
					$college = $row['clgname'];
					$collegern  = $row['clgrn'];
					$quesno = $row['question_no'];
					$points = $row['points'];
					$msg = $row['msg'];
					$filename = $uname.''.$pass;
					echo '<tr>
							<td>'.$pid.'</td>
							<td><a href="useranswer.php?user='.$filename.'">'.$uname.'</a></td>
							<td>'.$fullname.'</td>
							<td>'.$college.'</td>
							<td>'.$collegern.'</td>
							<td>'.$quesno.'</td>
							<td>'.$points.'</td>
							<td>'.$msg.'</td>
							<td><form action="" method="post" class="form-inline">
								<textarea name="msg" class="form-control"></textarea>
								<input type="hidden" value="'.$pid.'" name="pid">
								<input type="submit" value="Submit" name="submit" class="btn btn-primary">
							</form></td></tr>';
				}
			?>	
			</table>
		</div>
	</div>
</div>
</body>
</html>