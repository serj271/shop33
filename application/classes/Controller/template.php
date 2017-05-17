<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Template extends Kohana_Controller_Template {
    public function before(){
	$this->auto_render = !$this->request->is_ajax();
	if($this->auto_render === TRUE){
	    parent::before();
	}
    }
    public function action_index(){
//	$this->request->headers('Content-Type','application/json; charset='.Kohana::$charset);
//	$this->responce->body($jsonEncoded);
    }	

}
