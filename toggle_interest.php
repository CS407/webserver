<?php require_once dirname(__FILE__). '/includes/db_connection.php'; ?>

<?php
    
	/* @author Katie Dudenas
	 *
	 * Called when a user clicks the "mark interested" button for a book.
	 * If a user was already interested in buying, mark uninterested; 
	 * else mark interest (aka create row in buyers table)
	 */
	
    if(!empty($_POST['userid']) && !empty($_POST['bookid']))
    {
		$userid = $_POST['userid'];
		$bookid = $_POST['bookid'];

		//See if there's a row in the buyers table already
		$query = "SELECT * FROM buyers where userid={$userid} AND bookid={$bookid};";
		
		$result = pg_query($connection, $query);

		$response = array();
		
		if(!$result)
		{
			$response["success"] = 0;
			$response["message"] = "Oops! An error occurred. Failed to toggle interest.";
		}
		else
		{
			if(pg_num_rows($result) == 0)
			{ // mark interested
				$query = "INSERT INTO buyers(bookid, userid) VALUES({$bookid},{$userid});";
			
				$result = pg_query($connection, $query);
				if($result){			
					$response["success"] = 1;
					$response['interest'] = 1;
					$response['userid'] = $userid;
					$response['bookid'] = $bookid;
					$response["message"] = "Successfully marked user {$userid} interested in book {$bookid}";	
				}
				else{
					$response["success"] = 0;
					$response["message"] = "Couldn't mark user {$userid} interested in book {$bookid}";	
				}
			}
			else
			{ //mark uninterested
				$query = "DELETE FROM buyers WHERE userid={$userid} AND  bookid={$bookid};";
				$result = pg_query($connection, $query);
				
				if($result){			
					$response["success"] = 1;
					$response['userid'] = $userid;
					$response['bookid'] = $bookid;
					$response['interest'] = 0;
					$response["message"] = "Successfully marked user {$userid} NOT interested in book {$bookid}";	
				}
				else{
					$response["success"] = 0;
					$response["message"] = "Couldn't mark user {$userid} NOT interested in book {$bookid}";	
				}
			}
		}
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "Oops! An error occurred. Invalid parameters";
    }
	echo json_encode($response);
?>
