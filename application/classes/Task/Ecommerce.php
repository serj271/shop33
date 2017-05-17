<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Ecommerce extends Minion_Task {
	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);

	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));
#		Kohana::$log->attach(new Log_File(APPPATH.'logs'));
		set_exception_handler(array('Kohana_Exception_Handler','handle'));

		Kohana::$config->attach(new Config_File);

		$db = Database::instance();
		// Get the table name from the ORM model		
		
//		$catalog_category = ORM::factory('catalog_category');
		
//		foreach($catalog_category->find_all() as $category)
//		{
//		   $category->delete();
//		}
		
//		$catalog_element = ORM::factory('catalog_element');
		
//		foreach($catalog_element->find_all() as $element)
//		{
//		   $element->delete();//
//		$catalog_item = ORM::factory('catalog_item');	
			
		
//		$config = Kohana::$config->load('test/catalog/catalog');
//		Minion_CLI::write($config->get('mode'));
		
		
//		uploadDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
//    copyrightHolder TEXT NOT NULL default '',

		// Create the base table
//			$link = mysql_connect($hostname, $db_user, $db_password);
//			if (!$link) {
//			  die ("MySQL Connection error");
//			}
//			mysql_select_db($database_name, $link) or die ("Wrong MySQL Database");
			// read the sql file
		
		Minion_CLI::write('Create catalog instance');

	}

}







