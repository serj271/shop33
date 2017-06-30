<?php defined('SYSPATH') or die('No direct script access.');

	class Task_ImageCreate extends Minion_Task
	{
		protected $_options = array(
			'foo' => 'bar',
			'bar' => NULL,
		);

	public function build_validation(Validation $validation)
	{
		return parent::build_validation($validation)
			->rule('foo', 'not_empty') // Require this param
			->rule('bar', 'numeric'); // This param should be numeric
	}


		/**
		 * This is a demo task
		 *
		 * @return null
		 */
		protected function _execute(array $params)
		{/* 
			$filepath = 'DSC_0130.jpg';
			$directory = DOCROOT.'application/media/img/test/';
			$file_exists = Kohana::find_file('media/img/test',$filepath, FALSE);
			if($file_exists){
				Minion_CLI::write('file existst');
				$img = Image::factory($file_exists);
				$height = $img->height;
				$width = $img->width;
				$new_height = '200';
				$new_file = '2.jpg';
				$img->resize($new_height, NULL);
				$img->save($directory.$new_file);
				Minion_CLI::write($directory);
				
				
			} else {
				Minion_CLI::write('file not existst!!!');
				
			} */
			$source = DOCROOT.'application/media/img/source';
			$target = DOCROOT.'application/media/img/thumbnail';			
			$count=0;
			if(!file_exists($target)){
				mkdir($target);				
			}
			
			$files = scandir($source);
			Log::instance()->add(Log::NOTICE, Debug::vars(DOCROOT,$files));
			if(count($files)){
				foreach ($files as $file)
					
//					Minion_CLI::write('File '.$file);
					if(is_file($source.'/'.$file)){
						$filepath = $source.'/'.$file;
						Minion_CLI::write('File source'.$filepath);
						$img = Image::factory($filepath);						
						$new_height = '200';
						$new_file_path = $target.'/'.$file;
						$img->resize($new_height, NULL);
						$img->save($new_file_path);
						Minion_CLI::write('file target '.$new_file_path);
						
						
					}
				
				
			}
			
			
			
//			Log::instance()->add(Log::NOTICE, Debug::vars(DOCROOT,$file_exists));
		
		
		

		}
	}
	
#./minion --task=demo --foo=foobar` 	