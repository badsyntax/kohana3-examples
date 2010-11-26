<h1>Add role</h1>

<?php echo Form::open()?>
	<fieldset>
		
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
				Form::label('name', __('Name')),
				Form::input('name', $_POST['name'], array('id' => 'name'))
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('description', __('Descripton')),
				Form::input('description', $_POST['description'], array('id' => 'description'))
			?>
		</div>

		<?php echo Form::submit('save', 'Save', array('class' => 'button'))?>
	</fieldset>
<?php echo Form::close()?>
