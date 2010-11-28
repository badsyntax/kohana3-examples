<?php if (isset($form)){?>
	
	<p><strong>Redirecting...</strong></p>

	<?php echo $form?>

	<script type="text/javascript">
	(function($){
		// submit the openid form
		$('form#openid_message').submit();
	})(this.jQuery);
	</script>

<?php } else {?>

	<?php echo Form::open()?>
		<fieldset>

			<?php echo Form::hidden('return_to', $return_to)?>

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
					Form::label('openid_identity', 'Enter your OpenID URL') .
					Form::input('openid_identity', $_POST['openid_identity'], array('type' => 'url', 'id'=>'openid_identity'))
				?>
			</div>

			<?php echo Form::submit('signin', 'Sign in', array('class' => 'button'))?>
		</fieldset>
			
	<?php echo Form::close()?>

<?php }?>
