<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Assets_Popup extends Controller_Admin_Assets {
	
	public $crud_model = 'assets';
	
	public $template = 'admin/page/assets_popup/master_page';

	public function action_index()
	{	
		parent::action_index('admin/page/assets_popup/index');
		
		$this->template->title = 'Asset Manager';		
		
		$browse_html = View::factory('admin/page/assets_popup/browse')
			->bind('assets', $this->_assets)
			->bind('total', $this->_total)
			->bind('direction', $this->_direction)
			->bind('reverse_direction', $this->_reverse_direction)
			->bind('order_by', $this->_order_by)
			->bind('filter', $this->_filter)
			->bind('pagination', $this->_pagination);

		$upload_html = Request::factory('admin/assets/popup/upload')->execute()->response;
		
		$this->template->set_global('browse_html', $browse_html);
		$this->template->set_global('upload_html', $upload_html);
		
		array_push($this->template->scripts, 'modules/admin/media/js/jquery.tablescroll.js');
		array_push($this->template->scripts, Kohana::config('admin/media.paths.tinymce_popup'));
	}
	
	public function action_upload()
	{
		parent::action_upload('admin/page/assets_popup/upload', 'admin/assets/popup#browse');
	}
	
	public function action_resize($id = 0)
	{
		$asset = ORM::factory('asset', (int) $id);

		if (!$asset->loaded())
		{
			$this->request->redirect('admin/assets/popup');
		}
		
		$this->template->title = __('Resize Asset');
		$this->template->content = View::factory('admin/page/assets_popup/resize')
			->bind('asset', $asset);
	}
	
	public function action_view($id = 0)
	{
		$asset = ORM::factory('asset', (int) $id);
		
		if (!$asset->loaded())
		{
			$this->request->redirect('admin/assets/popup');
		}
		
		$this->template->title = __('View Asset');
		$this->template->content = View::factory('admin/page/assets_popup/view')
			->bind('asset', $asset);
	}

} // End Controller_Admin_Assets_Popup
