<?php

	//$dbconn3 = pg_connect("host=localhost port=5432 dbname=meeting user=postgres password=admin");
	
	define('DB_HOST', getenv('OPENSHIFT_POSTGRESQL_DB_HOST'));
	define('DB_PORT', getenv('OPENSHIFT_POSTGRESQL_DB_PORT'));

	$dbhost = constant("DB_HOST"); // Host name 
	$dbport = constant("DB_PORT"); // Host port
	$dbusername = 'adminy5ttxew';
	$dbpassword = 'IZdGfGX6kCHl';

	$dbconn3 = pg_connect("host='$dbhost' port='$dbport' dbname=v1 user='$dbusername' password='$dbpassword'");
	
	$re = '/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i';
	
	
	date_default_timezone_set("UTC");
	$atualDate =  date("Y-m-d H:i:s", time());
	
	$first_name = $_POST["first_name"];;
	$last_name = $_POST["last_name"];;
	$email = $_POST["email"];;
	$phone = $_POST["phone"];;
	
	
	$codedEmail = pg_escape_string($email);
	$codedFirstName = pg_escape_string($first_name);
	$codedLastName = pg_escape_string($last_name);
	$codedPhone = pg_escape_string($phone);
	$codedAtualDate = pg_escape_string($atualDate);

	$exists_email = pg_query($dbconn3, "SELECT count(*) from  register where register.email = ('$codedEmail')");		
	$count_email = pg_fetch_result($exists_email, 0);		
		
	if (preg_match($re, $email) === 1) {	
		if($count_email != 0){
			echo -1;
		}else {
			$result = pg_query($dbconn3, "insert into register (fisrt_name, last_name, email, phone, register_date) values ('$codedFirstName', '$codedLastName', '$codedEmail', '$codedPhone', '$codedAtualDate')");
			echo 1;
		}
	}else{
		echo 0;
	}
	
	pg_close($dbconn3);									
   
?>
