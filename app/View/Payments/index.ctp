<div class="Payments">
	<h2>List Payments</h2>

	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>Id</th>
			<th>User</th>
			<th>Hours</th>
			<th>Rate</th>
			<th>Comment</th>
			<th>Created</th>
			<th>Actions</th>
		</tr>
		<?php foreach ($Payments as $Payment): ?>
			<tr>
				<td><?php echo $Payment['Payment']['id']; ?></td>
				<td><?php echo $Payment['User']['name']; ?></td>
				<td><?php echo $Payment['Payment']['hours']; ?></td>
				<td><?php echo $Payment['Payment']['rate']; ?></td>
				<td><?php echo $Payment['Payment']['comment']; ?></td>
				<td><?php echo $Payment['Payment']['created']; ?></td>
				<td class="actions">
					<?php echo $html->link('View', '/payments/view/' . $Payment['Payment']['id']) ?>
					<?php //echo $html->link('Edit','/payments/edit/' . $Payment['Payment']['id'])?>
					<?php //echo $html->link('Delete','/payments/delete/' . $Payment['Payment']['id'], null, 'Are you sure you want to delete id ' . $Payment['Payment']['id'])?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

	<?php if ($groupid == 1) { ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th>User</th>
				<th>akt. Monat</th>
				<th>vor. Monat</th>
				<th>Jahr</th>
			</tr>
			<?php foreach ($statistics as $stat_user => $stat_value): ?>
				<tr>
					<td><?php echo $stat_user ?></td>
					<td><?php echo $stat_value['this_month_hours'] . 'h | ' . $stat_value['this_month_amount'] . ' EUR '; ?></td>
					<td><?php echo $stat_value['last_month_hours'] . 'h | ' . $stat_value['last_month_amount'] . ' EUR '; ?></td>
					<td><?php echo $stat_value['year_hours'] . 'h | ' . $stat_value['year_amount'] . ' EUR '; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php } ?>

</div>