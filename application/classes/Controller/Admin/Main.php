<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Main extends Controller_Admin_Crud{
	protected $_model='Product';
	public function action_index_()
	{
		$this->response->body('ok');
//		$this->template->content=$this->view;		
	}

}
