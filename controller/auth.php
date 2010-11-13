<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @name OpenID + OAuth controller 
 * @author Richard Willis
 * @depends kohana3, kohana 3 auth module, kohana 3 oauth modeul, php-openid module
 * 
 * Parts of this controller are based on the php-openid consumer examples here:
 * http://github.com/openid/php-openid/tree/master/examples/consumer/
 *
 */

class Controller_Auth extends Controller_Base {

	public $auth_required = FALSE;
	
	// OpenID
	private $store_path = '/tmp/_php_consumer_test';
	
	// OAuth
	protected $provider;
	protected $consumer;
	protected $token;
	protected $cookie = 'oauth_token_twitter';
	
	public function before(){

		parent::before();

		if (!file_exists($this->store_path) && !@mkdir($this->store_path)) {

			throw new Exception("Could not create the FileStore directory '{$store_path}'. Please check the effective permissions.");
		}
	}
	
	public function action_index(){

		Request::instance()->redirect('/');
	}
 
	public function action_sign_in(){

		if(Auth::instance()->logged_in()){

			Request::instance()->redirect('profile');		
		}

		$this->template->title = '2do : sign in';
		$content = $this->template->content = View::factory('page/auth/signin');

		if ($_POST) {
		

			$status = ORM::factory('user')->login($_POST);

			if ($status) {

				Request::instance()->redirect('/');
			} else {

				$content->errors = $_POST->errors('signin');
			}
		}

	}
	
	public function action_profile(){

		if(!Auth::instance()->logged_in()){

			Request::instance()->redirect('sign-in');
		}
		
		$profile = View::factory('page/auth/profile');
		$profile->user = $this->user;

		$this->template->title = '2do : profile';
		$content = $this->template->content = $profile;

		if ($_POST) {

			$user = ORM::factory('user', (int) $_POST['user_id']);

			$post = $user->validate_update($_POST);

			if ($post->check()) {

				$user->values($post);
				$user->username = $user->email;
				$user->save();

			} else {

				$content->errors = $post->errors('register');
			}
		}
	}
 
	public function action_sign_up(){

		if(Auth::instance()->logged_in()){

			Request::instance()->redirect('profile');		
		}

		$this->template->title = '2do : sign up'; 

		$content = $this->template->content = View::factory('page/auth/signup');		
 
		if ($_POST) {
		
			$_POST['username'] = $_POST['email'];

			$user = ORM::factory('user');	
 
			$post = $user->validate_create($_POST);			
 
			if ($post->check()) {

				$user->values($post);
 
				$user->save();
 
				$user->add('roles', new Model_Role(array('name' =>'login')));
 
				Auth::instance()->login($post['username'], $post['password']);
 
				Request::instance()->redirect('/');
			}
			else {

				$content->errors = $post->errors('register');
			}			
		}		
	}

	public function action_sign_out(){

		Auth::instance()->logout();

		Request::instance()->redirect('/');		
	}
	
	public function action_openid_finish(){
		
		$openid = @$_GET['openid_identity'] or Request::instance()->redirect('/');

		$store = new Auth_OpenID_FileStore($this->store_path);

		$consumer = new Auth_OpenID_Consumer($store);

		$response = $consumer->complete(URL::site('auth/openid_finish', TRUE));

		if ($response->status == Auth_OpenID_CANCEL) {

			throw new Exception("OpenID authentication cancelled.");

		} else if ($response->status == Auth_OpenID_FAILURE) {

			throw new Exception("OpenID authentication failed: {$response->message}");

		} else if ($response->status == Auth_OpenID_SUCCESS) {

			$openid = $response->getDisplayIdentifier();

			$user = ORM::factory('user')
				->where('username', '=', htmlentities($openid))
				->find();

			if (!$user->id) {

				Request::instance()->redirect('/auth/openid_confirm?openid='.urlencode($openid));
			}

			Auth::instance()->force_login($user);
			
			Session::instance()->set('notification', 'Succesfully logged in.');

			Request::instance()->redirect('/');
		}
	}

	public function action_confirm(){

		if (!isset($_REQUEST['id'])) Request::instance()->redirect('/');
			
		$auth_id = $_REQUEST['id'];

		if (!$_POST) {

			$template_auth = new View('page/auth/auth_confirm');

			$template_auth->id = $auth_id;

			$this->template->content = $template_auth;
		} 
		else if (isset($_POST['agree'])) {

			$data = array(
				'username' => $auth_id,
				'email' => $auth_id,
				'password' => sha1($auth_id),
				'password_confirm' => sha1($auth_id),
				'remember' => TRUE
			);

			$user = ORM::factory('user');

			$post = $user->validate_create($data, false);

			if ($post->check()){

				$user->values($post);

				$user->save();

				$user->add('roles', new Model_Role(array('name' =>'login')));

				Auth::instance()->force_login($user);

			} else {

				//die(var_dump($post->errors('register')));

				throw new Exception('Failed to add new user');
			}

			Request::instance()->redirect('/');
		}
	}

	public function action_openid_try(){

		$template_auth = new View('page/auth/auth_login');

		$openid = @$_GET['openid_identity'];
		
		if (!$openid) {

			Request::instance()->redirect('/');
		}

		$store = new Auth_OpenID_FileStore($this->store_path);

		$consumer = new Auth_OpenID_Consumer($store);

		// Begin the OpenID authentication process.
		$auth_request = $consumer->begin($openid);

		if (!$auth_request) {

			throw new Exception('Authentication error: not a valid OpenID.');
		}

		$sreg_request = Auth_OpenID_SRegRequest::build( array('nickname'), array('fullname', 'email') );

		if ($sreg_request) {

			$auth_request->addExtension($sreg_request);
		}

		$policy_uris = @$_GET['policies'];

		$pape_request = new Auth_OpenID_PAPE_Request($policy_uris);

		if ($pape_request) {

			$auth_request->addExtension($pape_request);
		}

		// Redirect the user to the OpenID server for authentication.
		// Store the token for this authentication so we can verify the
		// response.

		// For OpenID 1, send a redirect.  For OpenID 2, use a Javascript
		// form to send a POST request to the server.
		if ($auth_request->shouldSendRedirect()) {

			$redirect_url = $auth_request->redirectURL(URL::site(NULL, TRUE), URL::site('auth/openid_finish', TRUE));

			// If the redirect URL can't be built, display an error
			// message.
			if (Auth_OpenID::isFailure($redirect_url)) {
			
				throw new Exception('Could not redirect to server: '.$redirect_url->message);
			}

			// Send redirect.
			Request::instance()->redirect($redirect_url);
		} else {

			$form_html = $auth_request->htmlMarkup(
				URL::site(NULL, TRUE), 
				URL::site('auth/openid_finish', TRUE), 
				false, 
				array('id' => 'openid_message')
			);
			
			// Display an error if the form markup couldn't be generated;
			// otherwise, render the HTML.
			if (Auth_OpenID::isFailure($form_html)) {

				throw new Exception('Could not redirect to server: ' . $form_html->message);
			}
				
			$template_auth->form = $form_html;
		}

		$this->template->show_footer = FALSE;
				
		$this->template->content = $template_auth;
	}

	public function oauth_init($provider='twitter')
	{
		$this->provider = $provider;

		// Load the configuration for this provider
		$config = Kohana::config('oauth.'.$this->provider);

		// Create a consumer from the config
		$this->consumer = OAuth_Consumer::factory($config);

		// Load the provider
		$this->provider = OAuth_Provider::factory($this->provider);

		if ($token = Cookie::get($this->cookie))
		{
			// Get the token from storage
			$this->token = unserialize($token);
		}
	}

	public function action_oauth_twitter()
	{
		$this->oauth_init('twitter');

		// We will need a callback URL for the user to return to
		$callback = URL::site($this->request->uri(array('action' => 'oauth_authorize')), Request::$protocol);

		// Add the callback URL to the consumer
		$this->consumer->callback($callback);

		// Get a request token for the consumer
		$token = $this->provider->request_token($this->consumer);

		// Store the request token
		Cookie::set($this->cookie, serialize($token));

		// Redirect to the provider's login page
		$this->request->redirect($this->provider->authorize_url($token));
	}

	public function action_oauth_authorize()
	{
		$this->oauth_init('twitter');

		if ($this->token AND $this->token->token !== Arr::get($_GET, 'oauth_token'))
		{
			// Delete the token, it is not valid
			Cookie::delete($this->cookie);

			// Send the user back to the beginning
			Request::instance()->redirect($this->request->uri(array('action' => 'index')));
		}

		// Get the verifier
		$verifier = Arr::get($_GET, 'oauth_verifier');

		// Store the verifier in the token
		$this->token->verifier($verifier);

		// Exchange the request token for an access token
		$this->token = $this->provider->access_token($this->consumer, $this->token);

		// Store the access token
		Cookie::set($this->cookie, serialize($this->token));

		// At this point, we need to retrieve a unique twitter id for the user.
		$response = 
			OAuth_Request::factory('resource', 'GET', 'http://api.twitter.com/1/account/verify_credentials.json')
			->param('oauth_consumer_key', Kohana::config('oauth.twitter.key'))
			->param('oauth_token', $this->token)
			->sign(OAuth_Signature::factory('HMAC-SHA1'), $this->consumer, $this->token)
			->execute();

		$response = json_decode($response);

		$twitter_id = $response->screen_name;

		$user = ORM::factory('user')
		       ->where('username', '=', $twitter_id)
		       ->find();

		!$user->id AND Request::instance()->redirect('/auth/confirm?id='.$twitter_id);

		Auth::instance()->force_login($user);

		Session::instance()->set('notification', 'Succesfully logged in.');

		Request::instance()->redirect('/');
	}
}
