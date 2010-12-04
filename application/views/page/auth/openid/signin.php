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

			<div class="field">
				<?php echo
					Form::label('openid_identity', 'Enter your OpenID URL', NULL, $errors) .
					Form::input('openid_identity', $_POST['openid_identity'], array('type' => 'url'), $errors)
				?>
			</div>

			<?php echo Form::submit('signin', 'Sign in', array('class' => 'button'))?>
		</fieldset>
			
	<?php echo Form::close()?>

<?php }?>
