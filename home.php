<?php
	session_start();
	include_once('include/connect.php');
	if(!isset($_SESSION['pid'])){
		header("location:index.php");
	}
	$pid = $_SESSION['pid'];
	$uname = $_SESSION['uname'];
	$sql = "SELECT question_no,start_time,points,msg FROM players_progress WHERE ppid='$pid' LIMIT 1";
	$query = mysqli_query($db_conn,$sql);
	$row = mysqli_fetch_assoc($query);

	$question_no = $row['question_no'];
	$start_time = $row['start_time'];
	$points = $row['points'];
	$msg = $row['msg'];
	
	$sql = "SELECT question,hint1,hint2,hint3,hint4 FROM questions WHERE qid='$question_no' LIMIT 1";
	$query = mysqli_query($db_conn,$sql);
	$row = mysqli_fetch_assoc($query);

	$question = $row["question"]; 
	$hint1 = $row['hint1'];
	$hint2 = $row['hint2'];
	$hint3 = $row['hint3'];
	$hint4 = $row['hint4'];
	$file_ext=strtolower(end(explode('.',$question)));
	
	date_default_timezone_set("Asia/Kolkata");
	$curr_date = date("Y-m-d H:i:s");

	$sql = "UPDATE players_progress SET msg = '$hint4' WHERE ppid = '$pid' AND start_time <= DATE_SUB('$curr_date', INTERVAL 7 HOUR)";
	mysqli_query($db_conn,$sql);
	
?>
<?php
	if(isset($_POST["attemp_ans"])){
		$attemp_ans = strtoupper($_POST['attemp_ans']);
		date_default_timezone_set("Asia/Kolkata");
		$curr_date = date("Y-m-d H:i:s");
		$sql = "SELECT pass FROM players WHERE uname='$uname' LIMIT 1";
		$query = mysqli_query($db_conn,$sql);
		$row = mysqli_fetch_assoc($query);
		$pass = $row['pass'];
		$filename = $uname.''.$pass;
		$myfile = fopen('chairtable/userupdated/'.$filename.'.txt', "a") or die("Unable to open file!");
		fwrite($myfile,$attemp_ans.'	'.$curr_date.'
');
		fclose($myfile);
		$attemp_ans = md5($attemp_ans);
		$sql = "SELECT answer,alternate_ans,fact,noofplayersolved FROM questions WHERE qid='$question_no' LIMIT 1";
		$query = mysqli_query($db_conn,$sql);
		$row = mysqli_fetch_assoc($query);
		$answer = $row["answer"];
		$alternate_ans = $row["alternate_ans"];
		$fact = $row['fact'];
		$noofplayersolved = $row['noofplayersolved'];
		//echo $attemp_ans.' '.$alternate_ans.' '.$answer;
		if($attemp_ans == $answer || $attemp_ans == $alternate_ans){
			$prev_questno = $question_no; 
			$question_no = intval($question_no+1);
			//echo $question_no.'<br>';
			
			
			//echo $curr_date.'<br>';
			
			//echo $pid;
			if($noofplayersolved==0){
				$points	= $points+5;
			}else if($noofplayersolved == 1){
				$points	= $points+4;
			}else if($noofplayersolved == 2){
				$points	= $points+3;
			}else{
				$points	= $points+2;
			}
			$noofplayersolved = $noofplayersolved +1;
			$sql = "UPDATE players_progress SET question_no = '$question_no' , start_time = '$curr_date' ,points = '$points' WHERE ppid='$pid' LIMIT 1";
			mysqli_query($db_conn,$sql);
			$sql = "UPDATE questions SET noofplayersolved = '$noofplayersolved' WHERE qid='$prev_questno' LIMIT 1";
			mysqli_query($db_conn,$sql);
			echo $fact;
			exit();
		}else{
			echo "Not Success";
			exit();
		}
	}	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" href="clock_assets/flipclock.css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>
<script>
	function submit(){
		//alert("vdfvd");
		var attemp_ans = document.getElementById("attemp_ans").value;
		//var lp = _("lpassword").value;
		if(attemp_ans == ""){
			alert("Answer Field is Empty!!!");
		} else {
			////("loginbtn").style.opacity ="0.9";
			//_("loginbtn").innerHTML = 'please wait ...';
			var ajax = ajaxObj("POST", "home.php");
			ajax.onreadystatechange = function() {
				if(ajaxReturn(ajax) == true) {
					//alert(ajax.responseText);
					if(ajax.responseText == "Not Success"){
						alert("Wrong Answer");
					}else {
						document.getElementById("modal_body").innerHTML = ajax.responseText;
						
						$(document).ready(function(){
							$("#myModal").modal("show");
						});
					}
				}
			}
			ajax.send("attemp_ans="+attemp_ans);
		}
	}
</script>
</head>
<body>
	<nav class="navbar navbar-expand-md bg-dark navbar-dark">
	  <div class="container">
		  <a class="navbar-brand" href="#"><h3 style="line-height: 20px;">&nbsp; Game of Troves<br><mayank style="font-size: 55%">An Event of Neo Drishti-Ojass'18</mayank></h3></a>

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
				<a class="nav-link" href="leaderboard.php">LeaderBoard</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="rules.php">Rules(Updated)</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="logout.php">Log Out</a>
			  </li> 
			</ul>
		  </div> 
	  </div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-md-9">
			<br><br>
				<?php
                echo '<h2>Question No. '.$question_no.'</h2>';
					if($file_ext == 'mp3'){
						echo '<div style="width:100%; background-color:#000;color:#FFF;padding:12%;"><h2><center>Click the play button to listen the question</center></h2>
                                </div>
                              <audio controls style="width:100%">
								<source src="chairtable/questions/'.$question.'" type="audio/mpeg">
								Your browser does not support the audio element.
							  </audio>';
					}else if($file_ext == 'mp4'){
						echo '<video width="320" height="240" controls style="width:100%;">
								  <source src="chairtable/questions/'.$question.'" type="video/mp4">
								  Your browser does not support the video tag.
								</video>';
					}else{
						echo '<img src="chairtable/questions/'.$question.'" width="100%">';
					}

				?>
				<!-- <form onSubmit="return false();"> --> 
				  <div class="form-group">
					<label for="attemp_ans">Answer:</label>
					<input type="text" class="form-control" id="attemp_ans" name="attemp_ans" title="Answer can only be alphanumeric">
				  </div>
					<button type="submit" class="btn btn-primary" onClick="submit();">Submit</button>
				<!-- </form>-->
			</div>
			<div class="col-md-3">
               <br><br>
               <div style="border:2px solid #000; border-radius:20px; padding: 2% 12%; box-shadow: 10px 10px 5px grey;">
                <center><h2>Hints</h2></center>
                <?php 
                    date_default_timezone_set("Asia/Kolkata");
                    //echo $start_time.'<br>';
                    $start_time = strtotime($start_time);
                    //echo date("Y-m-d H:i:s").'<br>';
                    $curr_date = strtotime(date("Y-m-d H:i:s"));
                    $diff = $curr_date-$start_time;
				    
				    
				    //echo $nextHintTime;
                    //echo $diff;
                    //echo $start_time.'<br>'.$curr_date;
                    if( $diff >= 3600 && $diff < 7200){
						$nextHintTime = $start_time + 7200; // Add 1 hour
						$nextHintTime = date('M j, Y H:i:s', $nextHintTime);
                        echo 'Hint 1: '.$hint1.'<br>';
						echo 'Your Next Hint will appear in <p id="demo"></p>
								<script>
							var countDownDate = new Date("'.$nextHintTime.'").getTime();
							// Update the count down every 1 second
							var x = setInterval(function() {

								// Get todays date and time
								var now = new Date().getTime();

								// Find the distance between now an the count down date
								var distance = countDownDate - now;

								// Time calculations for days, hours, minutes and seconds
								var days = Math.floor(distance / (1000 * 60 * 60 * 24));
								var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
								var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
								var seconds = Math.floor((distance % (1000 * 60)) / 1000);

								// Output the result in an element with id="demo"
								document.getElementById("demo").innerHTML = hours + "h :"
								+ minutes + "m :" + seconds + "s ";

								// If the count down is over, write some text 
								if (distance < 0) {
									clearInterval(x);
									window.location="home.php";
								}
							}, 1000);
							</script>';
                    }else if($diff >= 7200 && $diff < 10800){
						$nextHintTime = $start_time + 10800; // Add 1 hour
						$nextHintTime = date('M j, Y H:i:s', $nextHintTime);
                        echo 'Hint 1: '.$hint1.'<br>';
                        echo 'Hint 2: '.$hint2.'<br>';
						echo 'Your Next Hint will appear in <p id="demo"></p>
								<script>
							var countDownDate = new Date("'.$nextHintTime.'").getTime();
							// Update the count down every 1 second
							var x = setInterval(function() {

								// Get todays date and time
								var now = new Date().getTime();

								// Find the distance between now an the count down date
								var distance = countDownDate - now;

								// Time calculations for days, hours, minutes and seconds
								var days = Math.floor(distance / (1000 * 60 * 60 * 24));
								var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
								var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
								var seconds = Math.floor((distance % (1000 * 60)) / 1000);

								// Output the result in an element with id="demo"
								document.getElementById("demo").innerHTML = hours + "h :"
								+ minutes + "m :" + seconds + "s ";

								// If the count down is over, write some text 
								if (distance < 0) {
									clearInterval(x);
									window.location="home.php";
								}
							}, 1000);
							</script>';
                    }else if($diff >= 10800){
                        echo 'Hint 1: '.$hint1.'<br>';
                        echo 'Hint 2: '.$hint2.'<br>';
                        echo 'Hint 3: '.$hint3.'<br>'; 
                    }else{
						$nextHintTime = $start_time + 3600; // Add 1 hour
						$nextHintTime = date('M j, Y H:i:s', $nextHintTime);
						echo 'Your Hint will appear in <p id="demo"></p>
								<script>
							var countDownDate = new Date("'.$nextHintTime.'").getTime();
							// Update the count down every 1 second
							var x = setInterval(function() {

								// Get todays date and time
								var now = new Date().getTime();

								// Find the distance between now an the count down date
								var distance = countDownDate - now;

								// Time calculations for days, hours, minutes and seconds
								var days = Math.floor(distance / (1000 * 60 * 60 * 24));
								var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
								var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
								var seconds = Math.floor((distance % (1000 * 60)) / 1000);

								// Output the result in an element with id="demo"
								document.getElementById("demo").innerHTML = hours + "h : "
								+ minutes + "m : " + seconds + "s";

								// If the count down is over, write some text 
								if (distance < 0) {
									clearInterval(x);
									window.location="home.php";
								}
							}, 1000);
							</script>';
					}
                ?>
				</div>
				<div style="margin-top:20%;">
					<center><h4>Self Destruction Sequence Initiated</h4></center>
					<div class="clock-builder-output"></div>
					<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
					<script type="text/javascript" src="clock_assets/flipclock.js"></script>
					<style text="text/css">body .flip-clock-wrapper ul li a div div.inn, body .flip-clock-small-wrapper ul li a div div.inn { color: #CCCCCC; background-color: #333333; } body .flip-clock-dot, body .flip-clock-small-wrapper .flip-clock-dot { background: #323434; } body .flip-clock-wrapper .flip-clock-meridium a, body .flip-clock-small-wrapper .flip-clock-meridium a { color: #323434; }</style>
					<script type="text/javascript">
					$(function(){
						FlipClock.Lang.Custom = { days:'Days', hours:'Hours', minutes:'Minutes', seconds:'Seconds' };
						var opts = {
							clockFace: 'HourCounter',
							countdown: true,
							language: 'Custom'
						};
						opts.classes = {
							active: 'flip-clock-active',
							before: 'flip-clock-before',
							divider: 'flip-clock-divider',
							dot: 'flip-clock-dot',
							label: 'flip-clock-label',
							flip: 'flip',
							play: 'play',
							wrapper: 'flip-clock-small-wrapper'
						};  
						var countdown = 1521207000 - ((new Date().getTime())/1000); // from: 03/16/2018 07:00 pm +0530
						countdown = Math.max(1, countdown);
						$('.clock-builder-output').FlipClock(countdown, opts);
					});
					</script>	
				</div>
			</div>
		</div>
	</div>	
	<div class="container" style="margin-top:2">
		<div style="border:2px solid #000; border-radius:20px; padding: 2%; margin-top: 4%">
            <h2> Message from Moriarty</h2>
            <?php
				if($msg == ""){
            		echo 'Try hitting the answer box. If you are close we will help';
				}else{

					echo $msg; 
				} 
			?>
        </div>
    </div>
	
	
	
</body>
</html>
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
	<div class="modal-content">

	  <!-- Modal Header -->
	  <div class="modal-header">
		<h4 class="modal-title">Congratulations!!!</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	  </div>

	  <!-- Modal body -->
	  <div class="modal-body"  id="modal_body">
	  </div>

	  <!-- Modal footer -->
	  <div class="modal-footer">
		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	  </div>

	</div>
  </div>
</div>
<script>
	$("#myModal").on("hidden.bs.modal", function () {
		window.location="home.php";
	});
</script>