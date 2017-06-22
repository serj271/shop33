<?php defined('SYSPATH') or die('No direct script access.');

	class Task_Captcha extends Minion_Task
	{
		protected $_options = array(
			'foo' => 'bar',
			'bar' => NULL,
		);

	public function build_validation(Validation $validation)
	{
		return parent::build_validation($validation)
			->rule('foo', 'not_empty') // Require this param
			->rule('bar', 'numeric'); // This param should be numeric
	}
		/**
		 * This is a demo task
		 *
		 * @return null
		 */
		protected function _execute(array $params)
		{
	/* 		var_dump($params);
			echo 'foobar'; */
			$captcha = Captcha::instance('word');			
			
			$new_count = 5;//set new_count
			$invalid = TRUE;
			$new_count = $captcha->valid_count($new_count, $invalid);
			Minion_CLI::write('set new count '.$new_count);
			$new_count = $captcha->valid_count(NULL, $invalid);
			Minion_CLI::write('get count '.$new_count);
//			Log::instance()->add(Log::NOTICE, Debug::vars($new_count));
			
			$new_count = 0;//delete count			
			$new_count = $captcha->valid_count($new_count, $invalid);
			Minion_CLI::write('delete count '.$new_count);
			
			$new_count = 5;//set new_count
			$invalid = FALSE;
			$new_count = $captcha->valid_count($new_count, $invalid);
			Minion_CLI::write('set new invalid count '.$new_count);
			$captcha_image = $captcha->render();
			Minion_CLI::write('get captcha response '.Session::instance()->get('captcha_response'));
//			Log::instance()->add(Log::NOTICE, Debug::vars(Captcha::valid('aa')));
			
			
		}
	}
	
#./minion --task=demo --foo=foobar` 	