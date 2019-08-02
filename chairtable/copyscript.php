<?php
	include_once("../include/connect.php");
	$sql = "SELECT uname,pass FROM players";
	$query = mysqli_query($db_conn,$sql);
	$count = 0;
	while($row = mysqli_fetch_assoc($query)){
		$uname = $row["uname"];
		$pass = $row["pass"];
		$newuname = $uname.''.$pass;
		
		if(copy("user/".$uname.".txt","userupdated/".$newuname.".txt")){
			$count++;
		}
		//echo $row['uname'].'<br>'.$row['pass'].'<br>';
	}
echo $count.' number of file updated';
?>