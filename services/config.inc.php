 <?php

 	if ($_SERVER['SERVER_NAME'] == "localhost") {
		define('DB_SERVER', "localhost");
		define('DB_USER', "root");
		define('DB_PASS', "");
		define('DB_DATABASE', "mendietaweb"); 		
 	} else {
		define('DB_SERVER', "");
		define('DB_USER', "mendietaweb_ingles");
		define('DB_PASS', "Sara2018!");
		define('DB_DATABASE', "mendietaweb_ingles"); 		
 	}

	

 ?>