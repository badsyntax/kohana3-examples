<?php echo Form::open()?>
	<fieldset>

		<?php if (isset($errors)) {?>
			<ul class="errors">
			<?php foreach($errors as $field => $error){?>
				<li><?php echo $error ?></li>
			<?php }?>
			</ul>
		<?php }?>

		<div class="field">
			<?php echo 
				Form::label('username', 'Username'), 
				Form::input('username', @$_REQUEST['username'], array('id'=>'username'))
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('password', 'Password'), 
				Form::password('password', NULL, array('id' => 'password')) 
			?>
		</div>
		<div class="field checkbox">
			<?php echo
				Form::checkbox('remember', 1, TRUE, array('id' => 'remember')),
				Form::label('remember', 'Remember me')
			?>
		</div>

		<?php echo Form::submit('signin', 'Sign in', array('class' => 'button', 'style' => 'float:left;margin-right:1em'))?>
			
		<a href="<?php echo URL::site('auth/reset_password')?>" style="float: left;margin-top:.4em;">
			<small>Forgot username or password?</small>
		</a>

	</fieldset> 
<?php echo Form::close()?>
