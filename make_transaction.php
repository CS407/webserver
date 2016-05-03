<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>

<?php

    if(isset($_POST["bookid"]) && isset($_POST["userid"]) && isset($_POST["email"]) && isset($_POST["phone"]))
    {
	$bookid = $_POST["bookid"];
	$userid = $_POST["userid"];
	$phone = $_POST["phone"];
	$email = $_POST["email"];

	$query = "DELETE FROM buyers ";
	$query.= "WHERE bookid='{$bookid}'";

	$response = array();
	$result = pg_query($connection, $query);
	if($result)
	{
	    $query = "SELECT * FROM books ";
	    $query.= "WHERE bookid='{$bookid}'";

	    $result = pg_query($connection, $query);

	    if(!$result || pg_num_rows($result) != 1)
	    {
		$response["success"] = 0;
		$response["message"] = "Oops! An error occurred while reading from books table for transaction.";
	    }
	    else
	    {
		$book = pg_fetch_assoc($result);
		$buyerdata = "title:" . $book["title"] . ",authors:" . $book["authors"] . ",price:" . $book["price"] . ",email:" . $email . ",phone:" . $phone;

		$subquery = "SELECT email, phone FROM users ";
		$subquery.= "WHERE userid='{$userid}'";
		$subresult = pg_query($connection, $subquery);
		$user = pg_fetch_assoc($subresult);
		$sellerdata = "title:" . $book["title"] . ",name:" . $user["name"] . ",price:" . $book["price"] . ",email:" . $user["email"] . ",phone:" . $user["phone"];

		$query = "INSERT INTO notifs";
		$query.= "(userid, notifdata) VALUES (";
		$query.= "'{$userid}', '{$buyerdata}'), (";
		$query.= "'{$book["userid"]}', '{$sellerdata}')";
		    
		$result = pg_query($connection, $query);

		if(!$result)
		{
		    $response["success"] = 0;
		    $response["message"] = "Oops! An error occurred while inserting into notifs table for transaction.";
		}
		else
		{
		    $query = "DELETE FROM books ";
		    $query.= "WHERE bookid='{$bookid}'";
		    
		    $result = pg_query($connection, $query);

		    if(!$result)
		    {
			$response["success"] = 0;
			$response["message"] = "Oops! An error occurred while deleting from books table for transaction.";
		    }
		    else
		    {
			$response["success"] = 1;
			$response["message"] = "Transaction successfully created.";
		    }
		}
	    }
	}
	else
	{
	    $response["success"] = 0;
	    $response["message"] = "Oops! An error occurred while deleting from buyers table for transaction.";
	}

	echo json_encode($response);
    }
    else
    {
	echo "bookid and userid not set.";
    }

?>
