<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Comment extends Controller_Admin_Crud{
	protected $_model='Comment';
//	public $menu = 'menu.useradmin';

	public function action_index(){
		if (!Auth::instance()->logged_in('login')){
		
//			$this->redirect('user/auth/login');
		}
//		$user = Auth::instance()->get_user();
//		$this->view->username = $user->username;
//		$this->template->content = Message::display();
//    Log::instance()->add(Log::NOTICE, Route::url('admin'));
//    $this->request->redirect('admin/news');
//    $this->response->body('admin');
		$login = View::factory('user/menulogout');
		$this->template->menu=$login;
    }
/* 
	public function action_read()
	{
		$user = ORM::factory($this->_model, $this->request->param('id'));
		
		if ( ! $user->loaded())
		{
//			throw new HTTP_Exception_404(':model with ID :id doesn`t exist!',
//				array(':model' => $this->_model, ':id' => $this->request->param('id')));

			$lang = Lang::instance()->get();
			if($lang == 'ru'){
				I18n::lang('ru');	
			} else {
				I18n::lang('en-us');		
			}
		    Message::error(__(':model with ID :id not exist!',
				array(':model' => $this->_model, ':id' => $this->request->param('id'))));
//		$this->view_navigator->message = __(':model with ID :id not exist!',
//				array(':model' => $this->_model, ':id' => $this->request->param('id')));
			$this->redirect($this->request->route()->uri(array(
					'directory'		=> $this->request->directory(),
					'controller' 	=> $this->request->controller(),					
				)));
		}		


            $user_roles = array();
            foreach ( $user->roles->select('name')->find_all() as $role )
            {
                $user_roles[$role->name] = true;
            }
//			if ( ! Auth::instance()->logged_in('admin') AND $this->request->action !== 'login')  
//		Log::instance()->add(Log::NOTICE,Debug::vars($user_roles));

		$this->view->user_roles = $user_roles;



		$this->view->item = $user;
		$this->view_navigator->message = __(':model with ID :id',
				array(':model' => $this->_model, ':id' => $this->request->param('id')));
	} */
}
