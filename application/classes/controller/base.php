<?php defined('SYSPATH') or die('No direct script access.');
  
class Controller_Base extends Controller_Template {
 
	public $template = 'master_page';

	public $auth_required = FALSE;

	public $is_mobile = FALSE;

	public $cache_request = FALSE;

	public $cache_key = FALSE;
  
	public function before()
	{
		$this->authenticate();
		
		$this->cache_request AND $this->cache();

		if ($this->is_mobile = strstr($_SERVER['HTTP_HOST'], 'm.')) $this->template .= '_mobile';
		
		parent::before();
		
		$this->template->styles = Kohana::config('assets.' . ($this->is_mobile ? 'mobile' : 'default') . '.style');

		$this->template->scripts = Kohana::config('assets.' . ($this->is_mobile ? 'mobile' : 'default') . '.script');
	}

	public function after()
	{
		parent::after();

		$this->cache_key !== FALSE AND $this->cache_save();
			
		$this->request->response = $this->profile( $this->request->response );
	}

	public function action_purge_cache()
	{
		Cache::instance()->delete_all();

		$this->request->redirect('');
	}
		
	private function authenticate()
	{
		if ( $this->auth_required !== FALSE AND Auth::instance()->logged_in($this->auth_required) === FALSE) {
		
			Request::instance()->redirect('auth/signin');
		}
	}

	private function cache()
	{
		$this->cache_key = $this->request_hash();

		$cache = Cache::instance()->get($this->cache_key);

		if ( $cache ) {

			$this->request->send_headers();

			exit( $this->profile($cache, TRUE) );
		}
	}

	private function cache_save($cache_lifetime=FALSE){

		if ($cache_lifetime === FALSE) {

			$cache_lifetime = PHP_INT_MAX;
		}

		Cache::instance()->set($this->cache_key, (string) $this->request->response, $cache_lifetime);
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

	private function request_hash()
	{
		return sha1(
			Auth::instance()->get_user() .
			$this->request->uri .
			get_class($this) .
			implode('', $_REQUEST)
		);
	}
}
