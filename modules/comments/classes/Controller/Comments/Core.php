<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Comment controller
 *
 * @package     Comments
 * @author      Kyle Treubig
 * @copyright   (c) 2010 Kyle Treubig
 * @license     MIT
 */
class Controller_Comments_Core extends Controller_Common_Comments {

	// Supported return formats
	protected $supported_formats = array(
		'.xhtml',
		'.json',
		'.xml',
		'.rss',
	);

	// Comment model to use (based on group)
	protected $model = 'Comment';

	// Pagination per-page setting (based on group)
	protected $per_page = 2;

	// View folder (based on group)
	protected $view = 'comments';

	// Group config
	protected $config = NULL;

	/**
	 * Perform format check
	 */
	public function before() {
		// Make sure request is an internal request
//		if ($this->request === Request::instance())
//		{
//			Kohana::$log->add(Kohana::ERROR, 'Attempt was made to access comments controller externally');
//			$this->request->redirect('');
//		}

		// Test to ensure the format requested is supported
	/* 	if ( ! in_array($this->request->param('format'), $this->supported_formats))
			throw new Kohana_Exception('File not found'); */

		// Get group settings
//		$group = $this->request->param('group');
		$group = 'default';
		$config = Kohana::$config->load('comments.'.$group);
		$this->model    = $config['model'];
		$this->per_page = $config['per_page'];
		$this->view     = $config['view'];
		$this->config   = $config;

		return parent::before();
	}

	/**
	 * Create new comment
	 */
	public function action_create() 
	{
//		Kohana::$log->add(Kohana::DEBUG, 'Executing Controller_Comments_Core::action_create');
		$id = $this->request->param('id', 1);//  must be 0

		// Comment must have a parent
		if ($id == 0)
		{
//			Log::instance()->add(Log::NOTICE, 'Attempt to create comment without a defined parent');
			$this->request->response = FALSE;
			return;
		}
/* 
		$comment = Sprig::factory($this->model)->values($_POST);
		$comment->parent = $id;

		// Perform Bayesian classification
		$B8 = B8::factory();
		$probability = $B8->classify($comment->text);
		$state = 'queued';
		if ($probability < $this->config['lower_limit'])
		{
//			Kohana::$log->add(Kohana::DEBUG, 'Comment has been classified as ham');
			$state = 'ham';
		}
		else if ($probability > $this->config['upper_limit'])
		{
			$state = 'spam';
		}
		else
		{
			$state = 'queued';
		}
		$comment->state = $state;

		try
		{
			$comment->create();
			$this->request->response = TRUE;
		}
		catch (Validation_Exception $e)
		{
			$form = View::factory($this->view.'/form')
				->set('legend', __('Post a Comment'))
				->set('submit', __('Create'))
				->set('comment', $comment)
				->set('errors', count($_POST) ? $e->array->errors('comments') : array() );
			$this->request->response = $form;
		} */
		$form = View::factory('comment/form')
			->bind('legend', $legend)
			->set('submit', __('Create'))
			->bind('errors',$errors)
			->bind('comment', $comment);
		$this->template->content = $form;
		$comment = Sprig::factory($this->model)->values($this->request->post());
		$legend = 'form action';
		
		if ($this->request->method() === Request::POST)
		{
			$validation = Validation::factory($this->request->post())
				->rule('token','not_empty')
				->rule('name','not_empty')
				->rule('token','Security::check');
				
//			Log::instance()->add(Log::NOTICE, Debug::vars('post-----',$this->request->post()));
			if($validation->check()){
				try
				{
					$comment->parent = $id;
					$B8 = B8::factory();
					$probability = $B8->classify($comment->text);
					$state = 'queued';
					if ($probability < $this->config['lower_limit'])
					{
			//			Kohana::$log->add(Kohana::DEBUG, 'Comment has been classified as ham');
						$state = 'ham';
					}
					else if ($probability > $this->config['upper_limit'])
					{
						$state = 'spam';
					}
					else
					{
						$state = 'queued';
					}
					$comment->state = $state;
					
					$comment->create();					
					$this->redirect($this->request->route()->uri(array(
						'controller' 	=> $this->request->controller(),
						'action'	=>'public'						
					)));
//					throw new Sprig_Validation_Exception( 'comment', $validation,'valid error');				
				}catch(Sprig_Validation_Exception $e)
				{
					$errors = $e->errors('comment');
//					Log::instance()->add(Log::NOTICE, Debug::vars('valid error',$errors));				
				}				
				
			} else {
				$errors = $validation->errors('comment');
//				$this->view->errors = $errors;
//				Log::instance()->add(Log::NOTICE, Debug::vars('valid error',$validation->errors('comment')));	
			}
		
		}	
		
		
		
		
	}

	/**
	 * List comments
	 */
	protected function create_list($state = 'ham', $admin = FALSE) 
	{
		$parent_id = $this->request->param('id', 0);

		if ($parent_id == 0)
		{
			$total = Sprig::factory($this->model, array(
				'state' => $state,
			))->load(NULL, FALSE)->count();
		}
		else
		{
			$Log::instance()->add(Log::NOTICE, Debug::vars('list ---',$list->render(),$comments)); = Sprig::factory($this->model, array(
				'state'  => $state,
				'parent' => $parent_id,
			))->load(NULL, FALSE)->count();
		}
//Log::instance()->add(Log::NOTICE, Debug::vars('list ---',$total));
		
		if ($total == 0)
		{
			$this->request->response = FALSE;
			return;
		}

		// Determine pagination offset
		$page = $this->request->param('page', 1);
		$offset = ($page - 1) * $this->per_page;

		// Create query
		$query = DB::select()->offset($offset)->order_by('date', $this->config['order']);

		// Execute query
		if ($parent_id == 0)
		{
			$comments = Sprig::factory($this->model, array(
				'state' => $state,
			))->load($query, $this->per_page);
		}
		else
		{
			$comments = Sprig::factory($this->model, array(
				'state'  => $state,
				'parent' => $parent_id,
			))->load($query, $this->per_page);
		}
		
		// If no comments found (bad offset/page)
		if (count($comments) == 0)
		{
			$this->request->response = FALSE;
			return;
		}

		// Create pagination
		/* $pagination = Pagination::factory(array(
			'current_page'   => array('source'=>'route', 'key'=>'page'),
			'total_items'    => $total,
			'items_per_page' => $this->per_page,
		));
 */
		// Setup admin view
		/* $admin_view = View::factory($this->view.'/admin')
			->set('is_ham', ($state == 'ham'))
			->set('is_spam', ($state == 'spam')); */

		// Setup view with data
		$list = View::factory($this->view.'/list')
			->set('legend', ucfirst($state).' Comments')

//			->set('pagination', $pagination)
			->set('comments', $comments);
//			$list = View::factory('home/content');
//
		// Set request response
		$this->template->content = $list;
//		$this->request->response = $list;
	}

	/**
	 * Retrieve public list of good comments
	 */
	public function action_public() 
	{
//		Kohana::$log->add(Kohana::DEBUG, 'Executing Controller_Comments_Core::action_public');

//		$id = $this->request->param('id', 0);

		// Comment must have a parent
//		if ($id == 0)
//		{
//			Kohana::$log->add(Kohana::INFO, 'Attempt to load all public comments without a defined parent');
//			$this->request->response = FALSE;
//			return;
//		}
//		else
//		{
			$this->create_list('queued', FALSE);
//		}
	}

	/**
	 * Retrieve good comments
	 */
	public function action_ham() {
//		Kohana::$log->add(Kohana::DEBUG, 'Executing Controller_Comments_Core::action_ham');
		$this->classify();
		$this->create_list('ham', TRUE);
	}

	/**
	 * Retrieve moderation queue
	 */
	public function action_queue() {
//		Kohana::$log->add(Kohana::DEBUG, 'Executing Controller_Comments_Core::action_queue');
		$this->classify();
		$this->create_list('queued', TRUE);
	}

	/**
	 * Retrieve spam comments
	 */
	public function action_spam() {
//		Kohana::$log->add(Kohana::DEBUG, 'Executing Controller_Comments_Core::action_spam');
		$this->classify();
		$this->create_list('spam', TRUE);
	}

	/**
	 * Perform classification changes
	 */
	protected function classify() 
	{
//		Kohana::$log->add(Kohana::DEBUG, 'Executing Controller_Comments_Core::classify');

		$id = 0;
		$comment = NULL;

		if (isset($_POST['classify_id']))
		{
			$id = $_POST['classify_id'];
			$comment = Sprig::factory($this->model, array('id' => $id))->load();

			// If comment is invalid
			if ( ! $comment->loaded())
			{
				$this->request->response = FALSE;
				return;
			}
		}

		// Perform Bayesian filter teaching
		if (isset($_POST['classify_option']) AND $_POST['classify_option'] != 'nop')
		{
			$option = $_POST['classify_option'];
//			Kohana::$log->add(Kohana::DEBUG, 'Performing classification change, '.$option);

			$B8 = B8::factory();
			try {
				switch ($option)
				{
					case 'learn_ham':
						$probability_before = $B8->classify($comment->text);
						$B8->learn($comment->text, B8::HAM);
						$probability_after = $B8->classify($comment->text);
//						Kohana::$log->add(Kohana::INFO, 'Comment learned as ham.  Probability before='.$probability_before.', after='.$probability_after);
						break;
					case 'learn_spam':
						$probability_before = $B8->classify($comment->text);
						$B8->learn($comment->text, B8::SPAM);
						$probability_after = $B8->classify($comment->text);
//						Kohana::$log->add(Kohana::INFO, 'Comment learned as spam.  Probability before='.$probability_before.', after='.$probability_after);
						break;
					case 'unlearn_ham':
						$probability_before = $B8->classify($comment->text);
						$B8->unlearn($comment->text, B8::HAM);
						$probability_after = $B8->classify($comment->text);
//						Kohana::$log->add(Kohana::INFO, 'Comment unlearned as ham.  Probability before='.$probability_before.', after='.$probability_after);
						break;
					case 'unlearn_spam':
						$probability_before = $B8->classify($comment->text);
						$B8->unlearn($comment->text, B8::SPAM);
						$probability_after = $B8->classify($comment->text);
//						Kohana::$log->add(Kohana::INFO, 'Comment unlearned as spam.  Probability before='.$probability_before.', after='.$probability_after);
						break;
				}
			}
			catch (Exception $e)
			{
				Kohana::$log->add(Kohana::ERROR, 'Error occured classifying comment, '.$option);
				$this->request->response = FALSE;
				return;
			}
		}

		// Approve the comment
		if (isset($_POST['classify_ham']))
		{
//			Kohana::$log->add(Kohana::DEBUG, 'Approving comment, id='.$id);

			try
			{
				$comment->state = 'ham';
				$comment->update();
			}
			catch (Exception $e)
			{
//				Kohana::$log->add(Kohana::ERROR, 'Error occured approving comment, id='.$id);
				$this->request->response = FALSE;
				return;
			}
		}

		// Mark the comment as spam
		if (isset($_POST['classify_spam']))
		{
//			Kohana::$log->add(Kohana::DEBUG, 'Marking comment as spam, id='.$id);

			try
			{
				$comment->state = 'spam';
				$comment->update();
			}
			catch (Exception $e)
			{
//				Kohana::$log->add(Kohana::ERROR, 'Error occured marking comment as spam, id='.$id);
				$this->request->response = FALSE;
				return;
			}
		}
	}

	/**
	 * Edit a comment
	 */
	public function action_update() {
//		Kohana::$log->add(Kohana::DEBUG, 'Executing Controller_Comments_Core::action_update');

		$id = $this->request->param('id');
		$comment = Sprig::factory($this->model, array('id' => $id))->load();

		// If comment is invalid
		if ( ! $comment->loaded())
		{
			$this->request->response = FALSE;
			return;
		}

		$comment->values($_POST);

		// Setup view with data
		$form = View::factory($this->view.'/form')
			->set('legend', __('Modify Comment'))
			->set('submit', __('Save'))
			->set('comment', $comment);

		if (count($_POST))
		{
			try
			{
				$comment->update();
				$this->request->response = TRUE;
				return;
			}
			catch (Validate_Exception $e)
			{
				$form->errors = count($_POST) ? $e->array->errors('comments') : array();
			}
		}

		// Set request response
//		$this->request->response = $form;
		$this->template->content = $form;
	}

	/**
	 * Delete a comment
	 */
	public function action_delete() 
	{
//		Kohana::$log->add(Kohana::DEBUG, 'Executing Controller_Comments_Core::action_create');

		// If deletion is not desired
		if (isset($_POST['no']))
		{
			$this->request->response = FALSE;
			return;
		}

		$id = $this->request->param('id');
		$comment = Sprig::factory($this->model, array('id' => $id))->load();

		// If comment is invalid
		if ( ! $comment->loaded())
		{
			$this->request->response = FALSE;
			return;
		}

		// If deletion is confirmed
		if (isset($_POST['yes']))
		{
			try
			{
				$comment->delete();
				$this->request->response = TRUE;
				return;
			}
			catch (Exception $e)
			{
				Kohana::$log->add(Kohana::ERROR, 'Error occured deleting comment, id='.$comment->id.', '.$e->getMessage());
				$this->request->response = FALSE;
				return;
			}
		}

		// Setup view with data
		$confirm = View::factory($this->view.'/delete')
			->set('comment', $comment);

		// Set request response
		$this->template->content = $confirm;
//		$this->request->response = $confirm;
	}

	/**
	 * Generate comment report
	 */
	public function action_report() 
	{
//		Kohana::$log->add(Kohana::DEBUG, 'Executing Controller_Comments_Core::action_report');

		// Determine time period
		$seconds = $this->request->param('id', 0);
		$now     = time();
		$then    = strtotime('-'.$seconds.' seconds', $now);
		$hours   = ($now - $then) / 3600;
//		Kohana::$log->add(Kohana::DEBUG, 'Fetching all comments created in the past '.$hours.' hours');

		// Create query
		$query = DB::select()->where('date', '>=', $then)->where('date', '<', $now)
			->order_by('date', $this->config['order']);
//		Kohana::$log->add(Kohana::DEBUG, 'Running query '.$query);
		$comments = Sprig::factory($this->model)->load($query, FALSE);

		// Check if there are any comments to report
		if ($comments->count() == 0)
		{
			$this->request->response = __('No comments have been created in the past '.$hours.' hours');
			return;
		}

		// Setup view with data
		$list = View::factory($this->view.'/report')
			->set('legend', 'Comments created in the past '.$hours.' hours')
			->set('comments', $comments);

		// Set request response
//		$this->request->response = $list;
		$this->template->content = $list;

	}

}	// End of Controller_Comments_Core

