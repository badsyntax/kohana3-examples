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

		<div>
			<?php echo 
				Form::label('username', 'Username'), 
				Form::input('username', @$_POST['username'], array('id'=>'username'))
			?>
		</div>
		<div>
			<?php echo 
				Form::label('password', 'Password'), 
				Form::password('password', NULL, array('id' => 'password')) 
			?>
		</div>

		<?php echo Form::submit('signin', 'Sign in')?>
	</fieldset> 
<?php echo Form::close()?>
