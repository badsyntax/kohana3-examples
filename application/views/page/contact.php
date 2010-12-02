<?php if (!Request::$is_mobile){?>
<p>
	This simple contact controller demonstrates how to use the Validation class and  
	SwiftMailer to send email. The contact view demonstrates how to use the Form helper and error handling.
</p>
<?php }?>
<?php echo Form::open()?>
	<fieldset>

		<div class="field">
			<label for="field-name">
				Name
				<?php if (isset($errors['name'])){?>
					<span class="form-error">
						<?php echo $errors['name']?>
					</span>
				<?php }?>
			</label>
			<?php echo Form::input('name', $_POST['name'], array('id' => 'field-name'))?>
		</div>

		<div class="field">
			<label for="field-email">
				Email
				<?php if (isset($errors['email'])){?>
					<span class="form-error">
						<?php echo $errors['email']?>
					</span>
				<?php }?>
			</label>
			<?php echo Form::input('email', $_POST['email'], array('type' => 'email', 'id' => 'field-email'))?>
		</div>

		<div class="field">
			<label for="field-message">
				Message
				<?php if (isset($errors['message'])){?>
					<span class="form-error">
						<?php echo $errors['message']?>
					</span>
				<?php }?>
			</label>
			<?php echo Form::textarea('message', $_POST['message'], array('id' => 'field-message'))?>
		</div>

		<?php echo Form::submit('submit', 'Submit', array('class' => 'button'))?>
	</fieldset>
<?php echo Form::close()?>
