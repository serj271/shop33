<?php defined('SYSPATH') or die('No direct script access.');
/** 
 * Login view model
 */
class View_User_Auth_Join {
	
	/**
	 * @var	array
	 */
	public $errors;

	/**
	 * @var	array
	 */
	public $values = array();

	/**
	 * @return	array	Values with CSRF token included
	 */
	public function values()
	{
		return array('token' => Security::token()) + $this->values;
	}
//	public function action()
//	{
//		return $this->request->controller()
//	}	
	public function labelUsername(){
	    return 'Username';
	
	}

	public function labelEmail(){
	    return 'Email';
	
	}


	public function labelPassword(){
	    return 'Password';
	
	}

	public function labelSubmit(){
	    return 'Join';
	
	}

	public function confirm(){
//	    return Arr::path($values, '_external.password_confirm');
	}

	public function passwordConfirm(){
	    return Arr::path($this->errors, '_external.password_confirm');	
	}

}
