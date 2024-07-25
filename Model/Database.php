<?php
//interacts with database
	class Database{
				
		private $conn ;
		
		public function __construct(){
			try {
				$this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
				if ( mysqli_connect_errno()) {
					throw new Exception("Could not connect to database.");   
				}
			} catch (Exception $e) {
				throw new Exception($e->getMessage());   
			}
		}
		
		function build_bind_params($types, $values) {

		// THEN I CREATE AN EMPTY ARRAY TO STORE THE FINAL OUTPUT
			$bind_array = array();

		// THEN I CREATE A TEMPORARY EMPTY ARRAY TO GROUP THE TYPES; THIS IS NECESSARY BECAUSE THE FINAL ARRAY ALL THE TYPES MUST BE A STRING WITH NO SPACES IN THE FIRST KEY OF THE ARRAY
			
			$i = array();
			foreach ($types as $type) {
				$i[] = $type;
			}
		// SO I IMPLODE THE TYPES ARRAY TO REMOVE COMMAS AND ADD IT AS KEY[0] IN THE BIND ARRAY
			$bind_array[] = implode('', $i);

		// FINALLY I LOOP THROUGH THE VALUES AND ADD THOSE AS SUBSEQUENT KEYS IN THE BIND ARRAY
			foreach($values as $value) {
				$bind_array[] = $value;
			}
			return $bind_array;
		}
		
		protected function select($sql,$types = [],$data = []) {
			
			if($stmt = $this->conn->prepare($sql)){
				if(!empty($types)){
					$params = $this->build_bind_params($types, $data);
					
					// PROPERLY SETUP THE PARAMS FOR BINDING WITH CALL_USER_FUNC_ARRAY
					$tmp = array();
					foreach ($params as $key => $value) $tmp[$key] = &$params[$key];

					// PROPERLY BIND ARRAY TO THE STATEMENT
					call_user_func_array(array($stmt , 'bind_param') , $tmp);
				}
				
				//$stmt->bind_param($types, $data);
				$stmt->execute() ;
				$result = $stmt->get_result(); //gets mysqli result from a mysqli statement.
											   // not possible to fetch the result set directly from 
											   //mysqli statement.
				
				return array(true,$result);	
				
			}else{
				return array(false, $this->conn->error);	
			}
			$stmt->close();
			
			
		}
			
		public function __destruct() {
			$this->conn = null;
		}
	}
?>