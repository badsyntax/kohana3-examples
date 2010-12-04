<?php if (!Request::$is_mobile){?>
<p>
	This simple contact controller demonstrates how to use the Validation class and  
	SwiftMailer to send email. The contact view demonstrates how to use the Form helper and error handling.
</p>
<?php }?>
<?php echo Form::open()?>
	<fieldset>

		<div class="field">
			<?php echo 
				Form::label('name', 'Name', NULL, $errors) .
				Form::input('name', $_POST['name'], NULL, $errors)?>
		</div>

		<div class="field">
			<?php echo 
				Form::label('email', 'Email', NULL, $errors) .
				Form::input('email', $_POST['email'], array('type' => 'email'), $errors)
			?>
		</div>

		<div class="field">
			<?php echo
				Form::label('field-message', 'Message', NULL, $errors) .
				Form::textarea('message', $_POST['message'])
			?>
		</div>

		<?php echo Form::submit('submit', 'Submit', array('class' => 'button'))?>
	</fieldset>
<?php echo Form::close()?>
