<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>

<?php

    if(isset($_POST["userid"]))
    {
	$userid = $_POST["userid"];

	$query = "SELECT * FROM notifs ";
	$query.= "WHERE userid = '{$userid}'";

	$result = pg_query($connection, $query);
	$response = array();

	if(!$result)
	{
	    $response["success"] = 0;
	    $response["message"] = "Oops! An error occurred while retrieving notifications for given user.";
	}
	else
	{
	    $response["contacts"] = array();

	    $response["success"] = 1;
	    $response["message"] = "Successfully retrieved notifications for given user.";

	    while($contact = pg_fetch_assoc($result))
	    {
		array_push($response["contacts"], $contact);
	    }
	}

	echo json_encode($response);
    }
    else
    {
	echo "userid not set.";
    }

?>
