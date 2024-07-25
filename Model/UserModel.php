<?php
//gets data from databse through another class
//converts data into json format 

require_once PROJECT_ROOT_PATH . "/Model/Database.php";
class UserModel extends Database
{
	//gets all users datails from Database
    public function getAllUsers($limit)
    {
		
		$types =[] ;
		$data =[] ;
		$types =["i"] ;
		$data =[$limit] ;
		$sql = "select user_id,username,user_email,user_status from users  order by user_id limit ? " ;
		$ret = $this->select($sql,$types,$data) ;
		//$ret = $this->select($sql) ;
		
		$jsonEncodedData = json_encode([]) ;
		
		$data = [] ;
		if ($ret[0]){
			if($ret[1]->num_rows > 0){
				
				$cnt = 0 ;
				/*
				$rows = $ret[1]->fetch_all(MYSQLI_ASSOC) ;
				foreach($rows as $row){
					$dataRow = [] ;
					foreach($row as $key => $val){
						$dataRow[$key] =  $val ;
						
					}
					$data[$cnt] = $dataRow ;
					++$cnt ;
				}*/
					
				while($row = $ret[1]->fetch_assoc()){
					$data[$cnt] = array("id" =>  $row["user_id"],"name" =>  $row["username"],"email" =>  $row["user_email"],"status" => $row["user_status"]) ;
					++$cnt ;
				}
				$jsonEncodedData = json_encode($data);
				return $jsonEncodedData ;
				
			}
		}	
	}
}

?>