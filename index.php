<?php
	session_start();
	if(isset($_SESSION['pid'])){
		header("location:home.php");
	}
?>
<?php
	if(isset($_GET['errmsg'])){
		$errmsg = $_GET['errmsg'];
		//echo $errmsg;
		echo '<script>alert("'.$errmsg.'");</script>';
		echo '<script>window.location="index.php";</script>';
	}
?>
<?php
	if(isset($_POST["reg_submit"])){
		include_once('include/connect.php');
		$fname=preg_replace('#[^a-z]#i', '', $_POST['fname']);
		$lname=preg_replace('#[^a-z]#i', '', $_POST['lname']);
		$uname=preg_replace('#[^a-z0-9]#i', '', $_POST['uname']);
		$email=mysqli_real_escape_string($db_conn, $_POST['email']);
		$pass=$_POST['pass'];
		$cpass=$_POST['cpass'];
		$clgname=preg_replace('#[^a-z0-9 ]#i','',$_POST['clgname']);
		$clgrn=$_POST['clgrn'];
		$city=preg_replace('#[^a-z]#i', '', $_POST['city']);
		$mobileno = $_POST['mobileno'];
		$gender= $_POST['gender'];
		//Check for valid username
		$sql = "SELECT pid FROM players WHERE uname='$uname' LIMIT 1";
		$query = mysqli_query($db_conn, $sql); 
		$u_check = mysqli_num_rows($query);
		//Check for valid email address
		$sql = "SELECT pid FROM players WHERE email='$email' LIMIT 1";
		$query = mysqli_query($db_conn, $sql); 
		$e_check = mysqli_num_rows($query);
		//Validating inputs
		//echo $fname.' '.$lname.' '.$uname.' '.$email.' '.$pass.' '.$gender.' '.$city.' '.$clgname.' '.$clgrn.' '.$mobileno;
		if($fname=="" || $lname == "" || $uname == "" || $email == "" || $pass == "" || $gender == "cg" || $city == "" || $clgname == "" || $clgrn == "" || $mobileno == ""){
			header("location:index.php?errmsg=Please fill all information");
		} else if($pass != $cpass){
			header("location:index.php?errmsg=Password Doesn't matches");
			//echo "Password Doesn't matches";
		} else if ($u_check > 0){ 
			header("location:index.php?errmsg=The username you entered is already taken");
			//echo "The username you entered is already taken";
		} else if ($e_check > 0){ 
			header("location:index.php?errmsg=That email address is already in use in the system");
			//echo "That email address is already in use in the system";
		} else if (strlen($uname) < 3 || strlen($uname) > 16) {
			header("location:index.php?errmsg=Username must be between 3 and 16 characters");
			//echo "Username must be between 3 and 16 characters"; 
		} else if (is_numeric($uname[0])) {
			header("location:index.php?errmsg=Username cannot begin with a number");
			//echo 'Username cannot begin with a number';
		} else if(strlen($mobileno)!=10 || !is_numeric($mobileno)){
			header("location:index.php?errmsg=Enter a valid mobile number");
			//echo 'Enter a valid mobile number';
		} else {
			$p_hash = md5($pass);
			include_once('include/randStrGen.php');
			$rand = randStrGen(8);
			$sql = "INSERT INTO players (fname, lname, uname, email, pass, clgname,clgrn,city,gender,mobileno,verification_code)VALUES('$fname','$lname','$uname','$email','$p_hash','$clgname','$clgrn','$city','$gender','$mobileno','$rand')";
			$query = mysqli_query($db_conn, $sql); 
			//die(mysqli_error($db_conn));
			$uid = mysqli_insert_id($db_conn);
			date_default_timezone_set("Asia/Kolkata");
			$curr_date = date("Y-m-d H:i:s");
			$start_date = "2018-03-11 19:00:00";
			//$diff=date_diff($curr_date,$start_date);
			//print_r($diff);
			//echo strtotime($curr_date).'<br>';
			//echo strtotime($start_date);
			if(strtotime($curr_date) >= strtotime($start_date)){
				//$date = date_create_from_format("Y-m-d H:i:s",$curr_date);
				$date = $curr_date;
			}else{
				//$date = date_create_from_format("Y-m-d H:i:s",$start_date);
				$date = $start_date;
			}
			//echo $start_date;
			$sql = "INSERT INTO players_progress (ppid, question_no, start_time) VALUES ('$uid','1','$date')";
			$query = mysqli_query($db_conn, $sql);
            $to = $email;
            $subject = "Activate Your GOT Account";
            //$actual_link = "http://$_SERVER[HTTP_HOST]"."/changepassword.php";
            //$toEmail = $email;
            //$subject = "Reset password Email";
                    //$content = "Click this link to activate your account. <a href=" . $actual_link . ">" . $actual_link . "</a>";

            $message = '
            <html>
            <head>
              <title>Activation Link</title>
            </head>
            <body>
              Click this link to activate your account. <a href= "www.scanitjsr.org/got/activation.php?uname='.$uname.'">Click here to activate!</a>Your OTP is: <b>'.$rand.'</b>
            </body>
            </html>
            ';
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

            mail($to, $subject, $message, implode("\r\n", $headers));
						
			header("location:index.php?errmsg=Mail has been sent to your account.If you haven't received any email, kindly wait for few minutes or call the event coordinators.");
			//echo "signup_success";
		}

	}
?>
<?php
	if(isset($_POST['login_submit'])){
		//echo 'mayank';
		include_once('include/connect.php');
		$uoe = $_POST["uoe"];
		//echo $_POST['pass'].'<br>';
		$pass = md5($_POST['pass']);
		
		if($uoe == "" || $pass == ""){
			header("location:index.php?errmsg=Please fill all information");
			//exit();
		}else{
			$sql = "SELECT pid,pass,uname FROM players WHERE (uname = '$uoe' OR email='$uoe') AND activated = '1' LIMIT 1";
			$query = mysqli_query($db_conn,$sql);
			$row = mysqli_fetch_assoc($query);
			$db_pid = $row['pid'];
			$db_pass = $row['pass'];
			$db_uname = $row['uname'];
			//echo $db_pass.'<br> '.$pass;
			if($db_pass != $pass){
				header("location:index.php?errmsg=Login Failed");
				//echo 'Login Failed';
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
<?php
if(isset($_POST["usernamecheck"])){
	include_once("include/connect.php");
	$username = $_POST['usernamecheck'];
	$sql = "SELECT pid FROM players WHERE uname='$username' LIMIT 1";
    $query = mysqli_query($db_conn, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) {
	    echo '3 - 16 characters please';
	    exit();
    }
	
	if (is_numeric($username[0])) {
	    echo 'Usernames must begin with a letter';
	    exit();
    }
	if(preg_match('#[^a-zA-Z0-9]#i',$username)){
		echo 'Not aplhanumeric';
		exit();
	}
    if ($uname_check < 1) {
	    echo "It's OK";
	    exit();
    } else {
	    echo "It's TAKEN";
	    exit();
    }
}
?>
<?php
if(isset($_POST["emailcheck"])){
	include_once("include/connect.php");
	$email = $_POST['emailcheck'];
	$sql = "SELECT pid FROM players WHERE email='$email' LIMIT 1";
    $query = mysqli_query($db_conn, $sql); 
    $email_check = mysqli_num_rows($query);
	if(!preg_match('#[a-zA-Z0-9._%+-]@+[a-zA-Z0-9.-].+[a-zA-Z]#',$email)){
		echo 'Enter a valid Email address';
		exit();
	}
    if ($email_check < 1) {
	    echo "It's OK";
	    exit();
    } else {
	    echo "It's TAKEN";
	    exit();
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Games of Troves</title>
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
<script src="js/ajax.js"></script>
<script type="text/javascript">
	function checkpassword(){
		var rpass = document.getElementById("rpass").value;
		var cpass = document.getElementById("cpass").value;
		if(rpass != cpass){
			alert("Password does not match");
			return false;
		}else{
			return true;
		}
	}
	function checkuname(){
		var u = document.getElementById("uname").value;
		if(u != ""){
			document.getElementById("uname").style.background = "url(img/checking.gif) no-repeat";
			document.getElementById("uname").style.backgroundSize = "25px 25px";
			document.getElementById("uname").style.backgroundPosition= "right";
			var ajax = ajaxObj("POST", "index.php");
			ajax.onreadystatechange = function() {
				if(ajaxReturn(ajax) == true) {
					if(ajax.responseText == "3 - 16 characters please"){
						document.getElementById("uname").style.background = "url(img/problem.jpg) no-repeat";
						document.getElementById("uname").style.backgroundSize = "25px 25px";
						document.getElementById("uname").style.backgroundPosition= "right";
						document.getElementById("uname").title = "3 - 16 characters please";
					}else if(ajax.responseText == "Usernames must begin with a letter"){
						document.getElementById("uname").style.background = "url(img/problem.jpg) no-repeat";
						document.getElementById("uname").style.backgroundSize = "25px 25px";
						document.getElementById("uname").style.backgroundPosition= "right";
						document.getElementById("uname").title = "Usernames must begin with a letter";
					}else if(ajax.responseText == "Not aplhanumeric"){
						document.getElementById("uname").style.background = "url(img/problem.jpg) no-repeat";
						document.getElementById("uname").style.backgroundSize = "25px 25px";
						document.getElementById("uname").style.backgroundPosition= "right";
						document.getElementById("uname").title = "Only alphanumeric charecter is allowed";
					}else if(ajax.responseText == "It's OK"){
						document.getElementById("uname").style.background = "url(img/tick.jpg) no-repeat";
						document.getElementById("uname").style.backgroundSize = "25px 25px";
						document.getElementById("uname").style.backgroundPosition= "right";
						document.getElementById("uname").title = "This username is OK";
					} else if(ajax.responseText == "It's TAKEN"){
						document.getElementById("uname").style.background = "url(img/problem.jpg) no-repeat";
						document.getElementById("uname").style.backgroundSize = "25px 25px";
						document.getElementById("uname").style.backgroundPosition= "right";
						document.getElementById("uname").title = "This username is Taken";
					}
				}
			}
			ajax.send("usernamecheck="+u);
		}
	}
	function checkemail(){
		var e = document.getElementById("email").value;
		if(e != ""){
			document.getElementById("email").style.background = "url(img/checking.gif) no-repeat";
			document.getElementById("email").style.backgroundSize = "25px 25px";
			document.getElementById("email").style.backgroundPosition= "right";
			var ajax = ajaxObj("POST", "index.php");
			ajax.onreadystatechange = function() {
				if(ajaxReturn(ajax) == true) {
					if(ajax.responseText == "Enter a valid Email address"){
						document.getElementById("email").style.background = "url(img/problem.jpg) no-repeat";
						document.getElementById("email").style.backgroundSize = "25px 25px";
						document.getElementById("email").style.backgroundPosition= "right";
						document.getElementById("email").title = "Enter a valid Email address";
					}else if(ajax.responseText == "It's OK"){
						document.getElementById("email").style.background = "url(img/tick.jpg) no-repeat";
						document.getElementById("email").style.backgroundSize = "25px 25px";
						document.getElementById("email").style.backgroundPosition= "right";
						document.getElementById("email").title = "This email is OK";
					} else if(ajax.responseText == "It's TAKEN"){
						document.getElementById("email").style.background = "url(img/problem.jpg) no-repeat";
						document.getElementById("email").style.backgroundSize = "25px 25px";
						document.getElementById("email").style.backgroundPosition= "right";
						document.getElementById("email").title = "This email is already in use";
					}
				}
			}
			ajax.send("emailcheck="+e);
		}
	}
</script>
<style>
	body{
		background-image: url(img/bg.jpg);
		background-attachment: fixed;
		background-repeat: no-repeat;
		background-size: cover;
        color:#000;
	}	
	
	a{
		text-decoration: none;
		color: #000;
	}
	a:hover{
		text-decoration: none;
	}
	.header{
		margin-top:15px;
		color:#000;
	}
	.title{
		line-height:1px;
	}
	.reg{
		background-color: #FFF;
		margin-top:15%;
		padding: 2%;
		color: #3B2828;
	}
	.parallax{
		margin-top:8%; 
	}
</style>
</head>
<body>
	<div class="container header">
		<div class="row">
			<div class="col-md-11 title"><h1>Game of Troves</h1><br>An Event Under Neo Drishti-OJASS'18</div>
			<div class="col-md-1">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  					Log In
				</button>
			</div>
		</div> <!-- End of First Row -->
		<div class="row">
			<div class="col-md-6">
				<div class="reg text-center">
					<h3>Registration Form</h3>
					<br>
					<form action="" method="post">
						<div class="form-group" style="width:60%;float: left;">
							<input type="text" class="form-control" id="fname" name="fname" placeholder="Enter Your First Name" pattern="[A-Za-z]{1,}" title="Only alphabet is allowed" required>
					  	</div>
					  	<div class="form-group" style="width: 40%; float: left;">
							<input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Your Last Name" pattern="[A-Za-z]{1,}" title="Only alphabet is allowed" required>
					  	</div>
					  	<div class="form-group">
							<input type="text" class="form-control" id="uname" name="uname" placeholder="Enter a Username" pattern="[A-Za-z0-9]{3,16}" title="Only alphanumeric character is allowed with length between 3 to 16" onblur="checkuname();" required>
					  	</div>
						<div class="form-group">
							<input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email Address" onblur="checkemail();" required>
					  	</div>
					  	<div class="form-group">
							<input type="password" class="form-control" id="rpass" name="pass" placeholder="Enter Your Password" pattern=".{6,}" title="Your password must be of atleast 6 character" required>
					  	</div>
					  	<div class="form-group">
							<input type="password" class="form-control" id="cpass" name="cpass"placeholder="Enter Your Password Again" onblur="checkpassword();" required>
					  	</div>
					  	<div class="form-group">
							<input type="text" class="form-control" id="clgname" name="clgname" placeholder="Enter Your College Name" pattern="[A-Za-z ]{1,}" title="Only alphabet character is allowed" required>
					  	</div>
					  	<div class="form-group">
							<input type="text" class="form-control" id="clgrn" name="clgrn" placeholder="Enter Your College Registration Number" pattern="[A-Za-z0-9]{1,}" title="Only alphabet character is allowed" required>
					  	</div>
					  	<div class="form-group"> 
							<input type="text" class="form-control" id="city" name="city" placeholder="Enter Your City" pattern="[A-Za-z]{1,}" title="Only alphabet character is allowed" required>
					  	</div>
					  	<div class="form-group">
							<input type="text" class="form-control" id="mobileno" name="mobileno" placeholder="Enter Your Mobile Number(Ex. 9532702226)" pattern="[0-9]{10,10}" title="Enter a valid 10 digit number" required>
					  	</div>
					  	<div class="form-group">
							<select class="form-control" name="gender" required>
                                <option value="cg" readonly>choose gender</option>
								<option value="m">Male</option>
								<option value="f">Female</option>
							</select>
					  	</div>
					  	<input type="submit" class="btn btn-primary" value="Submit" name="reg_submit">
					  	<input type="reset" class="btn btn-primary" value="Reset">
					</form>
				</div>
			</div>
			<div class="col-md-6">
			</div>
		</div>	<!-- End of Second row -->
	</div>	<!-- End of Container -->
	<div class="container" style="margin-top:5%; color:#7E7E7E; font-weight:bolder;">
		<div style="background-color: #FFF; border-radius: 5%; padding: 2%;">	
			<h2>You Should Read This.</h2>
			<p>With dedication and luck, you can win the world. add some research work and deductions and you can win GAME OF TROVES.<br>

GAME OF TROVES: Given a picture, audio, video, you will have to find a string(key) which is somehow related to it distantly or less distantly. You can take as many chances as you want and you are free to search anywhere you want. And to make it even simpler we will be providing you clues/hints too. without clues/hints, there is an ocean of possibilities for the key and it will be just a blind luck. Keep hitting the answer box with something, anything that is related to it. It will be good for you if you consider clue as a part of the question. Clues/hints will make it less tough and will give you a Direction to reach the key. It’s a 5 days long event.






			</p>
		</div>
	</div>
	<div class="container" style="color:#7E7E7E; font-weight:bolder;">
  		<div style="background-color: #FFF; border-radius: 5%; padding: 2%;">
		  <h2>How To Play</h2>
		  <ol style="list-style-type: none;">
			<li><i class="fa fa-hand-o-right text-primary"></i>&nbsp; &nbsp;Submit your answers/string(key) in the textbox, given below the question.</li>
			<li><i class="fa fa-hand-o-right text-primary"></i>&nbsp; &nbsp;A Total of 3 prizes will be awarded. The prizes will be awarded according to the order in which the players finished the game along with their points. The first prize will be given 		
   to the player who finishes the game first with the maximum no. of points, second to the player who completes second with the second maximum points and so on. So your whole journey 									
   will matter.</li>
			<li><i class="fa fa-hand-o-right text-primary"></i>&nbsp; &nbsp;Questions can be in any form(picture, audio, video).</li>
			<li><i class="fa fa-hand-o-right text-primary"></i>&nbsp; &nbsp;Any mail asking for answers or hints shall not be entertained.</li>
			<li><i class="fa fa-hand-o-right text-primary"></i>&nbsp; &nbsp;Answers may relate to the clue in any complex form.</li>
			<li><i class="fa fa-hand-o-right text-primary"></i>&nbsp; &nbsp;Only alphabets and numbers will be the part of the string(key). Special characters like @ _,.- will not be the part of any key. however, you can use whitespace between two words (Example: 13 sep 1995).</li>
			<li><i class="fa fa-hand-o-right text-primary"></i>&nbsp; &nbsp;Any attempt of hacking will lead to automatic disqualification. If the admin realizes that any participant has used any kind of unfair means to clear any level then the admin is liable to block the user without any prior notice to anyone and admin will be unquestionable.</li>
			<li><i class="fa fa-hand-o-right text-primary"></i>&nbsp; &nbsp;The first player to find the key to the question will be awarded 5 points. The second player to find the key to the question will be awarded 4 points. The third player to find the 
		   key to the question will be awarded 3 points. Every next player to find the key will be awarded 2 points.</li>
		   <li><i class="fa fa-hand-o-right text-primary"></i>&nbsp; &nbsp;The position of a player on the leaderboard is determined by the number of questions he/she has solved and the numbers of points he/she has earned. </li>
		   <li><i class="fa fa-hand-o-right text-primary"></i>&nbsp; &nbsp;There will be no use of abbreviations in any of the key. </li>
		   
		   <li><i class="fa fa-hand-o-right text-primary"></i>&nbsp; &nbsp;if any key is a date then use "dd mon yyyy" as the date format (example: 13 sep 1995 ). In case of month and year (example: September 1995). In case of only year (example: 1995). </li>
		   <li><i class="fa fa-hand-o-right text-primary"></i>&nbsp; &nbsp;if any key is a URL then use "dot" instead of "." </li>
		  </ol>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-4 text-center" style="padding: 2%;color:#B74345;">
			</div>
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
		</div>
	</div>
</body>
</html>


<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Let's Play</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="" method="post">
		  <div class="form-group">
			<label for="email">Email address or Username:</label>
			<input type="text" class="form-control" id="uoe" name="uoe">
		  </div>
		  <div class="form-group">
			<label for="pass">Password:</label>
			<input type="password" class="form-control" id="lpass" name="pass">
		  </div>
		  <input type="submit" class="btn btn-primary" value="Submit" name="login_submit">
		</form>
      </div>
      
    </div>
  </div>
</div>
