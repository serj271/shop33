<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Generic (C)REATE view model - for single record
 */
class View_Useradmin_Users_Prepend {
	/**
	 * @var	mixed	[Kostache|Formo] form
	 */
	public $form;
	/**
	 * @var	ORM		model
	 */
	public $item;	
	/**
	 * @var	array	validation errors
	 */
	public $errors;
	
//	protected $_template = 'admin/create';

	public $model;

	public function model()
	{
		return Inflector::humanize($this->model);
	}	
	/**
	 * Returns the form for current view
	 */
	public function form()
	{
		if ( ! $this->form)
		{
			// Create a CSRF token field
			$token = new View_Bootstrap_Form_Field('token', Security::token());
			$token->type('hidden');

			$id_listing = new View_Bootstrap_Form_Field('id_listing', '');
			$id_listing->type('text');
			
			$this->form = new View_Bootstrap_Form('useradmin/users/prepend');
//			$this->form->load($this->item);			
			$this->form->add($token);
			$this->form->add($id_listing);
			$this->form->submit()->label(__('Create new  :model',
				array(':model' => $this->model())));
			
			if ($this->errors)
			{
				$fields = $this->form->fields();
				
				foreach ($this->errors as $field => $error)
				{
					if ($field = Arr::get($fields, $field))
					{
						$field->error($error);
					}
				}
			}
		}
		
		return $this->form;
	}
	
	/**
	 * @return	string	Page headline
	 */
	public function headline()
	{
		return 'Prepend  new id to '.$this->model();
	}
	
}
