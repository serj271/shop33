<?php defined('SYSPATH') OR die('No direct script access.');

class Task_Products extends Minion_Task {
	protected $_options = array(
		// param name => default value
		'foo'   => 'beautiful',
	);
	
	private $product_id;
	private $photo_id;

	protected function _execute(array $params)
	{
		spl_autoload_register(array('Kohana', 'auto_load'));
		set_error_handler(array('Kohana','error_handler'));
#		Kohana::$log->attach(new Log_File(APPPATH.'logs'));
#		set_exception_handler(array('Kohana_Exception_Handler','handle'));
		Kohana::$config->attach(new Config_File);		
		$db = Database::instance();
		// Get the table name from the ORM model	
		$this->product_id = 1;
		$this->photo_id =1;
		$this->parent_id = 1;

		$this->delete_product();
		$this->delete_photo();
		$this->delete_product_specification();
		$this->delete_product_review();
		$this->delete_create_category();
		
		$this->create_product($this->product_id,$this->photo_id);
		$this->create_category($this->parent_id,$this->parent_id);
		$this->create_category($this->parent_id,2,$this->product_id);//parent, category_id , product
		
		$this->create_photo($this->product_id,$this->photo_id);
		
//		$this->product_categories_products($this->product_id);
		$this->product_specification($this->product_id);
		
		$this->product_reviews($this->product_id);
		
		
		$this->product_id = 2;
		$this->photo_id =2;
		$this->parent_id = 2;
		
		$this->create_product($this->product_id,$this->photo_id);
		$this->create_photo($this->product_id,$this->photo_id);
		$this->product_reviews($this->product_id);
		$this->product_specification($this->product_id);
//		$this->create_variation($this->product_id);	
	
	
		$this->product_id = 3;
		$this->photo_id =3;
		$this->parent_id = 3;
		
		$this->create_product($this->product_id,$this->photo_id);
		$this->create_photo($this->product_id,$this->photo_id);
		$this->product_reviews($this->product_id);
		$this->product_specification($this->product_id);
//		$this->create_variation(1);	
	
	
//		$this->create_category($this->parent_id);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
		Minion_CLI::write('Create products instance');

	}
	
	
	protected function product_categories_products($product_id=1)
	{
		$model = 'Product_Categories_Product';
		$orm = ORM::factory($model);
		foreach($orm->find_all() as $item)
		{
		   $item->delete();
		}
		
		$orm = ORM::factory($model);
		$orm->id = 1;		
		$orm->category_id = 1;
		$orm->product_id = $product_id;		
		

		try
		{			
			$orm_id = $orm->save();			
//			Log::instance()->add(Log::NOTICE, Debug::vars($product->id));
			Minion_CLI::write('id create  product_categories_products- '.$orm_id->id);
			
		}
		 catch (ORM_Validation_Exception $e)
		{
//			Minion_CLI::write(Kohana::message('product_variation', 'Validation::lt'));
//			$errors = $extra_validation->errors('validation_', TRUE)	;	
			$errors = $e->errors();		
			foreach($errors as $key=>$value){
				Log::instance()->add(Log::NOTICE, Debug::vars($value));//+ field				
			}
			Minion_CLI::write($errors);		
//			Log::instance()->add(Log::NOTICE, Debug::vars($errors));//+ field			
		}
	
	}
	
	protected function create_category($parent_id = 1,$category_id=1,$product_id=NULL)
	{		
		$model = 'Product_Category';
		$orm = ORM::factory($model);
		$orm->id = $category_id;		
		$orm->name = 'name '.$parent_id;
		$orm->description = 'description'.$parent_id;		
//		$orm->order = 500;
		$orm->uri = 'uri'.$parent_id.$category_id;
		$orm->parent_id = $parent_id;

		try
		{			
			$orm_id = $orm->save();	
			if($product_id){
					$query = DB::insert('product_categories_products',array('product_id', 'category_id'))
				->values(array($product_id,$category_id));				
				$query->execute();
			}			
//			Log::instance()->add(Log::NOTICE, Debug::vars($product->id));
			Minion_CLI::write('id create  Product_Category- '.$orm_id->id);
			
		}
		 catch (ORM_Validation_Exception $e)
		{
//			Minion_CLI::write(Kohana::message('product_variation', 'Validation::lt'));
//			$errors = $extra_validation->errors('validation_', TRUE)	;	
			$errors = $e->errors();		
			foreach($errors as $key=>$value){
				Log::instance()->add(Log::NOTICE, Debug::vars($value));//+ field				
			}
			Minion_CLI::write($errors);		
			Log::instance()->add(Log::NOTICE, Debug::vars($e));//+ field			
		}
	}
	
	
	protected function product_reviews($product_id=1){
		
		$model = 'Product_Review';
		$orm = ORM::factory($model);
		$orm->id = $product_id;	
		$orm->product_id = $product_id;		
		$orm->name = 'name '.$product_id;
		$orm->rating = '2';		
		$orm->summary = 'summary'.$product_id;
		$orm->body = 'body'.$product_id;
		

		try
		{			
			$orm_id = $orm->save();			
			Log::instance()->add(Log::NOTICE, Debug::vars($product_id));
			Minion_CLI::write('id create  product_reviews- '.$orm_id->id);
			
		}
		 catch (ORM_Validation_Exception $e)
		{
//			Minion_CLI::write(Kohana::message('product_variation', 'Validation::lt'));
//			$errors = $extra_validation->errors('validation_', TRUE)	;	
			$errors = $e->errors();		
			foreach($errors as $key=>$value){
				Log::instance()->add(Log::NOTICE, Debug::vars($value));//+ field				
			}
			Minion_CLI::write($errors);		
//			Log::instance()->add(Log::NOTICE, Debug::vars($errors));//+ field			
		}
	}
	
	
	protected function product_specification($product_id=1){
		
		$model = 'Product_Specification';
		$orm = ORM::factory($model);				
//		$orm->id = 1;		
		$orm->name = 'name '.$product_id;	
		$orm->value = 'value'.$product_id;	
		$orm->product_id = $product_id;

		try
		{			
			$orm_id = $orm->save();			
//			Log::instance()->add(Log::NOTICE, Debug::vars($product->id));
			Minion_CLI::write('id create  Product_Specifications- '.$orm_id->id);
			
		}
		 catch (ORM_Validation_Exception $e)
		{
//			Minion_CLI::write(Kohana::message('product_variation', 'Validation::lt'));
//			$errors = $extra_validation->errors('validation_', TRUE)	;	
			$errors = $e->errors();		
			foreach($errors as $key=>$value){
				Log::instance()->add(Log::NOTICE, Debug::vars($value));//+ field				
			}
			Minion_CLI::write($errors);		
//			Log::instance()->add(Log::NOTICE, Debug::vars($errors));//+ field			
		}		
			
	}
	
	protected function create_variation($product_id=1){
		
		$model = 'Product_Variation';
		$variation_orm = ORM::factory($model);
		$variation_orm->id = 1;
		$variation_orm->product_id = $product_id;
		$variation_orm->name = 'name '.$product_id;
		$variation_orm->price = 10.00;
		$variation_orm->sale_price = 10.00;
		$variation_orm->quantity = 1;
		$external_values= array();		
		$extra_validation = Validation::factory($external_values);
//		$extra_validation->bind(':model', $variation_orm);
//		$extra_validation->rules('sale_price', array(
//			array('not_empty'),array('Validation::lt',array(':value'))
//		));
//		$extra_validation->rule('username', 'Validation::lt', array(':model'));

//		Log::instance()->add(Log::NOTICE, Debug::vars($extra_validation->check()));
		Minion_CLI::write(Kohana::message('hello', 'hello_guest'));
	
		try
		{			
			$variation_id = $variation_orm->save($extra_validation);			
//			Log::instance()->add(Log::NOTICE, Debug::vars($product->id));
			Minion_CLI::write('id create  variation- '.$variation_id->id);
			
		}
		 catch (ORM_Validation_Exception $e)
		{
			Minion_CLI::write(Kohana::message('product_variation', 'Validation::lt'));
//			$errors = $extra_validation->errors('validation_', TRUE)	;	
			$errors = $e->errors();		
			foreach($errors as $key=>$value){
				Log::instance()->add(Log::NOTICE, Debug::vars($value));//+ field				
			}
			Minion_CLI::write($errors);		
//			Log::instance()->add(Log::NOTICE, Debug::vars($errors));//+ field			
		}
		
		
	}
	
	protected function create_product($product_id=1,$photo_id=1){
		
		$products_orm = ORM::factory('Product');		
	/* 	foreach($products_orm->find_all() as $item)
		{
			$item->delete();
		} */
		$products_orm->id = $product_id;
		$products_orm->name = 'name products'.$product_id;

		$products_orm->description = 'description '.$product_id;
		$products_orm->primary_photo_id = $photo_id ;
		$products_orm->uri = 'product'.$product_id;
//		$products_orm->avg_review_rating = 
//		$products_orm->visible = '0';		
		
		try
		{			
			$product = $products_orm->save();			
//			Log::instance()->add(Log::NOTICE, Debug::vars($product->id));
			Minion_CLI::write('id create  products_orm- '.$products_orm->id);
			
		}
		 catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		}
		
	}
	
	protected function delete_product(){
		$products_orm = ORM::factory('Product');		
		foreach($products_orm->find_all() as $item)
		{
			$item->delete();
		}		
	}
	
	protected function create_photo($product_id=1,$photo_id=1){
		$photos = ORM::factory('Product_Photo');
	/* 	foreach($photos->find_all() as $item)
		{
		   $item->delete();
		} */
		$photos->id = $photo_id;
		$photos->product_id = (int) $product_id;
		$photos->path_fullsize =  '/media/images/shopelement/1.jpg';
		$photos->path_thumbnail= '/media/images/shopelement/thumbnail/1.jpg';	
		try
		{			
			$photo = $photos = $photos->save();
			Minion_CLI::write('id create - photos'.$photos->id);
		
		}
		 catch (ORM_Validation_Exception $e)
		{
			$errors = $e->errors();
			Minion_CLI::write($errors);
			Log::instance()->add(Log::NOTICE, Debug::vars($errors));
		}
	}
	protected function delete_photo(){
		$photos = ORM::factory('Product_Photo');
		foreach($photos->find_all() as $item)
		{
		   $item->delete();
		}
	}
	
	protected function delete_product_specification(){
		$items = ORM::factory('Product_Specification');
		foreach($items->find_all() as $item)
		{
		   $item->delete();
		}
	}
	protected function delete_product_review(){
		$items = ORM::factory('Product_Review');
		foreach($items->find_all() as $item)
		{
		   $item->delete();
		}
	}
	protected function delete_create_category(){
		$items = ORM::factory('Product_Category');
		foreach($items->find_all() as $item)
		{
		   $item->delete();
		}
	}
	

}







