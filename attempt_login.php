<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>
<?php //require_once dirname(__FILE__). '/includes/functions.php'; ?>
<?php // require_once __DIR__ . '/includes/validation_functions.php'; ?>
<?php //require_once "/includes/session.php"; KAD see if we use session?> 
<?php //confirm_logged_in(); ?>

<?php

	/*1. Connect to the database (see includes/db_connection.php)*/

	/*2. Query db for specific username/password combo*/
	
	if(isset($_POST["username"])){
 		$username = $_POST["username"];
		$password = $_POST["password"]; 
		 
		$query  = "SELECT * ";
		$query .= "FROM users ";
		$query .= "WHERE username = '{$username}' AND password = '{$password}'";
		$result =  pg_query($connection, $query);  

		//echo "{$query}";
		
		/* 3. Set up JSON response */
 		$response = array();
		$response["user"] = "";
		
 	 	if (!$result || pg_num_rows($result) == 0){ 
			// Failure		
			$response["success"] = 0;
			$response["message"] = "Oops! An error occurred: Failed to login.";
			echo json_encode($response);
		}  
		
 		else {
			// Success
			$response["success"] = 1;
			$response["message"] = "Successfully logged in.";
		
			//add user info to the response
			$user = pg_fetch_assoc($result);
			
			$response["user"] = $user;				
				
			//actually outputting JSON response
			echo json_encode($response); 
	
		} 
	 }else{
	echo "access denied";
	} 
	//NOTE: db connection is automatically closed by class destructor
?>
