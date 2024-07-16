<?php

	//getting the parts of Api end points
	$uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH) ;
	$uri = explode("/",$uri) ;
	 
	//validates the end points 
	if(($uri[3] == 'user') AND ($uri[4] == 'list')){
		
		//entry point of the application
		require_once  __DIR__ . "/inc/bootstrap.php";
		require_once PROJECT_ROOT_PATH . "/Controller/Api/usercontroller.php";
				
		$objUserCont = new UserController() ;
		$objUserCont->listUsers() ;	
	}else{
		header("not found") ;
		exit ;
	}
?>