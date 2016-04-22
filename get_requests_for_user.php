<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>

<?php
    
    if(isset($_POST["userid"]))
    {
	$userid = $_POST["userid"];

	$query = "SELECT books.* FROM ";
	$query.= "(SELECT * FROM buyers WHERE buyers.userid = {$userid}) as Q ";
	$query.= "INNER JOIN books ON books.bookid = Q.bookid";

	$result = pg_query($connection, $query);

	$response = array();
	$response["books"] = array();

	if(!$result)
	{
	    $response["success"] = 0;
	    $response["message"] = "Oops! An error occurred. Failed getting pending requests for given userid.";
	}
	else
	{
	    $response["success"] = 1;
	    $response["message"] = "Successfully retrieved pending requests for given userid.";

	    while($book = pg_fetch_assoc($result))
	    {
		array_push($response["books"], $book);
	    }
	}

	echo json_encode($response);
    }
    else
    {
	echo "Invalid parameters";
    }

?>
