<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Basket_Main extends Controller_Admin{
	protected $_model='Product';
	public function action_index_()
	{rr
		$this->response->body('ok');
//		$this->template->content=$this->view;		
	}

}
