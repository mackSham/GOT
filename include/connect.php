<?php
$db_conn = mysqli_connect("localhost","root","","got");

	if(mysqli_connect_errno()){
		echo mysql_connect_error();
		exit();
	}

?>