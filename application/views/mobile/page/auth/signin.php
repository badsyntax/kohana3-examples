<div class="grid-50 clear">

	<div class="unit first">
		<?php echo Form::open()?>
			<fieldset>

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
	<div class="unit helper-center oauth-signin">

		<form>

			<fieldset>

				<p>
					<a class="button twitter" href="<?php echo URL::site('oauth/twitter/signin')?>">
						<span>Sign in with Twitter</span>
					</a>
				</p>
				<p>
					<a class="button google" href="<?php echo URL::site('openid/signin?openid_identity=https://www.google.com/accounts/o8/id')?>">
						<span>Sign in with Google</span>
					</a>
				</p>
				<p>
					<a class="button yahoo" href="<?php echo URL::site('openid/signin?openid_identity=https://me.yahoo.com')?>">
						<span>Sign in with Yahoo</span>
					</a>
				</p>
				<p class="last">
					<a class="button openid" href="<?php echo URL::site('openid/signin')?>">
						<span>Sign in with OpenID</span>
					</a>
				</p>
				<p class="helper-hidden">
					<a class="button facebook" href="<?php echo URL::site('oauth/facebook/signin')?>">
						<span>Sign in with Facebook</span>
					</a>
				</p>
			</fieldset>
		</form>
	</div>
</div>
