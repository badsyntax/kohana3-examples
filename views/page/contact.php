<form method="post" action="<?php echo URL::site( Request::instance()->uri )?>">

	<fieldset>

		<?php if (@$_REQUEST['status'] == 'sent') {?>
			<p class="form-success">
				Message successfully sent!
			</p>
		<?php }?>

		<ul>
			<li>
				<label for="field-name">
					Name
					<?php if (isset($errors['name'])){?>
						<span class="form-error">
							<?php echo $errors['name']?>
						</span>
					<?php }?>
				</label>
				<?php echo Form::input('name', $_POST['name'], array('id' => 'field-name'))?>
			</li>
			<li>
				<label for="field-email">
					Email
					<?php if (isset($errors['email'])){?>
						<span class="form-error">
							<?php echo $errors['email']?>
						</span>
					<?php }?>
				</label>
				<?php echo Form::input('email', $_POST['email'], array('id' => 'field-email'))?>
			</li>
			<li>
				<label for="field-message">
					Message
					<?php if (isset($errors['message'])){?>
						<span class="form-error">
							<?php echo $errors['message']?>
						</span>
					<?php }?>
				</label>
				<?php echo Form::textarea('message', $_POST['message'], array('id' => 'field-message'))?>
			</li>
			<li>
				<button type="submit">
					<span class="button-text">
						Send
					</span>
				</button>
			</li>
		</ul>
	</fieldset>
</form>
