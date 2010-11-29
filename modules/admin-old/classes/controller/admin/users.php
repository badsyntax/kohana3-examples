<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Users extends Controller_Admin_Base {

	// Set the controller crud model
	public $crud_model = 'user';

	public function action_edit($id = 0)
	{
		$user = ORM::factory('user', (int) $id);

		! $user->loaded() AND $this->request->redirect('admin');

		$this->template->title = __('Edit user').' '.$user->username;

		// Bind user data to template
		$this->template->content = View::factory('admin/page/users/edit')
			->bind('roles', $roles)
			->bind('user', $user)
			->bind('user_roles', $user_roles)
			->bind('errors', $errors);

		// Find all roles
		$roles = ORM::factory('role')->find_all();
		
		// Create array of user role ids
		$user_roles = array();

		foreach($user->roles->find_all() as $role){

			$user_roles[] = $role->id;
		}

		// Try update the user, if succesful then reload the page
		$user->update_admin($_POST) AND $this->request->redirect($this->request->uri);

		$errors = $_POST->errors('profile');

		$_POST = $_POST->as_array();
	}

	public function action_add()
	{
		$this->template->title = __('Add user');

		$this->template->content = View::factory('admin/page/users/add')
			->bind('roles', $roles)
			->bind('errors', $errors);

		ORM::factory('user')->add_admin($_POST) AND $this->request->redirect('admin/users');
		
		$roles = ORM::factory('role')->find_all();

		$errors = $_POST->errors('auth');

		$_POST = $_POST->as_array();
	}

	public function action_delete($id = 0)
	{
		$id = (int) $id;

		// Don't delete user 1
		$id === 1 AND $this->request->redirect('403');

		// Try load the user
		$user = ORM::factory($this->crud_model, (int) $id);

		!$user->loaded() AND $this->request->redirect('admin');

		// Remove the user's roles relationship
		foreach ($user->roles->find_all() as $role)
		{
			$user->remove('roles', $role);
		}

		// Delete the user
		$user->delete();

		$this->request->redirect('admin/users');
	}

} // End Controller_Admin_users
