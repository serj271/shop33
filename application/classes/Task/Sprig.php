<?php defined('SYSPATH') or die('No direct script access.');

class Task_Sprig extends Minion_Task {

	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
		'role' => '',
		'username' => 'test'
	);
	
	
	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));

		
		
		$this->setUpBeforeClass();
		
		Minion_CLI::write('sprig ');
		
		
	}

	public function setUpBeforeClass()
	{
		
		$queries = array(
			'DROP TABLE IF EXISTS `test_users`;',
			'DROP TABLE IF EXISTS `test_names`;',
			'DROP TABLE IF EXISTS `test_tags`;',
			'DROP TABLE IF EXISTS `test_tags_test_users` ;',
			
			'CREATE TABLE `test_users` (
				`id` INT PRIMARY KEY AUTO_INCREMENT,
				`title` VARCHAR(20),
				`year` INT,
				`joined` INT,
				`last_online` INT,
				`last_breathed` TIMESTAMP
			)',
			'CREATE TABLE `test_names` (
				`test_user_id` INT PRIMARY KEY AUTO_INCREMENT,
				`name` VARCHAR(20)
			)',
			'CREATE TABLE `test_tags` (
				`id` INT PRIMARY KEY AUTO_INCREMENT,
				`name` VARCHAR(20)
			)',
			'CREATE TABLE `test_tags_test_users` (
				`test_user_id` INT,
				`test_tag_id` INT
			)',
			
			"INSERT INTO `test_users` VALUES
				(1, 'Mr' , 1991, 1, 10, FROM_UNIXTIME(10)),
				(2, 'Mrs', 1992, 3, 12, FROM_UNIXTIME(12)),
				(3, 'Dr' , 1993, 5, 15, FROM_UNIXTIME(15)),
				(4, 'Ms' , 1994, 5, 15, FROM_UNIXTIME(20))",
			"INSERT INTO `test_names` VALUES (1, 'one'), (2, 'two'), (3, 'three')",
			"INSERT INTO `test_tags`  VALUES (1, 'abc'), (2, 'def'), (3, 'ghi'), (9, '01234')",
			'INSERT INTO `test_tags_test_users` VALUES (1,1), (2,2), (3,3), (1,2), (1,3), (2,1), (2,3)',
		);
		
		$db = Database::instance();
		$db->connect();
		
	/* 	$query = 'CREATE TABLE `test_tags_test_users` (
				`test_user_id` INT,
				`test_tag_id` INT
			)';		
		DB::query(NULL, $query)->execute();
		 */
		foreach ($queries as $query) {
			$result = DB::query(NULL, $query)
			->execute();
			if ($result === FALSE)
				throw new Exception(mysql_error());
		}
	}
	
	
	
} // End Welcome
//  ./minion --help --task=sprig --username=