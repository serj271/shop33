<?php defined('SYSPATH') or die('No direct script access.');

class View_Test_Index {


	public function name(){
		return 'Tater';
	}
	
	public function wrapped(){
		return function($text) {
			return "<b>" . $text . "</b>";
		};
	}
	
	public function embiggened(){
		return function($text, Mustache_LambdaHelper $helper) {
			return strtoupper($helper->render($text));
		};		
	}

	public function colors(){
		return array('red', 'blue', 'green');
	}
	
}
