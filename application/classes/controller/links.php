<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Links extends Controller_Base {

	public $cache_request = FALSE;

	public function action_index()
	{
		$this->template->title = 'Kohana3 links';
		$this->template->content = new View('page/links');
	}
}
