<?php echo Form::open()?>
	<fieldset>

		<?php if ($errors) {?>
			<ul class="errors">
			<?php foreach($errors as $field => $error){?>
				<li><?php echo $error ?></li>
			<?php }?>
			</ul>
		<?php }?>

		<div class="field">
			<?php echo 
				Form::label('username', 'Username'),
				Form::input('username', $_POST['username'], array('id' => 'username'))
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('email', 'Email'),
				Form::input('email', $_POST['email'], array('type' => 'email', 'id' => 'email'))
			?>
		</div>
		<div class="field">
			<?php echo
				Form::label('password', 'Password'),
				Form::password('password', NULL, array('id' => 'password'))
			?>
		</div>
		<div class="field">
			<?php echo
				Form::label('password_confirm', 'Confirm password'),
				Form::password('password_confirm', NULL, array('id' => 'password_confirm'))
			?>
		</div>

		<?php echo Form::submit('signup', 'Sign up', array('class' => 'button'))?>

	</fieldset>
<?php echo Form::close()?>
