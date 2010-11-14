<p>
<a href="<?php echo URL::site('auth/signup')?>">Sign up</a> for a new account. 
</p>

<?php echo Form::open(Request::instance()->uri())?>
	<fieldset>
                <?php if (isset($errors)) {?>
			<p>Errors:</p>
                        <ul class="errors">
                        <?php foreach($errors as $field => $error){?>
                                <li><?php echo $error ?></li>
                        <?php }?>
                        </ul>
                <?php }?>

		<div>
			<label for="username">
				Username
			</label>
			<?php echo Form::input('username', @$_POST['username'], array('id'=>'username')) ?>
		</div>

		<div>
			<label for="password">
				Password
			</label>
			<?php echo Form::password('password', '', array('id' => 'password')) ?>
		</div>

		<?php echo Form::submit('signin', 'Sign in')?>
	</fieldset>
<?php echo Form::close()?>
