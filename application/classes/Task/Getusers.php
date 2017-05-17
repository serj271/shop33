<?php defined('SYSPATH') or die('No direct script access.');

class Task_Getusers extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
		'role' => '',
		'username' => 'test'
	);
	
	
	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));
#		Kohana::$log->attach(new Log_File(APPPATH.'logs'));
#		set_exception_handler(array('Kohana_Exception_Handler','handle'));
		$user = ORM::factory('User');
		$user = $user->where('username', '=', $params['username']);
		$user->reset(FALSE); 
		$total = $user->count_all();
		$users = $user->find_all();
		
		Minion_CLI::write('get users total '.$total);
		foreach($users as $user){
			Minion_CLI::write('user '.$user->username);
			if($user->has('roles', ORM::factory('Role', array('name' => 'login')))){
				Minion_CLI::write('user '.$user->username.' has role login');
				
			}
			$user_roles = array();
            foreach ( $user->roles->select('name')->find_all() as $role )
            {
                $user_roles[$role->name] = true;
            }
	
			Log::instance()->add(Log::NOTICE, Debug::vars($user_roles));
		}
		
	}

} // End Welcome
//  ./minion --help --task=getusers --username=