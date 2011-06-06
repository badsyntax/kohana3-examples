<div class="clear">
	<div class="action-bar">
		<div class="action-menu helper-right">
			<button>Actions</button>
			<ul>
				<li><?php echo HTML::anchor('admin/assets/upload', __('Upload assets'))?></li>
				<li><?php echo HTML::anchor('admin/config/group/asset', __('Edit config'), array('id' => 'edit-config'))?></li>
				<li><?php echo HTML::anchor('admin/assets/delete', __('Delete assets'), array('id' => 'delete-assets'))?></li>
			</ul>
		</div>
	</div>	

	<?php echo $breadcrumbs?>
</div>
	
<h1>Assets</h1>

<fieldset style="padding:.6em .8em;margin-top:.5em">
	<div id="page-links">
		<div style="float:right"><?php echo $pagination->render()?></div>
		Showing <?php echo $assets->count()?> of <?php echo $total?> assets
	</div>
</fieldset>

<form id="assets-list">
	<fieldset>	
		<div class="assets-list view-list ui-grid clear">
		<table>
			<thead>
				<tr>
					<th>
						<a href="<?php echo URL::site('admin/assets?sort=filename&direction='.$reverse_direction.'&page='.$pagination->current_page)?>">
							Filename
							<span 
							title="sort ascending" 
							class="ui-icon <?php echo ($order_by == 'filename' AND $reverse_direction == 'asc') ? 'ui-icon-triangle-1-n' : 'ui-icon-triangle-1-s'?>"></span>
						</a>
					</th>
					<th>
						<a href="<?php echo URL::site('admin/assets?sort=type&direction='.$reverse_direction.'&page='.$pagination->current_page)?>">
							Type 
							<span 
							title="sort ascending" 
							class="ui-icon <?php echo ($order_by == 'type' AND $reverse_direction == 'asc') ? 'ui-icon-triangle-1-n' : 'ui-icon-triangle-1-s'?>"></span>
						</a>
					</th>
					<th>
						<a href="<?php echo URL::site('admin/assets?sort=filesize&direction='.$reverse_direction.'&page='.$pagination->current_page)?>">
							Size
							<span 
							title="sort ascending" 
							class="ui-icon <?php echo ($order_by == 'filesize' AND $reverse_direction == 'asc') ? 'ui-icon-triangle-1-n' : 'ui-icon-triangle-1-s'?>"></span>
						</a>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($assets as $asset){?>
				<tr>
					<td>
						<a href="<?php echo URL::site('admin/assets/edit/'.$asset->id)?>" class="helper-left" style="background:transparent;padding:0">
							<?php if ($asset->is_text_document()){?>
								<img src="/modules/admin/media/img/assets/page-white-text.png" class="asset-thumb helper-left" />
							<?php } else if ($asset->is_archive()){?>
							 	<img src="/modules/admin/media/img/assets/page-white-zip.png" class="asset-thumb helper-left" />
							<?php } else {?>
								<img src="<?php echo URL::site($asset->image_url(60, 60, TRUE))?>" class="asset-thumb helper-left" />
							<?php }?>
						</a>
						<input type="checkbox" class="checkbox helper-left" name="asset-<?php echo $asset->id?>" value="<?php echo $asset->id?>" id="asset-<?php echo $asset->id?>" style="margin-right:5px;margin-left:5px"/>
						<?php echo HTML::anchor('admin/assets/edit/'.$asset->id, $asset->friendly_filename, array(
							'class' => 'asset'
						))?>
					<br /><br />
					<div class="helper-left" style="padding-left:6px;color:#888">
					<?php echo $asset->friendly_date()?>
					</div>

					</td>
					<td>
						<a 
						href="<?php echo URL::site('admin/assets?sort='.$order_by.'&direction='.$direction.'&page='.$pagination->current_page.'&filter=type|'.$asset->mimetype->type)?>" 
						class="asset-type subtype-<?php echo $asset->mimetype->subtype?> type-<?php echo $asset->mimetype->type?>">
							<?php echo $asset->mimetype->extension?>
						</a>
					</td>
					<td><?php echo Text::bytes($asset->filesize)?></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		</div>
	</fieldset>
</form>

<fieldset class="last">
	<div id="page-links">
		<div style="float:right"><?php echo $pagination->render()?></div>
		Showing <?php echo $assets->count()?> of <?php echo $total?> assets
	</div>
</fieldset>
