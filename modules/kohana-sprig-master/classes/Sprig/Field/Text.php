<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sprig text field.
 *
 * @package    Sprig
 * @author     Woody Gilk
 * @copyright  (c) 2009 Woody Gilk
 * @license    MIT
 */
class Sprig_Field_Text extends Sprig_Field_Char {
	public $label = 'Text of comment';
	public function input($name, $value, array $attr = NULL)
	{
		return Form::textarea($name, $value, $attr);
	}
//	public function label($field, array $attr = NULL){
//	    return '<label>Text of comment</label>';	    
//	}
} // End Sprig_Field_Text
