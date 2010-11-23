<?php defined('SYSPATH') or die('No direct script access.');

class Controller_General extends Controller_Base {

	public function action_index()
	{
		$this->template->title = 'General';
		$this->template->content = View::factory('page/general');
	}

	public function action_pagination()
	{
		$this->template->title = 'Kohana3 pagination';

		$pagination = Pagination::factory(array(
				'total_items'		=> 100,
				'items_per_page'	=> 10,
				'view' 			=> 'pagination/basic'
			));
			
		$this->template->content = $pagination->render();
	}

} // End Controller_Generl
