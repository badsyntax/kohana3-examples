<?php echo Form::open('admin/assets/popup#upload', array('enctype' => 'multipart/form-data', 'id' => 'upload-form'))?>

	<fieldset class="last">
		<p>Allowed types: <?php echo $allowed_upload_type?></p>
		<!-- <p>Max uploads: <?php echo $max_file_uploads?></p> -->
	
		<?php if ($errors[$field_name]){?>
			<strong>Errors:</strong><br />
			<ul>
				<?php foreach($errors[$field_name] as $field_errors){
					foreach($field_errors as $error){?>
						<li><?php echo $error?></li>
					<?php }
				}?>					
			</ul>
		<?php }?>
		
		<div class="field">	
			<?php echo Form::file($field_name.'[]', array(
				'id' => '', 
				'class' => 'multi',
				'maxlength' => $max_file_uploads,
				'accept' => preg_replace('/,\s*/', '|', $allowed_upload_type)
			), $errors)?>
		</div>
		
		<?php echo Form::button('save', 'Upload', array(
			'type' => 'submit', 
			'class' => 'ui-button save', 
			'id' => 'upload-asset'
		))?>		

	</fieldset>

<?php echo Form::close()?>
