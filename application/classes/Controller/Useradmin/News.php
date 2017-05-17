<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Useradmin_News extends Controller_Admin_Crud {
		
	protected $_model = 'image';

	public $template='main';
	public function action_index() 
	{
		$images = Model::factory('image')
//			->where('id', '=', 1)
//			->find();	
			->find_all();
			
//		$obj = new stdClass;
//		$obj->content = "This is the content";
		
//		$renderer = Kostache::factory(); 	
//		list($view_name, $view_path) = static::find_view($this->request);		
//		$view = new $view_name();		
//		$view->obj = $obj;
		$this->view->images = $images;
		$this->view->urlDelete = URL::base().Request::current()->directory().'/'.Request::current()->controller().'/delete/';
		
		
		
	
//		$content = $renderer->render($view);
//		$this->template-> content = $content;			
//		$menu = View::factory('/user/menu');				
//		$headermenu = new View_headermenu_index();
//		$menu = $renderer->render($headermenu);
//		$this->template->menu = $menu;		
//		$navigator=View::factory('/news/navigator/navigator');
//	    $navigator->message='m';
//	    $this->template->navigator=$navigator;
	}
	
	public function action_file() 
	{
	    $renderer = Kostache::factory(); 
		$this->response->body('hello, world!');
		
//		$pagination  = new Pagination::$factory();
//		$this->response->body('hello, world!');
//		$this->response->body($renderer->render(new View_Test)); 
//		$renderer = Kostache::factory(); 	
//		list($view_name, $view_path) = static::find_view($this->request);
//		Log::instance()->add(Log::NOTICE,Debug::vars($this->request->controller()));		
//		$view = new $view_name();
//		$view->toForm = URL::base()."news/upload/";			
		
//		$this->template->content=$renderer->render($view);

		$this->view->toForm = URL::base().$this->request->directory().'/'.$this->request->controller()."/upload/";
		$headermenu = new View_user_headermenu_index();			
//		$menu = View::factory('/user/menu');				
		$headermenu = new View_user_headermenu_index();			
		$menu = View::factory('/user/menuprivate');
		$menu = $renderer->render($headermenu);
		$this->template->menu = $menu;		
	}
	
	
	public function action_delete()
	{
//		Log::instance()->add(Log::NOTICE, $this->_model.$this->request->param('id'));
		$item = ORM::factory($this->_model)
			->where('id', '=', $this->request->param('id'))
			->find();
		
		if ( ! $item->loaded())
		{
//			throw new HTTP_Exception_404(ucfirst($this->_model).' doesn`t exist: :id', 
//				array(':id' => $this->request->param('id')));
			$this->request->redirect(Request::current()->directory().'/'.Request::current()->controller());
			Message::error(ucfirst($this->_model).' doesn`t exist: :id', 
				array(':id' => $this->request->param('id')));
		}
		
		if ($this->request->method() === Request::POST)
		{
			$action = $this->request->post('action');						
			
			if ($action !== 'yes')
			{
				$this->request->redirect(Request::current()->directory().'/'.Request::current()->controller());
			}
			$filepath = '/usr/local/www/media'.$item->contentUrl;		
			if(isset($filepath) && file_exists($filepath)){
				unlink($filepath);			
			}
			
			$filepathThumbnail = '/usr/local/www/media'.$item->thumbnailUrl;	
			if(isset($filepathThumbnail) && file_exists($filepathThumbnail)){
				unlink($filepathThumbnail);
			}					
			
			$item->delete();
			
			$this->request->redirect(Request::current()->directory().'/'.Request::current()->controller());
		}
		$renderer = Kostache::factory(); 	
		list($view_name, $view_path) = static::find_view($this->request);	
				
		$view = new $view_name();		
		$view->item = $item;
		$content = $renderer->render($view);
		$this->template-> content = $content;	
		
		$menu = View::factory('/user/menu');				
		$headermenu = new View_headermenu_index();
		$menu = $renderer->render($headermenu);
		$this->template->menu = $menu;		
		$navigator=View::factory('/news/navigator/navigator');
	    $navigator->message='m';
	    $this->template->navigator=$navigator;

	}
	
	public function action_upload()
	{
//		Log::instance()->add(Log::NOTICE,Debug::vars($_FILES));	
		$error_message = NULL;
		$filename = NULL;
		
		if ($this->request->method() == Request::POST)
		{
			if (isset($_FILES['image']))
			{	
				$validation = Validation::factory($_FILES);
//				$validation->rule('file', 'Upload::not_empty')->rule('file', 'Upload::type', array(array('jpg', 'png', 'gif')));
				$validation->rules('image',array( 
//					array('Upload::not_empty'), 
//					array('Upload::image'),
					array('Upload::type', array(':value', array('jpg'))), 
					array('Upload::size', array(':value', '10M'))));
//				Log::instance()->add(Log::NOTICE,Debug::vars($validation->check()));
				
				if($validation->check()){	
					$filename = $this->_save_image($_FILES['image']);	
					Message::success($filename);
				} else {							
//					$errors = $validation->errors('upload');	
					$errors = $validation->errors('upload', TRUE);					
//					Log::instance()->add(Log::NOTICE,Debug::vars($errors));	
					Message::error($errors['image']);
//					Session::instance()->set('errors', $validation->errors('upload'));
				} 				
			}
		}
		
		if ( ! $filename)
		{
			$error_message = 'There was a problem while uploading the image.
				Make sure it is uploaded and must be JPG/PNG/GIF file.';				
		}		
//		Request::current()->redirect(URL::base().$this->request->directory().'/'.$this->request->controller()");	
		Request::current()->redirect($this->request->directory().'/'.'news');	
	}	
	
	protected function _save_image($image)
	{
		if (
			! Upload::valid($image) OR
			! Upload::not_empty($image) OR
			! Upload::type($image, array('jpg', 'jpeg', 'png', 'gif')))
		{
			return FALSE;
		}
		
		$save_folder  = '/usr/local/www/media/images'.URL::base().Request::current()->controller();
		if (!is_dir($save_folder)) {
		   $this->createPath($save_folder, 0777);
		}
		
		if ($file = Upload::save($image, NULL, $save_folder))
		{
			$filename = strtolower(Text::random('alnum', 20)).'.jpg';			
			Image::factory($file)
				->resize(600, 800, Image::AUTO)
				->save($save_folder.'/'.$filename);		
				
			$save_folder_thumbnail  = '/usr/local/www/media/images'.URL::base().Request::current()->controller().'/thumbnail';
			if (!is_dir($save_folder_thumbnail)) {
			   $this->createPath($save_folder_thumbnail, 0777);
			}		

				$filenameThumbnail = strtolower(Text::random('alnum', 20)).'.jpg';			
				Image::factory($file)
					->resize(200, 200, Image::AUTO)
					->save($save_folder_thumbnail.'/'.$filenameThumbnail);					

				// Delete the temporary file
				unlink($file);
				
				$size = getimagesize ($save_folder.'/'.$filename);			
				
				$model = Model::factory('image');
				$model->width=$size[0];
				$model->height=$size[1];//URL::base()
				$model->contentUrl = '/media/images'.URL::base().Request::current()->controller().'/'.$filename;
				$model->thumbnailUrl = '/media/images'.URL::base().Request::current()->controller().'/thumbnail/'.$filenameThumbnail;
				$model->caption = $image['name'];
				$model->contentSize = $image['size'];
				
				try
				{
					$model->save();				
				}
					catch(ORM_Validation_Exception $e)
				{
	//				Log::instance()->add(Log::NOTICE,Debug::vars($e->errors()));	
				}					
				
				return $filename;

		}
		
		return FALSE;
	}

	protected function createPath($path) {
			if (is_dir($path)) return true;
			$prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
			$return = $this->createPath($prev_path);
			return ($return && is_writable($prev_path)) ? mkdir($path) : false;
	}	
	
	
	
	
	public static function find_view(Request $request)
	{
		// Empty array for view name chunks
		$view_name = array('View');
		
		// If current request's route is set to a directory, prepend to view name
		$request->directory() and array_push($view_name, $request->directory());
		
		// Append controller and action name to the view name array
		array_push($view_name, $request->controller(), $request->action());
		
		// Merge all parts together to get the class name
		$view_name = implode('_', $view_name);
		
		// Get the path respecting the class naming convention
		$view_path = strtolower(str_replace('_', '/', $view_name));
		
		return array($view_name, $view_path);
	}

} // End 
