<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller_Base {

	public function action_index()
	{
		$this->template->title = __('Kohana3 AJAX Examples');
		$this->template->content = View::factory('page/ajax')
			->bind('errors', $errors);

		$data = Validate::factory($_POST)
			->filter('email', 'trim')
			->rule('email', 'not_empty')
			->rule('email', 'email')
			->filter('message', 'trim')
			->filter('message', 'Security::xss_clean')
			->filter('message', 'strip_tags')
			->rule('message', 'not_empty');
		
		if ($data->check()){
			
			$this->template->content->message = __('Email successfully sent!');
		}

		$_POST = $data->as_array();

		$errors = $data->errors('contact');

		if ( Request::$is_ajax ) {
		
			$this->template->content = json_encode($errors);
		
			$this->request->headers['Content-Type'] = 'application/json';
		}
	}

	public function action_html()
	{
		$this->template->content = View::factory('ajax/html');
	}

	public function action_xml()
	{
		$this->template->content = View::factory('ajax/xml');

		$this->request->headers['Content-Type'] = 'text/xml';
	}

	public function action_json()
	{
		$data = new stdclass();
		$data->id = '323';
		$data->name = 'John';
		$data->surname = 'Smith';
		$data->email = 'john@smi.th';

		$this->template->content = json_encode($data);
		
		$this->request->headers['Content-Type'] = 'application/json';
	}

} // End Controller_Ajax
