<div class="grid-50 clear">

	<div class="unit first">
		<?php echo Form::open()?>
			<fieldset>

				<?php echo Form::hidden('return_to', $return_to)?>

				<p><a href="<?php echo URL::site('user/signup')?>">Sign up</a> for a new account.</p>

				<div class="field">
					<?php echo 
						Form::label('username', 'Username', NULL, $errors), 
						Form::input('username', @$_REQUEST['username'], NULL, $errors)
					?>
				</div>
				<div class="field">
					<?php echo 
						Form::label('password', 'Password', NULL, $errors), 
						Form::password('password', NULL, NULL, $errors) 
					?>
				</div>
				<div class="field checkbox">
					<?php echo
						Form::checkbox('remember', 1, TRUE, array('id' => 'remember')),
						Form::label('remember', 'Remember me')
					?>
				</div>

				<?php echo Form::submit('signin', 'Sign in', array('class' => 'button', 'style' => 'float:left;margin-right:1em'))?>
					
				<?php echo HTML::anchor($urls['reset_pass'], 'Forgot username or password?', array('style' => 'float: left;margin-top:.8em;font-size:.8em'));?>

			</fieldset> 
		<?php echo Form::close()?>
	</div>
	<div class="unit helper-center oauth-signin">

		<form>

			<fieldset>

				<p>
					<?php echo HTML::anchor($urls['twitter'], '<span>Sign in with Twitter</span>', array('class' => 'button twitter'))?>
				</p>
				<p>
					<?php echo HTML::anchor($urls['google'], '<span>Sign in with Google</span>', array('class' => 'button google'))?>
				</p>
				<p>
					<?php echo HTML::anchor($urls['yahoo'], '<span>Sign in with Yahoo</span>', array('class' => 'button yahoo'))?>
				</p>
				<p class="last">
					<?php echo HTML::anchor($urls['openid'], '<span>Sign in with OpenID</span>', array('class' => 'button openid'))?>
				</p>
			</fieldset>
		</form>
	</div>
</div>
