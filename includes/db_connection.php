<?php require_once dirname(__FILE__). '/db_connect.php';?>
<?php
/*include db connect class */
// connecting to db:
$connection = new DB_CONNECT(); 
//make this global so we can use it in included function files

//KAD REMOVE
//if(!$connection) echo "Error connecting to database";
//else echo "db connection: success!"
?>