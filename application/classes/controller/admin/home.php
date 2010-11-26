<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Home extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template->title = __('Admin');
		$this->template->content = View::factory('admin/page/home');
	}
}
