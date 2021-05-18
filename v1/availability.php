<?php
/**
 * filename : availability.php
 *
 * purpose : used as controller file accept. It accept the request and send it to connection .php
 *
 * created by : Ujjwal Rajpal
 * 
 * created on : 17/05/2020
 */

error_reporting (E_ALL ^ E_NOTICE);
// Connect to database
	include("../connection.php");
	$_db =DB::getInstance();

	$request_method=$_SERVER["REQUEST_METHOD"];
	
	if($request_method = 'post'){
			$type=$_REQUEST['type'];
			
			//update signature
			room_available($type);
	}
	
	/**
      *
      * Function to check room available or not
      * 
      * @param 
      *
      * @return $response(json)
      *
    */
    function room_available($type)
    {
		global $_db;
		if ($_db->connectionFound()) {
			return json_encode($_db->connectionFound(), 500);
		}
		//if($type == 'Normal Room'){
			
			$result = $_db->room_available($type);
			if($result){
			$response=array(
				'status' => 1,
				'status_message' => $result
			);
			
			}
			else{
				
				$response=array(
					'status' => 0,
					'status_message' =>'No room available.'
				);
			}
		header('Content-Type: application/json');
		echo json_encode($response);
			
		//}	
	}
	