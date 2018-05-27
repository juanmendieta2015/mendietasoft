 <?php

 	if ($_SERVER['SERVER_NAME'] == "localhost") {
		define('DB_SERVER', "xxxxx");
		define('DB_USER', "xxxxx");
		define('DB_PASS', "xxxxx");
		define('DB_DATABASE', "xxxxx"); 		
 	} else {
		define('DB_SERVER', "");
		define('DB_USER', "xxxxx");
		define('DB_PASS', "xxxxx!");
		define('DB_DATABASE', "xxxxx"); 		
 	}

	

 ?>