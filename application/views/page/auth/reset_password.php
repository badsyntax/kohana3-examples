<?php echo Form::open()?>
	<fieldset>
		<?php if ($errors) {?>

			<p>Errors:</p>
			<ul class="errors">
			<?php foreach($errors as $field => $error){?>
				<li><?php echo $error ?></li>
			<?php }?>
			</ul>

		<?php } else if ($message_sent) {?>

			<p class="form-success">
				 A password reset link has been sent to your email.
			</p>
		<?php }?>


		<div class="field">
			<?php echo 
				Form::label('email', 'Enter your email:'), 
				Form::input('email', $_POST['email'], array('id'=>'email'))
			?>
		</div>

		<?php echo Form::submit('resetpass', 'Reset password')?>
	</fieldset> 
<?php echo Form::close()?>
