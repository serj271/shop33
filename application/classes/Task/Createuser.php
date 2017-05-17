<?php defined('SYSPATH') or die('No direct script access.');

class Task_Createuser extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'user'   => 'test',
		'password'=>'1',
	);

	protected function _execute(array $params)
	{
		$user = ORM::factory('User',array('username'=>$params['user']));		
		$id = $user->id;
		if($user->loaded()){				
			Minion_CLI::write('user exists id -'.$id);
			$user->delete();
			Minion_CLI::write('user delete id -'.$id);
		} 
		try{
			$user = ORM::factory('User');					
					$user->username = $params['user'];
					$user->email = 'u0010345@mrsk-ural.ru';
					$user->password = $params['password'];	
					$code = md5(uniqid(rand(),true));
					$code = substr($code,0,64);	    
					$user->one_password = $code;
					$user->save();					
			$user->add('roles', ORM::factory('Role', array('name' => 'login')));
			$user->add('roles', ORM::factory('Role', array('name' => 'admin')));
	###		$users = implode(',',$this->getUsers());
	//		$success = $this->getAuth();
	
			Minion_CLI::write('create '.$params['user'].' id --'.$user->id);	
		}catch (ORM_Validation_Exception $e)
		{
//			Minion_CLI::write(Kohana::message('product_variation', 'Validation::lt'));
//			$errors = $extra_validation->errors('validation_', TRUE)	;	
			$errors = $e->errors();		
			foreach($errors as $key=>$value){
				Log::instance()->add(Log::NOTICE, Debug::vars($value));//+ field				
			}
			Minion_CLI::write($errors);		
			Log::instance()->add(Log::NOTICE, Debug::vars($e));//+ field			
		}


			

	}
} // End Welcome
//  ./minion --help --task=createuser --user=___  --password=___