<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>
<?php //require_once dirname(__FILE__). '/includes/functions.php'; ?>
<?php // require_once __DIR__ . '/includes/validation_functions.php'; ?>
<?php //require_once "/includes/session.php"; KAD see if we use session?> 
<?php //confirm_logged_in(); ?>

<?php

/*1. Connect to the database (see includes/db_connection.php)*/

/*2. Process form*/

if (isset($_GET['submit'])) { 

	//TODO replace GET with POST
	$name = $_GET["name"];
	$username = $_GET["username"];
	$email = $_GET["email"];
	$password = $_GET["password"];
	$phone = $_GET["phone"];
	$zip = $_GET["zip"];
	
	/* 2b KAD TODO validate fields

	/*3. Query db*/
	
	 $query  = "INSERT INTO users";
	 $query .= "(  username, password, name, email, phone, zipcode";  
	 $query .= ") VALUES (";   
	 $query .= "'{$username}', '{$password}', '{$name}', '{$email}', '{$phone}', '{$zip}' )";

	// echo "Query: {$query}";//KAD test 
	 
	$result =  pg_query($connection, $query); //TODO this is not working
		
	/*
	$queryResult =  pg_send_query($connection, $query);
	$result = pg_get_result($connection);
	if(!$connection){echo "connection is bad!!";}

	echo "Result: "; echo var_dump($result);

	if(!$result){
	echo "Error:"; 
	echo " 0. "; echo pg_result_error_field($queryResult);
	echo " 1. "; echo pg_result_error_field($result);
	echo " 2. "; echo pg_last_error($connection);
	}
	*/

	/* 4. Set up JSON response */
	$response = array();


	if (!$result){ 
	// Failure
		//$_SESSION["message"] = "Subject creation failed.";
		
		$response["success"] = 0;
		$response["message"] = "Oops! An error occurred.";
        echo json_encode($response);
 
	} else {
		
		// Success
		//$_SESSION["message"] = "Subject created.";

		$response["success"] = 1;
        $response["message"] = "User successfully created.";

		//actually outputting JSON response
        echo json_encode($response);
	}
	
	
} else {
	// This is probably a GET request
	// KAD TODO handle this redirect_to("new_subject.php");
	echo "submit not set";//KAD test
}

//NOTE: db connection is automatically closed by class destructor

?>