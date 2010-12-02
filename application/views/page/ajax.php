<p>
	The page demonstrates how to use AJAX in your Kohana 3 application.
	Only the template contents will be used for the response body of an ajax request, 
	the html data type example demonstrates this.
</p>

<h2>Data type examples</h2>

<ul>
	<li><a id="html-link" href="<?php echo URL::site('general/ajax_html')?>">HTML</a></li>
	<li><a id="xml-link" href="<?php echo URL::site('general/ajax_xml')?>">XML</a></li>
	<li><a id="json-link" href="<?php echo URL::site('general/ajax_json')?>">JSON</a></li>
</ul>

<div id="example" class="helper-hidden" style="border:1px solid #eee;padding: 1em;margin:1em;">

</div>

<br />

<h2>AJAX form validation</h2>

<p>This example demonstrates using back-end form validation with errors displayed via AJAX. If Javascript is disabled the form is still fully functional.</p>

<?php echo Form::open(NULL, array('id' => 'ajax-form'))?>
	<fieldset>

		<p class="form-success helper-hidden"><?php echo isset($message) ? $message : ''?></p>

		<div class="field">
			<label for="field-email">
				Email
				<span class="form-error">
				<?php if (isset($errors['email'])){?>
					<?php echo $errors['email']?>
				<?php }?>
				</span>
			</label>
			<?php echo Form::input('email', $_POST['email'], array('id' => 'field-email'))?>
		</div>

		<div class="field">
			<label for="field-message">
				Message
				<span class="form-error">
				<?php if (isset($errors['message'])){?>
						<?php echo $errors['message']?>
				<?php }?>
				</span>
			</label>
			<?php echo Form::textarea('message', $_POST['message'], array('id' => 'field-message', 'style' => 'height: 60px'))?>
		</div>

		<?php echo Form::submit('submit', 'Submit', array('class' => 'button'))?>
	</fieldset>
<?php echo Form::close()?>

<p>View the source of the page to view the Javascript used for these examples.</p>

<script type="text/javascript">
(function($){
	
	$('#html-link').click(function(e){

		e.preventDefault();

		$('#example').load( this.href ).fadeIn('fast');
	});

	$('#xml-link').click(function(e){

		e.preventDefault();

		$.ajax({
			type: 'GET',
			url: this.href,
			dataType: 'xml',
			success: function(xmldoc){

				var element = $('#example').html('<p>XML results:</p>');

				$(xmldoc).find('book').each(function(){

					var title = $(this).find('title').text(),
						author = $(this).find('author').text();

					element.append('<div>Title: ' + title + ' Author: ' + author);
				});

				element.fadeIn('fast');
			}
		});
	});

	$('#json-link').click(function(e){

		e.preventDefault();

		$.getJSON(this.href, function(data){

			var element = $('#example').html('<p>JSON results:</p>');

			$.each(data, function(key, val){

				element.append('<div>' + key + ': ' + val + '</div>');
			});
				
			element.fadeIn('fast');
		});
	});

	var form;

	function postSuccess(errors){

		$('.form-error, .form-success').hide();

		if (!errors.length && errors.length !== undefined) {

			form.reset();

			$('.form-success')
				.hide()
				.html('Message successfully sent!')
				.fadeIn('fast');

		} else {
			
			$.each(errors, function(key, val){

				var id = $('[name="' + key + '"]').attr('id');

				$('label[for="' + id + '"] .form-error')
					.hide()
					.html(val)
					.fadeIn('fast');
			});

		}
	}

	$('#ajax-form').submit(function(e){

		form = this;

		e.preventDefault();

		$.ajax({
			type: 'POST',
			url: this.action,
			data: $(this).serialize(),
			dataType: 'json',
			success: postSuccess
		});
	});

})(this.jQuery);
</script>
