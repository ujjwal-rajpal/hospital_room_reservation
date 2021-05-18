<?php
define("DB_HOST", "localhost");
  define("DB_USER", "root");
  define("DB_PASSWORD", "");
  define("DB_DATABASE", "room_reservation");
Class DB{
  
	
	
/* Database connection start */
	private static $_instance = null;
    private $error;
	private function __construct()
    { 
    }
	
	/**
     * It create static instance of DB
     *
     * @param
     *
     *
     * @return PDO
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    /**
     * It checks for connection
     *
     * @param
     *
     *
     * @return string or boolean
     */
    public function connectionFound()
    {
			// Create connection
		//$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
		
    }
	/**
     * Function to update users details
     *
     *
     *
    */
    public function room_available($type)
    {
		
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
		if($type == 'Normal Room'){
			//normal room available
			$sql = "SELECT sum(left_qty)as room_available FROM rooms WHERE type = 'Normal Room'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				//output
				$row = $result->fetch_assoc();
				if($row["room_available"] > 0){
					$sql = "SELECT sum(`left_qty`)as bed_available FROM `beds` WHERE `type` = 'Flat Beds'";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						if($row["bed_available"] > 0){
							$sql = "SELECT SUM(`left_qty`) as equipments_available FROM equipments WHERE type='Normal Masks'";
							$result = $conn->query($sql);
							
							$row = $result->fetch_assoc();
							if($row["equipments_available"] > 1){
									return array(
									'room_availability' => 'yes'
								);
							}else{
					return array(
									'room_availability' => 'No'
								);
				}
						}else{
					return array(
									'room_availability' => 'No'
								);
				}
					}else{
					return array(
									'room_availability' => 'No'
								);
				}
					
				}
				else{
					return array(
									'room_availability' => 'No'
								);
				}
				
			}else{
					return array(
									'room_availability' => 'No'
								);
				}
		}
		else if($type == 'Oxygen Rooms'){
		
			$sql = "SELECT sum(left_qty)as room_available FROM rooms WHERE type = 'Oxygen Rooms'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				//output
				$row = $result->fetch_assoc();
				if($row["room_available"] > 0){
					$sql = "SELECT sum(`left_qty`)as bed_available FROM `beds` WHERE `type` = 'Recliner Beds'";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						if($row["bed_available"] > 0){
							$sql = "SELECT type,SUM(left_qty)as equipment_available FROM equipments GROUP BY type HAVING type = 'Non rebreather masks' OR type='Oxygen Cylinder'";
							$result = $conn->query($sql);						
							while($row = $result->fetch_assoc()){
								if($row['type'] == 'Non rebreather masks' & $row['equipment_available'] < 2){
											return array(
									'room_availability' => 'No'
									);
								}
								else if($row['type'] == 'Oxygen Cylinder' & $row['equipment_available'] < 1){
									return array(
									'room_availability' => 'no'
									);
								}
								
							}
							return array(
									'room_availability' => 'Yes'
									);
							
						}else{
					return array(
									'room_availability' => 'No'
								);
				}
					}else{
					return array(
									'room_availability' => 'No'
								);
				}
					
				}
				else{
					return array(
									'room_availability' => 'No'
								);
				}
				
			}else{
					return array(
									'room_availability' => 'No'
								);
				}
		
		}
		
		else if($type == 'ICU'){
		
			$sql = "SELECT sum(left_qty)as room_available FROM rooms WHERE type = 'ICU'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				//output
				$row = $result->fetch_assoc();
				if($row["room_available"] > 0){
					$sql = "SELECT sum(`left_qty`)as bed_available FROM `beds` WHERE `type` = 'Recliner Beds'";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						if($row["bed_available"] > 0){
							$sql = "SELECT type,SUM(left_qty)as equipment_available FROM equipments GROUP BY type HAVING type = 'Ventilator' OR type='Oxygen Cylinder'";
							$result = $conn->query($sql);						
							while($row = $result->fetch_assoc()){
								
								if($row['type'] == 'Ventilator' & $row['equipment_available'] < 1){
											return array(
									'room_availability' => 'No'
									);
								}
								else if($row['type'] == 'Oxygen Cylinder' & $row['equipment_available'] < 1){
									return array(
									'room_availability' => 'no'
									);
								}
								
							}
							return array(
									'room_availability' => 'Yes'
									);
							
						}else{
					return array(
									'room_availability' => 'No'
								);
				}
					}else{
					return array(
									'room_availability' => 'No'
								);
				}
					
				}
				else{
					return array(
									'room_availability' => 'No'
								);
				}
				
			}else{
					return array(
									'room_availability' => 'No'
								);
				}
		
		}
		
		
		
		$conn->close();
	}
}






?>