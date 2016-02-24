<?php

class DB_CONNECT
{
    //constructor: initiates a new PostgreSQL connection
    function __construct()
    {
	$this->connect();
    }

    //destructor: closes any open PostgreSQL connection
    function __destruct()
    {
	$this->close();
    }

    //connects to the database using the parameters specified in the db_config file
    function connect()
    {
	require_once __DIR__ . '/db_config.php';
	$connstring = "host=$DB_SERVER port=$DB_PORT dbname=$DB_DATABASE ".
		      "user='{$_POST[$DB_USER]}' password='{$_POST[$DB_PASSWORD]}'";
	$db = pg_connect($connstring);

	return $db;
    }

    //closes the open database connection. No parameter needs to be passed to pg_close because the method always closes the last open connecion
    function close()
    {
	pg_close();
    }
}

?>
