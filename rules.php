<?php
	session_start();
	include_once('include/connect.php');
	if(!isset($_SESSION['pid'])){
		header("location:index.php");
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
</head>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
	  <div class="container">
		  <a class="navbar-brand" href="index.php"><h3 style="line-height: 20px;">&nbsp; Game of Troves<br><mayank style="font-size: 55%">An Event of Neo Drishti-Ojass'18</mayank></h3></a>

		  <!-- Toggler/collapsibe Button -->
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <!-- Navbar links -->
		  <div class="collapse navbar-collapse mr-auto" id="collapsibleNavbar">
			<ul class="navbar-nav ml-auto">
			  <li class="nav-item">
				<a class="nav-link" href="home.php">Home</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="leaderboard.php">LeaderBoard</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link active" href="rules.php">Rules</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="logout.php">Log Out</a>
			  </li>
			</ul>
		  </div> 
	  </div>
	</nav>
	<div class="container" style="margin-top:5%; color:#7E7E7E; font-weight:bolder;">
		<div style="background-color: #FFF; border-radius: 5%; padding: 2%;">	
			<h2>You Should Read This.</h2>
			<p>With dedication and luck, you can win the world. add some research work and deductions and you can win GAME OF TROVES.

GAME OF TROVES: Given a picture, audio, video, you will have to find a string(key) which is somehow related to it distantly or less distantly. You can take as many chances as you want and you are free to search anywhere you want. And to make it even simpler we will be providing you clues/hints too. without clues/hints, there is an ocean of possibilities for the key and it will be just a blind luck. Keep hitting the answer box with something, anything that is related to it. It will be good for you if you consider clue as a part of the question. Clues/hints will make it less tough and will give you a Direction to reach the key. It’s a 5 days long event..
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
</body>
</html>