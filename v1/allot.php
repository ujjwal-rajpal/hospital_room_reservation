<?php
/**
 * filename : allot.php
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
	
	if($request_method = 'put'){
			$type=$_REQUEST['type'];
			echo $type;
			die();
		//update quantity
			update_qty($type);
			
	}
	
	function update_qty(){
		global $_db;
		if ($_db->connectionFound()) {
			return json_encode($_db->connectionFound(), 500);
		}
		
			
			$result = $_db->update_qty($type);
			if($result){
			$response=array(
				'status' => 1,
				'status_message' => "updated succesfully"
			);
			
			}
			else{
				
				$response=array(
					'status' => 0,
					'status_message' =>'we encounter error.'
				);
			}
		header('Content-Type: application/json');
		echo json_encode($response);
	}