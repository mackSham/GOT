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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>User Information</title>
</head>
	<?php
		if(isset($_GET["user"])){
			$uname = $_GET["user"];
			echo '<h1>'.$uname.'</h1>';
			//echo readfile('user/'.$uname.'.txt');
			$myfile = fopen('userupdated/'.$uname.'.txt', "r") or die("Unable to open file!");
			// Output one line until end-of-file
			while(!feof($myfile)) {
			  echo fgets($myfile) . "<br>";
			}
			fclose($myfile);
		}else{
			header("location:../index.php");
		}
	?>
<body>
</body>
</html>