<?php defined('SYSPATH') or die('No direct script access.');

class View_User_Bootstrap_Navigator_Userform extends View_Bootstrap_Form {
	
	protected $_model;	
//	protected $_loaded_model;

	public function load($model)
	{
		$this->_model = $model;		
//		if ($this->_loaded_model !== $model->object_name())
//		{
			// Load all fields only if they haven't been loaded yet
			$this->load_fields($model);
//		}
//		else
//		{
			// Unload all field values and errors
//			$this->load_values($model);
//		}		
		return $this;
	}
	

	public function load_fields($model)
	{
		// Clean the fields array
		$this->_fields = array();//		
#		Log::instance()->add(Log::NOTICE,Debug::vars($model));
		$controls 	= $model->controls();	
		$labels 	= $model->labels();
		
		foreach ($controls as $name => $control)
		{
			// Create the field
//			Log::instance()->add(Log::NOTICE,Debug::vars($control,$name));
			$field = new View_Bootstrap_Form_Field($name, $name);
			
			// Get the field label, avoiding the Inflector call if possible
//			$label = Arr::get($labels, $name, Inflector::humanize($name));			
			$field->label($labels[$name]);
			$field->name($name);
			$field->type($model->types()[$name]);
			switch ($model->types()[$name])
			{
				default:
					$field->type('text');
				break;
				case 'select':
					$field->type('select')
						->options($control);
				break;
				case 'text':
					$field->type('text')
						->attr('class','')->value('');
				break;
//				case 'radio' :				
//				    $options = $field->options();				
//				    foreach ($options as $option)
//				    {
//					echo Form::radio($option);
//				    }				
//				break;
				
				
			}
				
			
			// Get first param of each field rule
			#$rule_names = Arr::pluck(Arr::get($rules, $name, array()), 0);
			
			// Filter out rules which are useless for field generation
			#$rule_names = array_filter($rule_names, 'is_string');
			
//			Log::instance()->add(Log::NOTICE,Debug::vars($field));
			$this->add($field);

			}
		
//		$this->_loaded_model = $model->object_name();*/
	}



}