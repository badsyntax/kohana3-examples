<p>
<a href="<?php echo URL::site('auth/signup')?>">Sign up</a> for a new account. 
</p>

<?php echo Form::open()?>
	<fieldset>
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
				Form::input('username', @$_POST['username'], array('id'=>'username'))
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
		<div class="field">
			<a href="<?php echo URL::site('auth/forgot')?>">Forgot username or password?</a>
		</div>

		<?php echo Form::submit('signin', 'Sign in')?>
	</fieldset> 
<?php echo Form::close()?>
