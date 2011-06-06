<fieldset class="clear">
	<legend>Preview</legend>
	
	<div style="float:left;margin-right:10px;min-height: 190px;min-width:200px;">
		<a 
			href="<?php echo $asset->image_url(600, 600, NULL, TRUE)?>" 
			data-type="<?php echo $asset->is_pdf() ? 'image' : $asset->mimetype->subtype?>" 
			class="thumb popup-ui-lightbox" 
			title="<?php echo $asset->description?>">

			<?php if ($asset->is_text_document()){?>
				<img src="/modules/admin/media/img/assets/page-white-text.png" style="border:1px solid #ccc;padding:3px;" />
			<?php } else if ($asset->is_archive()){?>
				<img src="/modules/admin/media/img/assets/page-white-zip.png" style="border:1px solid #ccc;padding:3px;" />
			<?php } else {?>
				<img src="<?php echo URL::site($asset->image_url(300, 300))?>" style="border:1px solid #ccc;padding:3px;" />
			<?php }?>

		</a>
	</div>
	<div class="asset-preview">
		<p>
			<strong><?php echo __('Filename')?>:</strong> <?php echo $asset->friendly_filename?>
		</p>
		<p>
			<strong><?php echo __('Description:')?></strong> <?php echo $asset->description?>
		</p>
		<p>
			<strong><?php echo __('Uploaded:')?></strong> <?php echo $asset->friendly_date()?>
		<p>
			<strong><?php echo __('Mimetype:')?></strong> <?php echo $asset->mimetype->subtype.'/'.$asset->mimetype->type?> 
		</p>
		<?php if ($asset->is_image()){?>
		<p>
			<strong>Dimensions:</strong> <span class="asset-width"><?php echo $asset->width?></span> x <span class="asset-height"><?php echo $asset->height?></span> px
		</p>
		<?php }?>
		<p>
			<strong>Filesize:</strong> <?php echo Text::bytes($asset->filesize)?>
		</p>
		<p>
			<?php if ($asset->is_image()){?>
				<?php echo Form::button('insert', 'Insert', array('type' => 'button', 'id' => 'insert-'.$asset->id, 'class' => 'insert-asset ui-button save'))?>
				     <?php echo Form::button(
							'resize',
							'Resize', 
							array(
								'type' => 'button',
								'class' => 'resize-asset ui-button resize'
							))?>

			<?php } else {?>
				<?php echo Form::button('insert', 'Insert', array('type' => 'button', 'id' => 'insert-'.$asset->id, 'class' => 'insert-asset ui-button save'))?>
			<?php }?>
			<?php echo HTML::anchor('/admin/assets/popup/download/'.$asset->id, 'Download', array('class' => 'ui-button download'))?>
		</p>
	</div>
</fieldset>
