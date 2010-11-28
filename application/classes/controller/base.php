<?php defined('SYSPATH') or die('No direct script access.');
  
abstract class Controller_Base extends Controller_Template {
 
	public $template = 'page/master_page';

	protected $auth_required = FALSE;

	public function before()
	{
		// Store the auth intance 
		$this->auth = Auth::instance();

		// Secure this controller
		$this->authenticate();
		
		// Detect mobile environment from HTTP HOST
		Request::$is_mobile = !!strstr(URL::base(TRUE, TRUE), '//mobile.');

		// Set the mobile master template
		Request::$is_mobile AND $this->template .= '_mobile';

		parent::before();

		$this->template->title =
		$this->template->content = '';

		// Set the stylesheet and javascript paths
		$this->template->styles = Kohana::config('assets.' . (Request::$is_mobile ? 'mobile' : 'default') . '.style');
		$this->template->scripts = Kohana::config('assets.' . (Request::$is_mobile ? 'mobile' : 'default') . '.script');

		// If the media module is enabled then run the scripts through the compressors
		if (class_exists('Media')) 
		{
			$this->template->styles = Media::instance()->styles( $this->template->styles);
			$this->template->scripts = Media::instance()->scripts( $this->template->scripts);
		}
	}

	public function after()
	{
		// jquery-mobile requires the entire template returned, 
		// for all other ajax requests we'll only return the template content
		$ajax_response = (Request::$is_ajax AND !Request::$is_mobile);

		if ($ajax_response OR $this->request !== Request::instance())
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

	public function authenticate()
	{
		// If this page is secured and the user is not logged in (or doesn't match role), then redirect to the signin page
		if ($this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE)
		{
			// Set the return path so user is redirect back to this page after successful sign in
			$uri = 'auth/signin?return_to=' . $this->request->uri;

			$this->request->redirect($uri);
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
			// Only generate the profiler HTML for sites in development
			'{profiler}' => Kohana::$environment === Kohana::DEVELOPMENT ? View::factory('profiler/stats') : ''
		);

		// Replace the placeholders with data
		return strtr( (string) $content, $data);
	}

} // End Controller_Base
