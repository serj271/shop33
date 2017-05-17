<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Error extends Controller_Common_Error {
    public $template='error';
	public function before(){
	    parent::before();	    
//	    Log::instance()->add(Log::NOTICE, 'templ');
	    $status = (int) $this->request->action();
//	    $this->template = View::factory('error/'.$status);
	if (Request::$initial !== Request::$current){
	    
//            $message = rawurldecode($this->request->param('message'));
                    
//            if ($message)
//            {
//                $this->template->message = $message;
//            }
        }
        else
        {
            $this->request->action(404);
        }
        $this->response->status($status);
//
//	$this->response->body('error');    
	
	
	} 

	public function action_404(){
	    $this->request->status=404;
	    $this->request->response->body('error 404');
//	    $content = View::factory('error/404');
//		    Log::instance()->add(Log::NOTICE, $content);

//	    $this->template->title = 'Not found';	

//	    $navigator=View::factory('/error/navigator');
//		->set('message',$message);
//	    $this->template->navigator=$navigator;
//	    $menu = View::factory('/error/menu');
//	    $this->template->content = $content;
	    
	}
	public function action_503(){
	    
	
	
	}
	public function action_500(){
	
		
	
	}	

} // End 
