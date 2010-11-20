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
				Form::label('password', 'Enter a new password:'), 
				Form::password('password', $_POST['password'], array('id'=>'password'))
			?>
		</div>

		<?php echo Form::submit('save', 'Save')?>
	</fieldset> 
<?php echo Form::close()?>
