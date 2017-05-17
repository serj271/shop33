<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tree_Item {

	protected $_id;
	protected $_level = 0;

	protected $_parent = NULL;
	protected $_data = array();
	protected $_children = array();

	public function __construct($id) 
	{
		$this->_id = $id;
	}

	public function set_level($level)
	{
		$this->_level = (int) $level;
		return $this;
	}

	public function get_data()
	{
		return $this->_data;
	}

	public function set_data($data)
	{
		$this->_data = (array) $data;
		return $this;
	}

	public function set_parent($item)
	{
		if($item instanceof Model_Tree_Item)
		{
			$this->_parent = $item;
		}
		return $this;
	}

	public function set_children($data)
	{
		$this->_children = $data;
		return $this;
	}

	public function children()
	{
		return $this->_children;
	}

	public function __get($key) 
	{
		return isset($this->_data[$key]) ? $this->_data[$key] : NULL;
	}

	public function get_keys_path($key)
	{
		$keys = array($this->{$key});

		if($this->_parent !== NULL)
		{
			$parent_keys = $this->_parent->get_keys_path($key);
			$keys = array_merge($keys, $parent_keys);
		}

		return $keys;
	}

	public function parent() 
	{
		return $this->_parent;
	}
}