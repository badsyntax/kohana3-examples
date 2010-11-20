<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Base {

	public $cache_request = TRUE;

	public function action_index()
	{
		$this->template->title = 'Kohana3 Examples';
		$this->template->content = new View('page/home');
	}
}
