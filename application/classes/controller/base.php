<?php defined('SYSPATH') or die('No direct script access.');
  
class Controller_Base extends Controller_Template {
 
	public $template = 'master_page';

	protected $auth_required = FALSE;

	protected $_mobile = FALSE;

	public function before()
	{
		$this->authenticate();
		
		parent::before();

		$this->template->title =
		$this->template->content = '';
		
		$this->template->styles = Media::instance()->styles( Kohana::config('assets.' . ($this->_mobile ? 'mobile' : 'default') . '.style'));
		$this->template->scripts = Media::instance()->scripts( Kohana::config('assets.' . ($this->_mobile ? 'mobile' : 'default') . '.script'));
	}

	public function after()
	{
		if (Request::$is_ajax OR $this->request !== Request::instance())
		{

			// Use the template content as the response
			$this->request->response = $this->template->content;
		} 
		else 
		{
			parent::after();

			// Add profiler information to template content
			$this->request->response = $this->profiler( $this->request->response );
		}
	}

	private function authenticate()
	{
		// If this page is secured and the user is not logged in, then redirect to the signin page
		if ( $this->auth_required !== FALSE AND Auth::instance()->logged_in($this->auth_required) === FALSE)
		{
			$this->request->redirect( URL::site( Route::get('auth', array('action' => 'signin'))));
		}
	}

	private function profiler($content)
	{
		// Load the profiler
		$profiler = Profiler::application();

		list($time, $memory) = array_values( $profiler['current'] );

		// Prep the data
		$data = array(
			'{memory_usage}' => Text::bytes($memory),
			'{execution_time}' => round($time, 3).'s',
			'{profiler}' => Kohana::$environment === Kohana::DEVELOPMENT ? View::factory('profiler/stats') : ''
		);

		// Replace the placeholders with data
		return strtr( (string) $content, $data);
	}

} // End Controller_Base
