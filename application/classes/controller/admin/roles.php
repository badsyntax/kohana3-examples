<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Roles extends Controller_Admin_Base {

	// Set the controller crud model
	public $crud_model = 'role';

	public function action_add()
	{
		$this->template->title = __('Add role');

		$this->template->content = View::factory('admin/page/roles/add')
			->bind('errors', $errors);

		ORM::factory('role')->create($_POST) AND $this->request->redirect('admin/roles');

		$errors = $_POST->errors('admin/user');

		$_POST = $_POST->as_array();
	}

	public function action_edit($id = 0)
	{
		// Try get the role
		$role = ORM::factory('role', (int) $id);

		// If role doesn't exist then redirect to admin home
		! $role->loaded() AND $this->request->redirect('admin');

		$this->template->title = __('Role user').' '.$role->name;

		// If POST is empty then set the default form data
		!$_POST AND $default_data = $role->as_array();

		// Bind role data to template
		$this->template->content = View::factory('admin/page/roles/edit')
			->bind('role', $role)
			->bind('errors', $errors);

		// Try update the role, if successful then reload the page
		$role->update($_POST) AND $this->request->redirect($this->request->uri);

		// Get validation errors
		$errors = $_POST->errors('admin/user');

		// If POST is empty, then add the default data to POST
		isset($default_data) AND $_POST = array_merge($_POST->as_array(), $default_data);
	}

} // End Controller_Admin_Roles
