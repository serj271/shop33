<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax_Useradmin_Getusers extends Controller {
    public $template='ajax';
    public function action_index() 
	{	
		$json_data=array('a'=>2);
		
		$this->response->headers('Content-type','application/json;charset=UTF-8');
		$this->response->body(json_encode($json_data));
		    



    }

} // End 
