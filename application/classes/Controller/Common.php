<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common extends Controller_Template {
//    public $template='main';
    public $ajaxAllow =true;

    public function before(){
	parent::before();
	View::set_global('title','shop-element');
	View::set_global('head','shop-element');
	$this->template->content='';
	$this->template->navigator='';
	$this->template->cart= NULL;
	$this->template->menu= '';
	$this->template->styles=array();
	$this->template->scripts=array();	
	$lang = Lang::instance()->get();
	if($lang == 'ru'){
	    I18n::lang('ru');	
	} else {
	    I18n::lang('en-us');		
	}
    }
} 
