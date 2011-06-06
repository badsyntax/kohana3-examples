<span class="asset-download asset-<?php echo $asset->mimetype->type?>">
	<a href="<?php echo $asset->url(TRUE)?>"><?php echo $asset->friendly_filename?></a> 
	(<?php echo Text::bytes($asset->filesize)?>)
</span>
