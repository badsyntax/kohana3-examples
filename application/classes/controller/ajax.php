<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller_Base {

	public function action_index()
	{
		$this->template->title = 'Kohana3 AJAX Examples';
		$this->template->content = new View('page/ajax');
	}

	public function action_html()
	{
		$this->template->content = new View('ajax/html');
	}

	public function action_xml()
	{
		$this->template->content = new View('ajax/xml');

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
