<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Winners Page</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" href="clock_assets/flipclock.css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</head>

<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
	  <div class="container">
		  <a class="navbar-brand" href="#"><h3 style="line-height: 20px;">&nbsp; Game of Troves<br><mayank style="font-size: 55%">An Event of Neo Drishti-Ojass'18</mayank></h3></a>

		  <!-- Toggler/collapsibe Button -->
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
			<span class="navbar-toggler-icon"></span>
		  </button>
	  </div>
	</nav>
<div class="container-fluid" style="padding: 2% 10%">
	
	<h4>That was easy peasy lemon squeezy<br>
	Don't you think so?<br>
	Well! we hope you learned a lot of things and facts in this journey of 5 days<br>
	So, we are here with the champions of <iGAMES OF TROVES></i></h4>	
</div>
<div class="container">
		<div class="row">
			<div class="col-md-2">
				
			</div>
			<div class="col-md-8">
				<div style="padding: 2% 0%; margin-top: 8%">
					<h2><center>LeaderBoard</center></h2>
					<table class="table table-hover">
						<thead>
						  <tr>
							<th>Rank</th>
							<th>Name</th>
							<th>Username</th>
						  </tr>
						</thead>
						<tbody>
						  
						
					<?php
							include_once('include/connect.php');
						$sql = "SELECT players.uname , players.fname ,players.lname FROM players INNER JOIN players_progress ON players.pid=players_progress.ppid WHERE players.activated='1' ORDER BY players_progress.question_no DESC , players_progress.points DESC, players_progress.start_time ASC LIMIT 3";
						$query = mysqli_query($db_conn,$sql);
						$i = 1;
						while($row = mysqli_fetch_assoc($query)){
							$name = $row["fname"].' '.$row["lname"];
							$uname = $row["uname"];
							if($i == 1){
								$rank = "Sherlock";
							}else if($i == 2){
								$rank = "Eurus";
							}else if($i == 3){
								$rank = "Mycroft";
							}else{
								$rank = $i;
							}
							
								echo '<tr><th>'.$rank.'</th><td>'.$name.'</td><td>'.$uname.'</td></tr>';	
							
							$i++;
						}
					?>
					</tbody>
				  </table>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
		
	</div>	
		
		
</body>
</html>