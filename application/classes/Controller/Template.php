<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Template extends Kohana_Controller_Template {
    public function before(){
//	View::set_global('cart',NULL);
//	$this->template->cart=NULL;
	parent::before();
   /*  if( ! $this->request->is_ajax()) {
		
//		throw new Kohana_Exception('Request is not ajax');
	}
	
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) 
	{   
		// 
		Log::instance()->add(Log::NOTICE, Debug::vars('ok--------'));
//		exit;   
		
	}; */
	
	

//	$this->auto_render = !$this->request->is_ajax();
//	if($this->auto_render === TRUE){
//	    parent::before();
//	}
    }
//    public function action_index(){
///	$this->request->headers('Content-Type','application/json; charset='.Kohana::$charset);
//	$this->responce->body($jsonEncoded);
//    }	

     public function after()
    {
       /*  if($this->is_Ajax and !empty($this->response))
        {
      $this->response->body('');
            $this->request->response()->body('');
            return;
        }
		$this->response->body( json_encode(array('a'=>55)));
		return; */
		
        parent::after();
    }

}
