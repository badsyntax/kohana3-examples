<?php echo Form::open(), "\n"?>
	<fieldset>
		<?php if (isset($errors)) {?>
			<p>Errors:</p>
			<ul class="errors">
			<?php foreach($errors as $field => $error){?>
				<li><?php echo $error ?></li>
			<?php }?>
			</ul>
		<?php }?>

		<div>
			<label for="username">Username</label>
			<?php echo Form::input('username', @$_POST['username'], array('id' => 'username')), "\n"?>
		</div>

		<div>
			<label for="email">Email</label>
			<?php echo Form::input('email', @$_POST['email'], array('id' => 'email')), "\n"?>
		</div>

		<div>
			<label for="password">Password</label>
			<?php echo Form::password('password', NULL, array('id' => 'password')), "\n"?>
		</div>

		<div>
			<label for="password_confirm">Confirm password</label>
			<?php echo Form::password('password_confirm', NULL, array('id' => 'password_confirm')), "\n"?>
		</div>

		<?php echo Form::submit('signin', 'Sign in'), "\n"?>

	</fieldset>
<?php echo Form::close()?>
