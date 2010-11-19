<?php echo Form::open()?>
	<fieldset>
		<div>
			<!-- It's important to keep this field name, see http://openid.net/specs/openid-authentication-2_0.html#rfc.section.7.1 -->
			<?php echo Form::label('openid_identifier', 'OpenID URL'), "\n"?>
			<?php echo Form::input('openid_identifier', NULL, array('id' => 'openid_identifier')), "\n"?>
		</div>
		<?php echo Form::submit('signin', 'Sign in')?>
	</fieldset> 
<?php echo Form::close()?>
