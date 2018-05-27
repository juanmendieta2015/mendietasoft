<?php

	class Conexion
	{
	    private $servername;
	    private $username;
	    private $password;
	    private $dbname;


       public function __construct($servername, $username, $password, $dbname) 
       { 
            $this->servername 	= $servername;
            $this->username 	= $username;
            $this->password    	= $password;
            $this->dbname 		= $dbname;	
       }  

       public function connect()
       {
		    // Create connection
		    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

		    // Check connection
		    if ($conn->connect_error) {
		        die("Connection failed: " . $conn->connect_error);
		    } 

		    return $conn;
       }

		

	}
?>