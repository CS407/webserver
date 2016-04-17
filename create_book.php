<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>

<?php
    
    //if(isset($_POST['submit']))
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
	$title = $_POST["title"];
	$authors = $_POST["authors"];
	$isbn = $_POST["isbn"];
	$condition = $_POST["condition"];
	$comments = $_POST["comments"];
	$dept = $_POST["department"];
	$courseno = $_POST["courseno"];
	$edition = $_POST["edition"];
	$price = $_POST["price"];
	$userid = $_POST["userid"];
	
	$query = "INSERT INTO books";
	$query.= "( title, authors, isbn, condition, comments, department, courseno, edition, price, userid";
	$query.= ") VALUES (";
	$query.= "'{$title}', '{$authors}', '{$isbn}', '{$condition}', '{$comments}', '{$dept}', '{$courseno}', {$edition}, {$price}, '{$userid}' )";

	$result = pg_query($connection, $query);
	$response = array();

	if(!$result)
	{
	    $response["success"] = 0;
	    $response["message"] = "Oops! An error occurred.";

	    echo json_encode($response);
	}
	else
	{
	    $response["success"] = 1;
	    $response["message"] = "Book successfully added.";

	    $sel_query = "SELECT * FROM books where isbn=";
	    $sel_query.= "'{$isbn}'";

	    $sel_result = pg_query($connection, $sel_query);

	    $book = pg_fetch_assoc($sel_result);
	    $response["books"] = $book;

	    echo json_encode($response);
	}
    }
    else
    {
	echo "Submit not set.";
    }

?>
