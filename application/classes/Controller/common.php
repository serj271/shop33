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
	$this->template->styles=array('bootstrap','common_v1');
//	$this->template->scripts=array('personal_v1');	
    }
} 
