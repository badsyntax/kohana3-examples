<div class="grid-50 clear">

	<div class="unit first">
		<?php echo Form::open()?>
			<fieldset>

				<legend>Sign in</legend>

				<p><a href="<?php echo URL::site('auth/signup')?>">Sign up</a> for a new account.</p>

				<?php if (isset($errors)) {?>
					<p>Errors:</p>
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
	</div>
	<div class="unit helper-center">

		<form>

			<fieldset>

				<button class="button">
					<span class="twitter">Sign in with twitter</span>
				</button>
			</fieldset>
		</form>
	</div>
</div>
