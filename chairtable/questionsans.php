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
    	$errors= array();
		$file_name = $_FILES['ques']['name'];
		$file_size =$_FILES['ques']['size'];
		$file_tmp =$_FILES['ques']['tmp_name'];
		$file_type=$_FILES['ques']['type'];
		$file_errorMsg = $_FILES["ques"]["error"];
		$file_ext=strtolower(end(explode('.',$_FILES['ques']['name'])));
		$answer = strtoupper($_POST['ans']);
		$answer = md5($answer);
		$hint1 = $_POST['hint1'];
		$hint2 = $_POST['hint2'];
		$hint3 = $_POST['hint3'];
		$hint4 = $_POST['hint4'];
		$fact = $_POST['fact'];
		
		$alternate_ans = strtoupper($_POST['alternate_ans']);
		//echo $alternate_ans;
		if($alternate_ans!=""){
			$alternate_ans = md5($alternate_ans);			
		}
		//echo $file_name.' '.$file_size.' '.$file_tmp.' '.$file_type.' '.$file_ext;

		$expensions= array("jpeg","jpg","png","mp4","mp3");
		if($answer == "" || $hint1 == "" ||$hint2 == "" || $hint3 == "" || $fact == "" || $hint4 == ""){
			echo '<script>alert("Please fill all data");</script>';
		 	//$errors[]="Please fill all data";
		}else if(in_array($file_ext,$expensions)=== false){
			echo '<script>alert("This extension not allowed, please choose a valid file.");</script>';
		 	//$errors[]="extension not allowed, please choose a valid file.";
		}else if($file_size > 20971520){
			echo '<script>alert("File size must be less than 20 MB.");</script>';
		 	//$errors[]='File size must be less than 20 MB.';
		}else if ($file_errorMsg == 1) {
			echo '<script>alert("An unknown error occurred.");</script>';
			//$errors[]='An unknown error occurred.';
		}else if(empty($errors)==true){
			$date = date("dmYHis");
			$filedate = $date.'.'.$file_ext;
			move_uploaded_file($file_tmp,"questions/".$filedate);
			
			$sql="INSERT INTO questions(question,answer,alternate_ans,hint1,hint2,hint3,hint4,fact)VALUES('$filedate','$answer','$alternate_ans','$hint1','$hint2','$hint3','$hint4','$fact')";
			$sql="INSERT INTO questions(question,answer,alternate_ans,hint1,hint2,hint3,hint4,fact)VALUES('$filedate','$answer','$alternate_ans','$hint1','$hint2','$hint3','$hint4','$fact')";
			mysqli_query($db_conn,$sql);
			die(mysqli_error($db_conn));
			echo '<script>alert("Success");</script>';
		}
   }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GOT Admin | Question Upload</title>
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
				<form action="" method="post" enctype="multipart/form-data">
				  <div class="form-group">
					<label for="ques">Upload Question:</label>
					<input type="file" class="form-control" id="ques" name="ques">
				  </div>
				  <div class="form-group">
					<label for="ans">Answer:</label>
					<input type="text" class="form-control" id="ans" name="ans">
				  </div>
				  <div class="form-group">
					<label for="ans">Second Answer(Optional):</label>
					<input type="text" class="form-control" id="ans" name="alternate_ans">
				  </div>
				  <div class="form-group">
					<label for="hint1">Hint 1:</label>
					<input type="text" class="form-control" id="hint1" name="hint1">
				  </div>
				  <div class="form-group">
					<label for="hint2">Hint 2:</label>
					<input type="text" class="form-control" id="hint2" name="hint2">
				  </div>
				  <div class="form-group">
					<label for="hint3">Hint 3:</label>
					<input type="text" class="form-control" id="hint3" name="hint3">
				  </div>
				  <div class="form-group">
					<label for="hint4">Hint 4:</label>
					<input type="text" class="form-control" id="hint4" name="hint4">
				  </div>
				  <div class="form-group">
					<label for="fact">Fact:</label>
					<textarea class="form-control" id="fact" name="fact"></textarea>
				  </div>
				  <input type="submit" class="btn btn-primary" value="Submit" name="submit">
				</form>		
			</div>
		</div>
	</div>
</body>
</html>