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
				'filters'=> array(
				    TRUE =>array('trim')
				),
			)),
		);
	}
	
    public function filters(){
		return array(
			TRUE	=>array(  // for all  fields
				array('trim'),
#			array('strtolower'),
			),
			'text' => array(
				array(array($this, 'clearText'))
			),
//			'comment' => array(
//				array(array($this, 'clearText'))
//			),	

		);
    }
    public function firstLetter($text){
		return ucfirst($text);     
    }

    public function clearText($text){
		return preg_replace('/ +/',' ',$text);
    }
	
	

}

