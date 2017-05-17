<?php defined('SYSPATH') or die('No direct script access.');

class Task_Authuser extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);
	protected function getUsers(){
		$model = new Model_User();
		$users = $model->getUsers();
//			$users = $users_model
//			->find_all()
//			->as_array($model->primary_key(), $this->_find_name_column($remote_model));
	    return $users;    
	}
	protected function getAuth()
	{
		$success = Auth::instance()->login('test','1', TRUE);
		if($success){
			return 'ok'; 
		} else {
			return 'fail';
		}		
	}
	
	protected function _execute(array $params)
	{
		$users = implode(',',$this->getUsers());
		$success = $this->getAuth();
		Minion_CLI::write('users '.'__'.$users.'--auth--'.$success);
		if(Auth::instance()->logged_in()){
			Minion_CLI::write('user loged in');			
		} else {
			Minion_CLI::write('user NOT oged in');
		}
		$user = Auth::instance()->get_user();
		if($user !== null){
			Minion_CLI::write('user is found '.$user->username);			
		} else {
			Minion_CLI::write('user NOT found');
		}
		
		Minion_CLI::write('password for test user '.Auth::instance()->password('test'));	
		if(Auth::instance()->check_password('1')){			
			Minion_CLI::write('check password for test user ok');
		} else {
			Minion_CLI::write('check not password for test user');			
		}
		
		
		Minion_CLI::write('user logout now!');
		$user = Auth::instance()->logout();
		$user = Auth::instance()->get_user();
		if($user !== null){
			Minion_CLI::write('user is found '.$user->username);			
		} else {
			Minion_CLI::write('user NOT found');
		}
	}

} // End Welcome
//  ./minion --help --task=authtest