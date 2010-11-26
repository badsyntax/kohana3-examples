<div class="action-bar clear">

	<a href="<?php echo URL::site('admin/roles/add')?>" class="button add small helper-right">
		<span>Add role</span>
	</a>

	<h1>Roles</h1>
</div>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($roles as $role){?>
		<tr>
			<td><?php echo $role->id;?></td>
			<td>
				<?php echo HTML::anchor('admin/roles/edit/'.$role->id, $role->name)?>
			</td>
			<td><?php echo $role->description?></td>
		</tr>
		<?php }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4">
				<div style="float:right"><?php echo $page_links?></div>
				Showing <?php echo $roles->count()?> of <?php echo $total?> roles
			</td>	
		</tr>		
	</tfoot>   
</table>
