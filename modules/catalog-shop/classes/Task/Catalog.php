<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Catalog extends Minion_Task {
	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);

	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));
#		Kohana::$log->attach(new Log_File(APPPATH.'logs'));
#		set_exception_handler(array('Kohana_Exception_Handler','handle'));

		Kohana::$config->attach(new Config_File);

		$db = Database::instance();
		// Get the table name from the ORM model		
		
		
		/* $catalog_element = ORM::factory('catalog_element');		
		foreach($catalog_element->find_all() as $element)
		{
		   $element->delete();
		}		
		$catalog_item = ORM::factory('catalog_item');		
		foreach($catalog_item->find_all() as $item)
		{
		   $item->delete();
		} */		
		
		
			
//			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
	
		
		
		$config = Kohana::$config->load('test/catalog/catalog');
//		Minion_CLI::write($config->get('mode'));
		
		/* 
		uploadDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   copyrightHolder TEXT NOT NULL default '',

		Create the base table
			$link = mysql_connect($hostname, $db_user, $db_password);
			if (!$link) {
			  die ("MySQL Connection error");
			}
			mysql_select_db($database_name, $link) or die ("Wrong MySQL Database");
			read the sql file */
			$this->id = 0;
			$this->category_id = 0;
			$this->level = 0;
			$this->uri = 0;
			
			$this->delete_catalog_category();
			$this->catalog_category($this->category_id,$this->level);
	
			$this->catalog_category($this->category_id,1);
			$this->catalog_category($this->category_id,2);
			
			$this->catalog_category(0,0);
//			$this->catalog_category($temp,1);
	
		
		Minion_CLI::write('Create catalog instance');

	}

	protected function catalog_category($category_id=0, $level =0)
	{
		$catalog_category = ORM::factory('Catalog_Category');	
		
//		$catalog_category->id = $id;
		$catalog_category->category_id = $category_id;	
		$catalog_category->title = 'title category'.$category_id;		
		$catalog_category->text = 'text'.$category_id;
		$catalog_category->level = $level;
		$catalog_category->uri = 'category'.$this->uri;
		try{			
			$category_item = $catalog_category->save();
			$this->category_id = $category_item->id;
			Minion_CLI::write('id create - '.$category_item->id);
			$this->uri++;
		}
		 catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		}
		
		
		/* $catalog_category = ORM::factory('catalog_category');
		$catalog_category->category_id = $category_item->id;
		$catalog_category->level = 1;		
		$catalog_category->title = 'title category1';		
		$catalog_category->text = 'text1';	
		$catalog_category->uri = 'category1';	
		$catalog_category->description_tag = '';
		$catalog_category->created = 
		$catalog_category->creator_id = 0;
		$catalog_category->updated		
		$catalog_category->updater_id = 0;
		$catalog_category->deleted		
		$catalog_category->deleter_id = 0;
		$catalog_category->delete_bit = 0; */

		
		
		
	}
	
	
	protected function delete_catalog_category(){		
		$catalog_category = ORM::factory('Catalog_Category');		
		foreach($catalog_category->find_all() as $category)
		{
		   $category->delete();
		}
	}
	
	
	
	
	
	
	
	
	
	
}

/*
CREATE TABLE `catalog_categories` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`category_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`level` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`uri` VARCHAR(255) NOT NULL DEFAULT '',
	`code` VARCHAR(255) NOT NULL DEFAULT '',
	`title` VARCHAR(255) NOT NULL DEFAULT '',
	`image` VARCHAR(255) NOT NULL DEFAULT '',
	`text` TEXT NOT NULL,
	`active` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`position` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`title_tag` VARCHAR(255) NOT NULL DEFAULT '',
	`keywords_tag` VARCHAR(255) NOT NULL DEFAULT '',
	`description_tag` VARCHAR(255) NOT NULL DEFAULT '',
	`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`creator_id` INT(10) NOT NULL DEFAULT '0',
	`updated` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	`updater_id` INT(10) NOT NULL DEFAULT '0',
	`deleted` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	`deleter_id` INT(10) NOT NULL DEFAULT '0',
	`delete_bit` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT;

CREATE TABLE `catalog_elements` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`category_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`code` VARCHAR(255) NOT NULL DEFAULT '',
	`title` VARCHAR(255) NOT NULL DEFAULT '',
	`uri` VARCHAR(255) NOT NULL DEFAULT '',
	`image_1` VARCHAR(255) NOT NULL DEFAULT '',
	`image_2` VARCHAR(255) NOT NULL DEFAULT '',
	`announcement` TEXT NOT NULL,
	`text` TEXT NOT NULL,
	`active` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`sort` INT(10) UNSIGNED NOT NULL DEFAULT '500',
	`title_tag` VARCHAR(255) NOT NULL,
	`keywords_tag` VARCHAR(255) NOT NULL,
	`description_tag` VARCHAR(255) NOT NULL,
	`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`creator_id` INT(10) NOT NULL DEFAULT '0',
	`updated` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	`updater_id` INT(10) NOT NULL DEFAULT '0',
	`deleted` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	`deleter_id` INT(10) NOT NULL DEFAULT '0',
	`delete_bit` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT;






*/
