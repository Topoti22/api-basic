<?php
//gets data from databse through another class
//converts data into json format 

require_once PROJECT_ROOT_PATH . "/Model/Database.php";
class UserModel extends Database
{
	//gets all users datails from Database
    public function getAllUsers($limit)
    {
		
		$sql = "select user_id,username,user_email,user_status from users order by user_id limit {$limit} " ;
		$ret = $this->select($sql) ;
		
		$jsonEncodedData = json_encode([]) ;
		
		$data = [] ;
		if ($ret[0]){
			if($ret[1]->num_rows > 0){
				$cnt = 0 ;
				while($row = $ret[1]->fetch_array()){
					//$dataRow = [] ;
					//$r = 0 ;
					//foreach($row as $key => $val){
					//	$dataRow[$r] = $key => $val ;
					//	$r++ ;
					//}
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