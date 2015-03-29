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
				<td><?php echo $Customer['Customer']['id']; ?></td>
				<td><?php echo $Customer['Customer']['name']; ?></td>
				<td><?php echo $Customer['Customer']['description']; ?></td>
				<td><?php echo $Customer['Customer']['created']; ?></td>
				<td><?php echo $Customer['Customer']['modified']; ?></td>
				<td class="actions">
					<?php echo $html->link('View', '/customers/view/' . $Customer['Customer']['id']) ?>
					<?php echo $html->link('Edit', '/customers/edit/' . $Customer['Customer']['id']) ?>
					<?php echo $html->link(
						'Delete',
						'/customers/delete/' . $Customer['Customer']['id'],
						null,
						'Are you sure you want to delete id ' . $Customer['Customer']['id']
					) ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

</div>