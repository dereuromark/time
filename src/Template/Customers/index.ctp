<div class="Customers">
	<h2>List Customers</h2>

	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Description</th>
			<th>Created</th>
			<th>Modified</th>
			<th>Actions</th>
		</tr>
		<?php foreach ($Customers as $Customer): ?>
			<tr>
				<td><?php echo $Customer['id']; ?></td>
				<td><?php echo $Customer['name']; ?></td>
				<td><?php echo $Customer['description']; ?></td>
				<td><?php echo $Customer['created']; ?></td>
				<td><?php echo $Customer['modified']; ?></td>
				<td class="actions">
					<?php echo $html->link('View', '/customers/view/' . $Customer['id']) ?>
					<?php echo $html->link('Edit', '/customers/edit/' . $Customer['id']) ?>
					<?php echo $html->link(
						'Delete',
						'/customers/delete/' . $Customer['id'],
						['confirm' => 'Are you sure you want to delete id ' . $Customer['id']]
					) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

</div>