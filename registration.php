<?php
	include_once('include/connect.php');
	
	if(isset($_POST["submit"])){
		$fname=preg_replace('#[^a-z]#i', '', $_POST['fname']);
		$lname=preg_replace('#[^a-z]#i', '', $_POST['lname']);
		$uname=preg_replace('#[^a-z0-9]#i', '', $_POST['uname']);
		$email=mysqli_real_escape_string($db_conn, $_POST['email']);
		$pass=$_POST['pass'];
		$cpass=$_POST['cpass'];
		$clgname=preg_replace('#[^a-z0-9]#i','',$_POST['clgname']);
		$clgrn=$_POST['clgrn'];
		$city=preg_replace('#[^a-z]#i', '', $_POST['city']);
		$gender=preg_replace('#[^a-z]#i', '', $_POST['gender']);
		//Check for valid username
		$sql = "SELECT pid FROM players WHERE uname='$uname' LIMIT 1";
		$query = mysqli_query($db_conn, $sql); 
		$u_check = mysqli_num_rows($query);
		//Check for valid email address
		$sql = "SELECT pid FROM players WHERE email='$email' LIMIT 1";
		$query = mysqli_query($db_conn, $sql); 
		$e_check = mysqli_num_rows($query);
		//Validating inputs
		if($pass != $cpass){
			echo "Password Doesn't matches";
		} else if($fname=="" || $lname == "" || $uname == "" || $email == "" || $pass == "" || $gender == "" || $city == "" || $clgname == "" || $clgrn == ""){
			echo "Please fill the form completely";
			exit();
		} else if ($u_check > 0){ 
			echo "The username you entered is already taken";
			exit();
		} else if ($e_check > 0){ 
			echo "That email address is already in use in the system";
			exit();
		} else if (strlen($uname) < 3 || strlen($uname) > 16) {
			echo "Username must be between 3 and 16 characters";
			exit(); 
		} else if (is_numeric($uname[0])) {
			echo 'Username cannot begin with a number';
			exit();
		} else {
			$p_hash = md5($pass);
			include_once('include/randStrGen.php');
			$rand = randStrGen(8);
			$sql = "INSERT INTO players (fname, lname, uname, email, pass, clgname,clgrn,city,gender,verification_code)VALUES('$fname','$lname','$uname','$email','$p_hash','$clgname','$clgrn','$city','$gender','$rand')";
			$query = mysqli_query($db_conn, $sql); 
			//die(mysqli_error($db_conn));
			$uid = mysqli_insert_id($db_conn);
			date_default_timezone_set("Asia/Kolkata");
			$curr_date = date("Y-m-d H:i:s");
			$start_date = "2018-03-11 05:00:00";
			//$diff=date_diff($curr_date,$start_date);
			//print_r($diff);
			echo strtotime($curr_date).'<br>';
			echo strtotime($start_date);
			if(strtotime($curr_date) >= strtotime($start_date)){
				//$date = date_create_from_format("Y-m-d H:i:s",$curr_date);
				$date = $curr_date;
			}else{
				//$date = date_create_from_format("Y-m-d H:i:s",$start_date);
				$date = $start_date;
			}
			echo $start_date;
			$sql = "INSERT INTO players_progress (ppid, question_no, start_time) VALUES ('$uid','1','$date')";
			$query = mysqli_query($db_conn, $sql);
			echo "signup_success";
		}

	}
?>