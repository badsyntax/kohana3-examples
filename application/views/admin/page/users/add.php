<h1>Add user</h1>

<?php echo Form::open()?>
	<fieldset>
		
		<?php if ($errors) {?>
			<p>Errors:</p>
			<ul class="errors">
			<?php foreach($errors as $field => $error){?>
				<li><?php echo $error ?></li>
			<?php }?>
			</ul>
		<?php }?>


		<div class="field">
			<?php echo 
				Form::label('username', __('Username')),
				Form::input('username', 
					$_POST['username'] ? $_POST['username'] : $user->username, 
					array('id' => 'username'))
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('email', __('Email')),
				Form::input('email', 
					$_POST['email'] ? $_POST['email'] : $user->email, 
					array('type' => 'email', 'id' => 'email'))
			?>
		</div>
		<div class="field">
			<?php echo
				Form::label('roles', __('Roles'))
			?>
			<?php foreach($roles as $role){?>
			<div class="checkbox">
				<?php echo 
					Form::checkbox('roles[]', $role->id, FALSE, array('id' => 'role-'.$role->id)),
					Form::label('role-'.$role->id, $role->name)
				?>
			</div>
			<?php }?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('password', __('New password')),
				Form::password('password', NULL, array('id' => 'password'))
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('password_confirm', __('Confirm password')),
				Form::password('password_confirm', NULL, array('id' => 'password_confirm'))
			?>
		</div>

		<?php echo Form::submit('save', 'Save', array('class' => 'button'))?>
	</fieldset>
<?php echo Form::close()?>
