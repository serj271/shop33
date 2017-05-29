<?php defined('SYSPATH') or die('No direct script access.');

	class Task_Demo extends Minion_Task
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
			var_dump($params);
			echo 'foobar';
		}
	}
	
#./minion --task=demo --foo=foobar` 	