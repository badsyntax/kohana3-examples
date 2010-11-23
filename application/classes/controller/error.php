<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller_Base {

	public function action_index($type='404')
	{
		$this->template->title = "{$type}";

		$this->template->content = new View("page/errors/{$type}");
	}
}
