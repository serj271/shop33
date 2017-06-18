<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Getcategory extends Minion_Task {
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
		$this->categories = array();		
		
		$categories_db = ORM::factory('Catalog_Category')
			->order_by('catalog_category_id', 'asc')
			->order_by('position', 'asc')
			->find_all();
		
		$total = ORM::factory('Catalog_Category')->count_all();
		
		Minion_CLI::write('total category - '.$total);
		
//		$categories = array();
		/* foreach ($categories_db as $_item) {
//			Log::instance()->add(Log::NOTICE, Debug::vars('cat--------',$_item->as_array()));
			$_key = $_item->id;
			if ($_item->category_id == 0) {
				$categories[$_key] = array(
					'id' => $_key,
					'title' => $_item->title,
					'level' => 0,
					'children' => array(),
				);
			} else {
//				Log::instance()->add(Log::NOTICE, Debug::vars('cat--------',$categories_db, $categories));
				$_parent = & $categories[$_item->category_id];
				
				$_parent['children'][$_key] = array(
					'id' => $_key,
					'title' => $_item->title,
					'level' => $_parent['level'] + 1,
					'children' => array(),
				);
				unset($_parent);
			}
		} */
//		$this->buildTree($categories_db);
		$tree = $this->print_recursive($categories_db);
		Log::instance()->add(Log::NOTICE, Debug::vars('cat---tree----',$tree));		
			
		Minion_CLI::write('Get catalog categories');
	}

	private function print_recursive($structure)
	{
		if ($structure->count() > 0)
		{
			$recursive_items = array();
			for ($i = 0, $j = $structure->count(); $i < $j; $i++)
			{
				$parent   = $structure[$i]->title;
				$children = $this->print_recursive($structure[$i]->categories->find_all());
				$recursive_items[] = $parent . $children;
			}
			return '<ul><li>'.implode('</li><li>', $recursive_items).'</li></ul>';
		}
		return '';
	}
	
	
	
	protected function buildTree($elements, $parentId = 0) 
	{
			
		foreach ($elements as $element) {
			$_key = $element->id;			
//				Log::instance()->add(Log::NOTICE, Debug::vars($element->category_id,$parentId));
				if ($element->category_id == $parentId) {
					
					$children = $this->buildTree($elements, $element->id);
					
					if ($children) {
						$element['children'] = $children;
					}
					
					$this->categories[] =  $element;
				}
				
						
			/* 
			if ($element->category_id == $parentId) {
				$children = $this->buildTree($elements, $element->id);
				
				if ($children) {
					$element['children'] = $children;
				}
				
				$branch[] =  $element;
			} */
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
