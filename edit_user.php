<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>
<?php //require_once dirname(__FILE__). '/includes/functions.php'; ?>
<?php // require_once __DIR__ . '/includes/validation_functions.php'; ?>
<?php //require_once "/includes/session.php"; KAD see if we use session?> 
<?php //confirm_logged_in(); ?>

<?php

/*1. Connect to the database (see includes/db_connection.php)*/

/*2. Get user to edit*/

if (isset($_POST['submit'])) { 

	// Parse POST data
	$name = $_POST["name"];
	$username = $_POST["username"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$phone = $_POST["phone"];
	$zip = $_POST["zipcode"];
	
	/* 2b KAD TODO validate fields

	/*3. Query db*/
	
	 $query  = "INSERT INTO users";
	 $query .= "(  username, password, name, email, phone, zipcode";  
	 $query .= ") VALUES (";   
	 $query .= "'{$username}', '{$password}', '{$name}', '{$email}', '{$phone}', '{$zip}' )";
	 
    $result =  pg_query($connection, $query); 

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
	// This is probably a POST request
	// KAD TODO handle this redirect_to("new_subject.php");
	echo "submit not set";//KAD test
}

//NOTE: db connection is automatically closed by class destructor

?>
