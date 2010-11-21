<?php defined('SYSPATH') or die('No direct script access.');
  
class Controller_Base extends Controller_Template {
 
	public $template = 'master_page';

	public $auth_required = FALSE;

	public $is_mobile = FALSE;

	public function before()
	{
		$this->authenticate();
		
		if ($this->is_mobile = strstr($_SERVER['HTTP_HOST'], 'm.')) $this->template .= '_mobile';
		
		parent::before();
		
		$this->template->styles = Kohana::config('assets.' . ($this->is_mobile ? 'mobile' : 'default') . '.style');

		$this->template->scripts = Kohana::config('assets.' . ($this->is_mobile ? 'mobile' : 'default') . '.script');
	}

	public function after()
	{
		parent::after();

		$this->request->response = $this->profile( $this->request->response );
	}

	private function authenticate()
	{
		if ( $this->auth_required !== FALSE AND Auth::instance()->logged_in($this->auth_required) === FALSE) {
		
			Request::instance()->redirect('auth/signin');
		}
	}

	private function profile($response, $cached=FALSE)
	{
		$profiler = Profiler::application();

		list($time, $memory) = array_values( $profiler['current'] );

		$data = array(
			'{memory_usage}' => Text::bytes($memory),
			'{execution_time}' => round($time, 3).'s',
			'{profiler}' => Kohana::$environment === Kohana::DEVELOPMENT ? View::factory('profiler/stats') : '',
			'{cached}' => $cached ? 'from cache' : ''
		);

		return strtr( (string) $response, $data);
	}
}
