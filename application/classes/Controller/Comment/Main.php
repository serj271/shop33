<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Comment_Main extends Controller_Comment {
    public $template ='main';
	protected $model = 'Comment';

//    public $menu = 'menu.useradmin';
//    public $navigator ='useradmnin';
    public function action_index(){
		if (!Auth::instance()->logged_in('login')){
		
//			$this->redirect('user/auth/login');
		}
//		$user = Auth::instance()->get_user();
//		$this->view->username = $user->username;
//		$this->template->content = Message::display();
//    Log::instance()->add(Log::NOTICE, Route::url('admin'));
//    $this->request->redirect('admin/news');
		$comment = Sprig::factory($this->model);
//		Log::instance()->add(Log::NOTICE, Debug::vars($comment));
		$legend = 'form action';
		
		if ($this->request->method() === Request::POST)
		{
			$validation = Validation::factory($this->request->post())
				->rule('token','not_empty')
				->rule('name','not_empty')
				->rule('token','Security::check');
				
			try{
				$validation->check();
				throw new Sprig_Exception( 'comment', $validation,'valid error');
				
			}catch(Sprig_Exception $e){
				Log::instance()->add(Log::NOTICE, Debug::vars('valid error',$e->errors('comment')));	
				
			}	
			
			$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),					
				)));
			/* 	
			try
			{
				$item->values($this->request->post());
				$code = md5(uniqid(rand(),true));
				$code = substr($code,0,64);	    
				$item->one_password = $code;		
				$item->create($validation);
					
				$this->redirect($this->request->route()->uri(array(
					'controller' 	=> $this->request->controller(),					
				)));
			}
			catch (ORM_Validation_Exception $e)
			{
				Log::instance()->add(Log::NOTICE, Debug::vars($e->errors()));
//				$this->view->errors = $e->errors();
			} */
		}	
		
		
		
		$form = View::factory('comment/form')
			->bind('legend', $legend)
			->set('submit', __('Create'))
			->set('comment', $comment);
		$this->view_content = $form;

//    $this->response->body('admin');
//		$login = View::factory('user/menulogout');
//		$this->template->menu=$login;
    }
} // End 
