<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common_Personal extends Controller_Template {
//    public $template='main';
    public $ajaxAllow =true;

    public function before(){
	parent::before();
	View::bind_global('title',$this->title);
	$root = DOCROOT;
//	View::set_global('head','personal');
//	$this->template->content='';
//	$this->template->navigator='';
//	$this->template->menu='';
//	$this->template->scripts=array('jquery','bootstrap','personal_v4');
//	$this->template->styles=array('bootstrap.min','common_v4','personal_v4');

	$assets = json_decode(file_get_contents($root.'js/public/assets/assets.json'), TRUE);
	$styles = json_decode(file_get_contents($root.'css/css.json'), TRUE);	
	$this->template->styles=array_values($styles);
#	$log = Log::instance();
#	$log->add(Log::INFO , Debug::vars($assets));
	$this->template->scripts = $assets;

	I18n::lang('ru');	
    }
} 
