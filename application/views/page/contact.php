<?= Form::open()?>
	<fieldset>

		<legend>Contact</legend>

		<?php if ($message_sent) {?>
			<p class="form-success">
				Message successfully sent!
			</p>
		<?php }?>

		<div>
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

		<div>
			<label for="field-email">
				Email
				<?php if (isset($errors['email'])){?>
					<span class="form-error">
						<?php echo $errors['email']?>
					</span>
				<?php }?>
			</label>
			<?php echo Form::input('email', $_POST['email'], array('id' => 'field-email'))?>
		</div>

		<div>
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

		<?php echo Form::submit('submit', 'Submit')?>
	</fieldset>
<?= Form::close()?>

