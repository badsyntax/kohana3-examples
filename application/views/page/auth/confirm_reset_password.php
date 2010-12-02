<?php echo Form::open()?>
	<fieldset>
		<?php if ($errors) {?>
			<ul class="errors">
			<?php foreach($errors as $field => $error){?>
				<li><?php echo $error ?></li>
			<?php }?>
			</ul>
		<?php }?>

		<?php echo Form::hidden('auth_token', $token)?>

		<div class="field">
			<?php echo 
				Form::label('password', 'Enter a new password'), 
				Form::password('password', NULL, array('id'=>'password'))
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('password_confirm', 'Confirm password'), 
				Form::password('password_confirm', NULL, array('id'=>'password_confirm'))
			?>
		</div>

		<?php echo Form::submit('save', 'Save', array('class' => 'button'))?>
	</fieldset> 
<?php echo Form::close()?>
