<?php defined('SYSPATH') or die('No direct script access.');
  
class Controller_Base extends Controller_Template {
 
	public $template = 'master_page';
	public $auth_required = FALSE;
	public $is_mobile = FALSE;
  
	public function before()
	{

		if ($this->is_mobile = strstr($_SERVER['HTTP_HOST'], 'm.')) $this->template .= '_mobile';

		parent::before();

		$this->template->title = Request::instance()->uri;

		$this->template->styles = $this->is_mobile ? Kohana::config('assets.mobile.style') : Kohana::config('assets.default.style');

		$this->template->scripts = $this->is_mobile ? Kohana::config('assets.mobile.script') : Kohana::config('assets.default.script');
		
		if ( $this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE)  {

			Request::instance()->redirect('sign-in');
		}
	}
}
