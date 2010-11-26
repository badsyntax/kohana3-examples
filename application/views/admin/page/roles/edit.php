<div class="action-bar clear">
	<a href="<?php echo URL::site('admin/roles/delete/'.$role->id)?>" id="delete-role" class="button delete small helper-right">
		<span>Delete role</span>
	</a>
	<script type="text/javascript">
	(function($){
		$('#delete-role').click(function(){

			return confirm('<?php echo __('Are you sure you want to delete this role?')?>');
		});
	})(this.jQuery);
	</script>

	<h1>Edit role</h1>
</div>

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
