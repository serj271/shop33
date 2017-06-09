<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sprig exceptions.
 *
 * @package    Sprig
 * @author     Woody Gilk
 * @copyright  (c) 2009 Woody Gilk
 * @license    MIT
 */
class Kohana_Sprig_Validation_Exception extends Kohana_Exception {
	protected $_objects = array();
	/**
   * The alias of the main ORM model this exception was created for
   * @var string
   */
	protected $_alias = NULL;
    
    	public function __construct($alias, Validation $object, $message = 'Failed to validate array', array $values = NULL, $code = 0, Exception $previous = NULL)
	{
		$this->_alias = $alias;
		$this->_objects['_object'] = $object;
		$this->_objects['_has_many'] = FALSE;
//	Log::instance()->add(Log::NOTICE, Debug::vars($object));
		parent::__construct($message, $values, $code, $previous);
	}
	public function add_object($alias, Validation $object, $has_many = FALSE)
	{
		// We will need this when generating errors
		$this->_objects[$alias]['_has_many'] = ($has_many !== FALSE);

		if ($has_many === TRUE)
		{
			// This is most likely a has_many relationship
			$this->_objects[$alias][]['_object'] = $object;
		}
		elseif ($has_many)
		{
			// This is most likely a has_many relationship
			$this->_objects[$alias][$has_many]['_object'] = $object;
		}
		else
		{
			$this->_objects[$alias]['_object'] = $object;
		}

		return $this;
	}

	/**
	 * Merges an ORM_Validation_Exception object into the current exception
	 * Useful when you want to combine errors into one array
	 *
	 * @param  ORM_Validation_Exception $object   The exception to merge
	 * @param  mixed                    $has_many The array key to use if this exception can be merged multiple times
	 * @return ORM_Validation_Exception
	 */
/*
	public function merge(ORM_Validation_Exception $object, $has_many = FALSE)
	{
		$alias = $object->alias();

		// We will need this when generating errors
		$this->_objects[$alias]['_has_many'] = ($has_many !== FALSE);

		if ($has_many === TRUE)
		{
			// This is most likely a has_many relationship
			$this->_objects[$alias][] = $object->objects();
		}
		elseif ($has_many)
		{
			// This is most likely a has_many relationship
			$this->_objects[$alias][$has_many] = $object->objects();
		}
		else
		{
			$this->_objects[$alias] = $object->objects();
		}

		return $this;
	}
*/
	/**
	 * Returns a merged array of the errors from all the Validation objects in this exception
	 *
	 *     // Will load Model_User errors from messages/orm-validation/user.php
	 *     $e->errors('orm-validation');
	 *
	 * @param   string  $directory Directory to load error messages from
	 * @param   mixed   $translate Translate the message
	 * @return  array
	 * @see generate_errors()
	 */
	public function errors($directory = NULL, $translate = TRUE)
	{
		return $this->generate_errors($this->_alias, $this->_objects, $directory, $translate);
	}

	/**
	 * Recursive method to fetch all the errors in this exception
	 *
	 * @param  string $alias     Alias to use for messages file
	 * @param  array  $array     Array of Validation objects to get errors from
	 * @param  string $directory Directory to load error messages from
	 * @param  mixed  $translate Translate the message
	 * @return array
	 */
	protected function generate_errors($alias, array $array, $directory, $translate)
	{
		$errors = array();

		foreach ($array as $key => $object)
		{
			if (is_array($object))
			{
				$errors[$key] = ($key === '_external')
					// Search for errors in $alias/_external.php
					? $this->generate_errors($alias.'/'.$key, $object, $directory, $translate)
					// Regular models get their own file not nested within $alias
					: $this->generate_errors($key, $object, $directory, $translate);
			}
			elseif ($object instanceof Validation)
			{
				if ($directory === NULL)
				{
					// Return the raw errors
					$file = NULL;
				}
				else
				{
					$file = trim($directory.'/'.$alias, '/');
				}

				// Merge in this array of errors
				$errors += $object->errors($file, $translate);
			}
		}

		return $errors;
	}

	/**
	 * Returns the protected _objects property from this exception
	 *
	 * @return array
	 */
	public function objects()
	{
		return $this->_objects;
	}

	/**
	 * Returns the protected _alias property from this exception
	 *
	 * @return string
	 */
	public function alias()
	{
		return $this->_alias;
	}



}
