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
		
		protected function select($sql) {
			if($result = $this->conn->query($sql)){
				return array(true,$result);	
			}else{
				return array(false,$this->conn->error) ;
			}
		}
	
		public function __destruct() {
			$this->conn = null;
		}
	}
?>