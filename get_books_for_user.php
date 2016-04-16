<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>

<?php

    if(isset($_POST["userid"]))
    {
	$userid = $_POST["userid"];

	$query = "SELECT * FROM books ";
	$query.= "WHERE userid = '{$userid}'";
	$result = pg_query($connection, $query);

	$response = array();
	$response["books"] = array();

	if(!$result)
	{
	    $response["success"] = 0;
	    $response["message"] = "Oops! An error occurred. Failed to get books for the given userid.";

	    echo json_encode($response);
	}
	else
	{
	    $response["success"] = 1;
	    $response["message"] = "Successfully retrieved books for given userid.";

	    while($book = pg_fetch_assoc($result))
	    {
		array_push($response["books"], $book);
	    }

	    echo json_encode($response);
	}
    }
    else
    {
	echo "Invalid paramteres.";
    }

?>
