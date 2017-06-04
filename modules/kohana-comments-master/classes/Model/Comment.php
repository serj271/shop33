<?php defined('SYSPATH') OR die('No direct script access.');

/**
 * Comment model
 *
 * @package     Comments
 * @author      Kyle Treubig
 * @copyright   (c) 2010 Kyle Treubig
 * @license     MIT
 */
class Model_Comment extends Sprig {

	public function _init() {
		$this->_fields += array(
			'id'     => new Sprig_Field_Auto,
			'parent' => new Sprig_Field_BelongsTo(array(
				'column' => 'parent_id',
				'model'  => 'article',
	
			)),
			'state'  => new Sprig_Field_Char(array(
				'choices' => array('ham'=>'ham', 'queued'=>'queued', 'spam'=>'spam'),
			)),
			'date'   => new Sprig_Field_Timestamp(array(
				'auto_now_create' => TRUE,
				'editable'        => FALSE,
//				'format'          => 'F jS, Y \a\t g:s a',
			)),
			'name'   => new Sprig_Field_Char(array(
				'min_length' => 3,
				'max_length' => 64,
				'empty'	=>FALSE
			)),
			'email'  => new Sprig_Field_Email(array(
//				'empty' => TRUE,
			)),
			'url'    => new Sprig_Field_Char(array(
				'empty' => TRUE,
			)),
			'text'   => new Sprig_Field_Text(array(
				'empty' => FALSE,
			)),
		);
	}
	
	public function filters(){
		return array(
			'text'=>array(
				array('trim'),
				array(array($this, 'clearText')),
				array(array($this, 'firstLetter'))
					
			),
			'url'=>array(
				array('trim'),
				array(array($this, 'clearText')),			
					
			),
			'name'=>array(
				array('trim'),
				array(array($this, 'clearText')),
				array(array($this, 'firstLetter'))
					
			),
		);
			
		
	}
	
    public function firstLetter($text){
		return ucfirst($text);     
    }

    public function clearText($text){
		return preg_replace('/ +/',' ',$text);
    }
	
	public function __get($name) {
		if ($name == 'date')
		{
			if ( ! isset($this->_fields[$name]))
			{
				throw new Sprig_Exception(':name model does not have a field :field',
					array(':name' => get_class($this), ':field' => $name));
			}

			if (isset($this->_related[$name]))
			{
				// Shortcut to any related object
				return $this->_related[$name];
			}

			$field = $this->_fields[$name];

			if ($this->changed($name))
			{
				$value = $this->_changed[$name];
			}
			elseif (array_key_exists($name, $this->_original))
			{
				$value = $this->_original[$name];
			}
			$format = $this->_fields['date']->format;
			Log::instance()->add(Log::NOTICE, Debug::vars($format,$this->_original[$name]));
			$date = date($format, $value);
			return $date;
		/* 	return Route::get('blog/permalink')
				->uri(array('date'=>$date, 'slug'=>$this->slug)); */
		}
		/* elseif ($name == 'category_link')
		{
			return Route::get('blog/filter')->uri(array(
				'action' => 'category', 'name' => $this->category->load()->name));
		}
		elseif ($name == 'tag_list')
		{
			$return = '';
			foreach ($this->tags as $tag)
			{
				$return .= HTML::anchor( Route::get('blog/filter')->uri(array(
					'action' => 'tag', 'name' => $tag->name)), ucfirst($tag->name) );
			}
			return $return;
		}
		elseif ($name == 'excerpt')
		{
			$text = $this->text;
			if (strpos($text, '<p>') !== FALSE)
			{
				$text = substr($text, strpos($text, '<p>'));
			}
			return strip_tags(Text::limit_words($text, 100, '...'));
		} */
		else
		{
			return parent::__get($name);
		}
	}


}

