<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>
<?php //require_once dirname(__FILE__). '/includes/functions.php'; ?>
<?php // require_once __DIR__ . '/includes/validation_functions.php'; ?>
<?php //require_once "/includes/session.php"; KAD see if we use session?> 
<?php //confirm_logged_in(); ?>

<?php
/*
Given any combination of title, isbn, and department, return all books that match
*/

	//JSON response
	$response = array();	
	$response["books"] = array();

	/*1. Connect to the database (see includes/db_connection.php)*/

	/*2. Parse parameters*/
	//if(isset($_POST['isbn']) || isset($_POST['title']) || isset($_POST['department'])){
	
	/*3. Query db*/
	
	$query  = "SELECT * ";
	$query .= "FROM books; ";
	
	//if given isbn, just use that (it's unique)
	if(isset($_POST['isbn'])){
	$isbn = $_POST['isbn'];
	$query .= "WHERE isbn = '{$isbn}' ";
	}
	
	//$query .= "ORDER BY title ASC";
		
	$books_returned =  pg_query($connection, $query); 

	/* 3. Set up JSON response */
	
	if (!$books_returned){ 
		// Failure		
		$response["success"] = 0;
		$response["message"] = "Oops! An error occurred: Failed to read all books.";
		echo json_encode($response);

	} else {
		// Success
		$response["success"] = 1;
		$response["message"] = "Successfully returned matching books.";
	
		//add each user to the response
		while($book = pg_fetch_assoc($books_returned)) {
			array_push($response["books"], $book);				
		}	
		
		//actually outputting JSON response
		echo json_encode($response);
	}
	


	//NOTE: db connection is automatically closed by class destructor
?>