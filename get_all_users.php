<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>
<?php //require_once dirname(__FILE__). '/includes/functions.php'; ?>
<?php // require_once __DIR__ . '/includes/validation_functions.php'; ?>
<?php //require_once "/includes/session.php"; KAD see if we use session?> 
<?php //confirm_logged_in(); ?>

<?php

	/*1. Connect to the database (see includes/db_connection.php)*/

	/*2. Query db*/
	 
	$query  = "SELECT * ";
	$query .= "FROM users ";
	//$query .= "ORDER BY ? ASC";
	$all_users =  pg_query($connection, $query); 

	/* 3. Set up JSON response */
	$response = array();	
	$response["users"] = array();
	
	if (!$result){ 
		// Failure		
		$response["success"] = 0;
		$response["message"] = "Oops! An error occurred: Failed to read all users.";
		echo json_encode($response);

	} else {
		// Success
		$response["success"] = 1;
		$response["message"] = "Successfully returned all users.";
	
		//add each user to the response
		while($user = pg_fetch_assoc($all_users)) {
			array_push($response["users"], $user);				
		}	
		
		//actually outputting JSON response
		echo json_encode($response);
	}

	//NOTE: db connection is automatically closed by class destructor
?>
