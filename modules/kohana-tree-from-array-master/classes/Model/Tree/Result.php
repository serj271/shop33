<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tree_Result {

	// Raw result resource
	protected $_result;
	protected $_temp;

	protected $_flatten = FALSE;
	protected $_flatten_result = array();

	// Total number of rows and current row
	protected $_total_rows  = 0;

	public function __construct($result, $temp)
	{
		// Store the result locally
		$this->_result = $result;
		$this->_temp = $temp;
		
		// Find the number of rows in the result
		$this->_total_rows = count($this->_temp);
	}

	/**
	 * @return  array
	 */
	public function get()
	{
		return $this->_result;
	}

	/**
	 * @return  Model_Tree_Item
	 */
	public function current()
	{	
		foreach ($this->_result as $row)
		{
			return $row;
		}
	}

	public function flatten()
	{
		$array = $this->_flatten($this->_result);
		
		$this->_flatten = TRUE;
		$this->_flatten_result = $array;
		return $this;
	}

	protected function _flatten($array)
	{
		$_array = array();
		foreach ($array as $id => $row) 
		{
			$_array[$id] = $row;
			$children = $row->children();
			if(!empty($children))
			{
				$child_array = new self($children, $this->_temp[$id]);
				$child_array = $child_array->flatten()->get();
				$_array = Arr::merge($_array, $child_array);
			}
		}

		return $_array;
	}

	/**
	 * @return  Model_Tree_Item
	 */
	public function find_by_id($id)
	{
		if (Kohana::$profiling === TRUE)
		{
			$benchmark = Profiler::start('Tree', __FUNCTION__);
		}

		$found = $this->_find($this->_result, $id);
		
		if (isset($benchmark)) 
		{
			Profiler::stop($benchmark);
		}

		return $found;
	}
	
	/**
	 * @return  array
	 */
	public function as_array($children_key = NULL, $key = NULL, $value = NULL, $depth = 256)
	{
		if (Kohana::$profiling === TRUE)
		{
			$benchmark = Profiler::start('Tree', __FUNCTION__);
		}

		if($this->_flatten === TRUE)
		{
			$array = array();
			foreach ($this->_flatten_result as $row) 
			{
				if($key !== NULL)
				{
					$value = $row->{$key};
				}
				else
				{
					$value = $row;
				}

				if($children_key !== NULL)
				{
					$array[$row->{$children_key}] = $value;
				}
				else
				{
					$array[] = $value;
				}
			}
		}
		else 
		{
			$array = $this->_recurse_as_array($this->_result, $children_key, $key, $value, $depth);
		}		

		if (isset($benchmark)) 
		{
			Profiler::stop($benchmark);
		}

		return $array;
	}

	protected function _recurse_as_array($array, $children_key, $key, $value, $depth)
	{
		$_array = '';
		
		if($depth < 1)
		{
			return $_array;
		}

		$depth--;

		foreach ($array as $id => $data)
		{
			$row = $data->get_data();
			$children = $data->children();
			if(!empty($children) AND $depth > 1)
			{
				$_value = $this->_recurse_as_array($children, $children_key, $key, $value, $depth);
				$_key = Arr::get($row, $children_key);
			}
			else
			{
				$_value = Arr::get($row, $value);
				$_key = Arr::get($row, $key);
			}

			if($_key === NULL)
			{
				$_array[] = $_value;
			}
			else
			{
				$_array[$_key] = $_value;
			}
		}

		return $_array;
	}

	/**
	 * @return  Model_Tree_Result
	 */
	protected function _find($array, $id)
	{
		$found = NULL;
		foreach ($array as $key => $value) 
		{
			$children = $value->children();
			if($id == $key)
			{
				$found = new self(array($id => $value), $this->_temp[$id]);
			}
			else if(!empty($children))
			{
				$found = $this->_find($children, $id);
			}
			
			if($found !== NULL)
			{
				break;
			}
		}

		return $found;
	}

	/**
	 * @return  integer
	 */
	public function count()
	{
		return $this->_total_rows;
	}
}