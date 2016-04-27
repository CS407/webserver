<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>

<?php

    if(isset($_POST["bookid"]))
    {
	$bookid = $_POST["bookid"];

	$query = "SELECT users.* FROM ";
	$query.= "(SELECT userid FROM buyers WHERE bookid = '{$bookid}') ";
	$query.= "AS B JOIN users ON B.userid = users.userid";

	$result = pg_query($connection, $query);
	$response = array();
	$response["users"] = array();

	if(!$result)
	{
	    $response["success"] = 0;
	    $response["message"] = "Oops! Failed to get buyers for provided bookid.";
	}
	else
	{
	    $response["success"] = 1;
	    $response["message"] = "Successfully retrieved buyers for given bookid.";

	    while($user = pg_fetch_assoc($result))
	    {
		array_push($response["users"], $user);
	    }
	}

	echo json_encode($response);
    }
    else
    {
	echo "No bookid provided.";
    }

?>
