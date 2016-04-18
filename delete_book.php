<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>

<?php

    if(isset($_POST['submit']))
    {
	$bookid = $_POST['bookid'];

	$query = "DELETE FROM books ";
	$query.= "WHERE bookid='{$bookid}'";

	$result = pg_query($connection, $query);

	$response = array();

	if(!$result)
	{
	    $response["success"] = 0;
	    $response["message"] = "Oops! An error occurred while deleting book from the database.";
	}
	else
	{
	    $response["success"] = 1;
	    $response["message"] = "Book successfully deleted.";
	}

	echo json_encode($response);
    }
    else
    {
	echo "Submit not set.";
    }

?>
