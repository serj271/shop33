<?php defined('SYSPATH') or die('No direct script access.');

class Task_Getjsonusers extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);

	private $enterprises = array();
	private $departments = array();
	private $employees = array();
	
	protected function _execute(array $params)
	{				
//		$enterprise_orm = ORM::factory('Employee_Enterprise');			
//		$department_orm = new Model_Employee_Department();			
//		$employee_orm = ORM::factory('Employee');		
		$session = Session::instance();
//		$enterprise_id = $enterprise_orm->find()->id;
//		Log::instance()->add(Log::NOTICE, Debug::vars($enterprise_id));
		$uri = 'http://192.168.1.1/shop33/ajax/useradmin/getusers';
		$uri = trim($uri); 
//		$data = array('id'=>$enterprise_id);	
//		$data = json_encode($data);
//		$data = '{ "id":"2"}';
		$curl = curl_init(); //Starting handle.
		curl_setopt_array($curl, array(
			CURLOPT_URL => $uri,
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
	//		CURLOPT_POSTFIELDS => json_encode($data), //converting $data to JSON.
			CURLOPT_HTTPHEADER => array(
				"accept: application/json",
				"content-type: application/json",
				"X-Requested-With : XMLHttpRequest",
				"Authorization: ".Security::token()),
		));
		$resp = curl_exec($curl);
		if (curl_errno ( $curl )) {
//			echo curl_error ( $curl );
			Log::instance()->add(Log::NOTICE, Debug::vars('---er',curl_error ( $curl )));
			curl_close ( $curl );
			exit ();
		} else{
			$objs = (array)json_decode($resp);//get array of Std class
			foreach ($objs as $obj){
//				Minion_CLI::write('get json --- '.$obj->title);
			}
			Log::instance()->add(Log::NOTICE, Debug::vars('respone -- ',$objs));
		}		
		curl_close($curl);		
//		Log::instance()->add(Log::NOTICE, Debug::vars($obj));










 
 
 
		Minion_CLI::write('get json  end employee  -');
		
	}
	
	
	
	
	
	
	
} // End Welcome
//  ./minion --help --task=createuser