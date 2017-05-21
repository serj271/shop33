<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Media_ extends Controller {

    protected $config = NULL;

    public function before()
    {
        parent::before();

        $this->config = Kohana::$config->load('media');

    }

    public function action_css()
    {
        $this->handle_request(
            'style',
            $this->request->param('path'),
            $this->config['styles']['extension']
        );
    }

    public function action_js()
    {
        $this->handle_request(
            'script',
            $this->request->param('path'),
            $this->config['scripts']['extension']
        );
    }

    public function action_img()
    {
        $image = $this->config['images']['directory'].$this->request->param('path');
        $extension = $this->find_image_extension($image);

        $this->handle_request(
            'image',
            $this->request->param('path'),
            $extension
        );
    }

    protected function handle_request($action, $path, $extension)
    {
//		Log::instance()->add(Log::NOTICE, Debug::vars('_-------------',$action, $path, $extension));
        $config_key = Inflector::plural($action);
        $file = $this->config[$config_key]['directory'].$path;

        if ($this->find_file($file, $extension))
        {
            $this->serve_file($file, $extension);
        }
        else
        {
            $this->error();
        }
    }

    protected function find_file($file, $extension)
    {
//		Log::instance()->add(Log::NOTICE, Debug::vars($file, $extension));
        $path_parts = pathinfo($file);
//		Log::instance()->add(Log::NOTICE,$path_parts['dirname']."/".$path_parts['filename']);
		Log::instance()->add(Log::NOTICE, Debug::vars('+++',$path_parts['dirname']."/".$path_parts['filename'].'.'.$extension));
//        return Kohana::find_file($path_parts['dirname']."/".$path_parts['filename'], $extension);
		return ($path_parts['dirname']."/".$path_parts['filename'].'.'.$extension);
		
    }

    protected function find_image_extension($file)
    {
//        foreach ($this->config['images']['extension'] as $extension)
 //       {
//            if ($this->find_file($file, $extension) !== FALSE)
 //           {
//                return $extension;
					return 'jpg';
 //           }
//        }

 //       return FALSE;
    }

    protected function serve_file($file, $extension)
    {
        $path = $this->find_file($file, $extension);
		Log::instance()->add(Log::NOTICE, $path.'---'.$extension);
		
        $this->response->headers('Content-Type', File::mime_by_ext($extension));
        $this->response->headers('Content-Length', (string) filesize($path));

        $this->response->headers('Cache-Control','max-age=86400, public');
        $this->response->headers('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
        $this->response->body(file_get_contents($path));
    }

    protected function error()
    {
        throw new HTTP_Exception_404('File :file not found.', array(
            ':file' => $this->request->param('path', NULL),
        ));
    }

}