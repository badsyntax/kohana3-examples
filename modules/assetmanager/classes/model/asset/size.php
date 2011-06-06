<?php defined('SYSPATH') or die('No direct script access.');

class Model_Asset_size extends Model_Base_Asset_size {
	
	public function admin_delete($id = NULL, & $data)
	{
		return parent::delete($id);		
	}
}