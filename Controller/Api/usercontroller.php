<?php
//holds business logic
class UserController extends BaseController
{

    public function listUsers()
    {
        $strErrorDesc = "" ;
		$limit = 10 ;
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $list = [] ;
        if (strtoupper($requestMethod) == 'GET') {
            try {
				//gets querystring params
				$queryParams = $this->getQueryParams() ;
				if (isset($queryParams['limit']) && $queryParams['limit']){
					$limit = $queryParams['limit'] ;
				}
				//instantiate Model class
				$userModel = new UserModel();
				//gets users list in jason encoded format
				$list = $userModel->getAllUsers($limit);
				$strHeader = 'HTTP/200 OK';
				
				
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strHeader = 'HTTP/1.1 422 Unprocessable Entity';
			
        }
		
		if($strErrorDesc !== ""){
			
			
		}else {
			//sends output to client application
			$this->sendOutput($list,["Content-Type:application/json","OK"]);
		}
		/*if($strErrorDesc == ""){
			echo $list ; 
			//$this->sendOutput($list,["Content-Type:application/json","OK"]);
		}*/
        
        
    }
}
?>