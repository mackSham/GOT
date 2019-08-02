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
	if(isset($_POST['submit'])){
		include_once("../include/connect.php");
		$squestion = $_POST['question'];
		$sanswer = $_POST['answer'];
		$canswer = $_POST['canswer'];
		
		
		$shint1 = $_POST['hint1'];
		$shint2 = $_POST['hint2'];
		$shint3 = $_POST['hint3'];
		$shint4 = $_POST['hint4'];
		$sfact = $_POST['fact'];
		$sqi = $_POST['qid'];
		$salternate_ans = $_POST['alternate_ans'];
		$calternate_ans = $_POST['calternate_ans'];
		
		if($sanswer == "" || $shint1 == "" ||$shint2 == "" || $shint3 == "" || $sfact == "" || $squestion == "" || $shint4 == ""){
			echo '<script>alert("Please fill all data");</script>';
		 	//$errors[]="Please fill all data";
		}else{
			if($sanswer == $canswer && $salternate_ans == $calternate_ans){
				$sql="UPDATE questions SET question = '$squestion',hint1='$shint1',hint2='$shint2',hint3='$shint3',hint4 = '$shint4',fact='$sfact' WHERE qid='$sqi' LIMIT 1";
				mysqli_query($db_conn,$sql);
			}else if($sanswer == $canswer && $salternate_ans != $calternate_ans){
				if($salternate_ans!=""){
					$salternate_ans = md5(strtoupper($salternate_ans));			
				}
				$sql="UPDATE questions SET question = '$squestion',alternate_ans='$salternate_ans',hint1='$shint1',hint2='$shint2',hint3='$shint3',hint4 = '$shint4',fact='$sfact' WHERE qid='$sqi' LIMIT 1";
				mysqli_query($db_conn,$sql);	
			}else if($sanswer != $canswer && $salternate_ans == $calternate_ans){
				$sanswer = md5(strtoupper($sanswer));
				$sql="UPDATE questions SET question = '$squestion',answer = '$sanswer',hint1='$shint1',hint2='$shint2',hint3='$shint3',hint4 = '$shint4',fact='$sfact' WHERE qid='$sqi' LIMIT 1";
				mysqli_query($db_conn,$sql);
			}else{
				$sanswer = md5(strtoupper($sanswer));
				if($salternate_ans!=""){
					$salternate_ans = md5(strtoupper($salternate_ans));			
				}
				$sql="UPDATE questions SET question = '$squestion',answer = '$sanswer',alternate_ans='$salternate_ans',hint1='$shint1',hint2='$shint2',hint3='$shint3',hint4 = '$shint4',fact='$sfact' WHERE qid='$sqi' LIMIT 1";
				mysqli_query($db_conn,$sql);	
			}
			echo '<script>alert("Success");</script>';
		}
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
					  <a class="nav-link" href="editquestion.php">Edit Question</a>
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
							<th>Question No.</th>
							<th>Question</th>
							<th>Answer</th>
							<th>Alternative Answer</th>
							<th>Hint 1</th>
							<th>Hint 2</th>
							<th>Hint 3</th>
							<th>Hint 4</th>
							<th>Fact</th>
							<th>No of players solved</th></tr>';
				$sql = "SELECT * FROM questions";
				$query = mysqli_query($db_conn,$sql);
				while($row = mysqli_fetch_assoc($query)){
					$qid = $row['qid'];
					$question = $row['question'];
					$answer = $row['answer'];
					$alternate_ans = $row['alternate_ans'];
					$hint1  = $row['hint1'];
					$hint2 = $row['hint2'];
					$hint3 = $row['hint3'];
					$hint4 = $row['hint4'];
					$fact = $row['fact'];
					$noofplayersolved = $row['noofplayersolved'];
					echo '<tr><form action="" method="post">
							<td>'.$qid.'</td>
							<td><div class="form-group">
								<input type="text" class="form-control" name="question" value="'.$question.'">
							  </div>
							</td>
							<td><div class="form-group">
								<input type="text" class="form-control" name="answer" value="'.$answer.'">
								<input type="text" class="form-control" name="canswer" value="'.$answer.'" hidden>
							  </div>
							</td>
							<td><div class="form-group">
								<input type="text" class="form-control" name="alternate_ans" value="'.$alternate_ans.'">
								<input type="text" class="form-control" name="calternate_ans" value="'.$alternate_ans.'" hidden>
							  </div>
							</td>
							<td><div class="form-group">
								<input type="text" class="form-control" name="hint1" value="'.$hint1.'">
							  </div>
							</td>
							<td><div class="form-group">
								<input type="text" class="form-control" name="hint2" value="'.$hint2.'">
							  </div>
							</td>
							<td><div class="form-group">
								<input type="text" class="form-control" name="hint3" value="'.$hint3.'">
							  </div>
							</td>
							<td><div class="form-group">
								<input type="text" class="form-control" name="hint4" value="'.$hint4.'">
							  </div>
							</td>
							<td><div class="form-group">
								<textarea class="form-control" name="fact">'.$fact.'</textarea>
							  </div>
							</td>
							<td><div class="form-group">
								<input type="text" class="form-control" value="'.$noofplayersolved.'" disabled>
							  </div>
							</td>
							<td><div class="form-group">
								<input type="text" class="form-control" name="qid" value="'.$qid.'" hidden>
							  </div>
							</td>
							';
					echo '<td><input type="submit" class="btn btn-primary" name="submit" value="Submit">
							</form></td></tr>';
				}
			?>	
			</table>
		</div>
	</div>
</div>
</body>
</html>