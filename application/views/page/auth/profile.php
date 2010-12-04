<?php echo Form::open()?>
	<fieldset>
		<div class="field">
			<?php echo 
				Form::label('email', 'Email', NULL, $errors),
				Form::input('email', 
					$_POST['email'] ? $_POST['email'] : Auth::instance()->get_user()->email, 
					array('type' => 'email'),
					$errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('password', 'Password', NULL, $errors),
				Form::password('password', NULL, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('password_confirm', 'Confirm password', NULL, $errors),
				Form::password('password_confirm', NULL, NULL, $errors)
			?>
		</div>

		<?php echo Form::submit('update', 'Update', array('class' => 'button'))?>
	</fieldset>
<?php echo Form::close()?>
