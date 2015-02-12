<h2>New Time</h2>
<form action="<?php echo $html->url('/times/add'); ?>" method="post">
	<div class="optional">
		<?php echo $form->labelTag('Time/start', 'Start'); ?>
		<?php //echo $html->dateTimeOptionTag('Time/start', 'MDY' , '24', $html->tagValue('Time/start'), array());?>
		<?php echo $html->input('Time/start', array('size' => '30')); ?>
		<?php echo $html->tagErrorMsg('Time/start', 'Please select the Start.'); ?>
	</div>
	<div class="optional">
		<?php echo $form->labelTag('Time/stop', 'Stop'); ?>
		<?php //echo $html->dateTimeOptionTag('Time/stop', 'MDY' , '24', $html->tagValue('Time/stop'), array());?>
		<?php echo $html->input('Time/stop', array('size' => '30')); ?>
		<?php echo $html->tagErrorMsg('Time/stop', 'Please select the Stop.'); ?>
	</div>
	<div class="optional">
		<?php echo $form->labelTag('Time/break', 'Break'); ?>
		<?php echo $html->input('Time/break', array('size' => '10')); ?>
		<?php echo $html->tagErrorMsg('Time/break', 'Please enter the Break.'); ?>
	</div>
	<div class="optional">
		<?php echo $form->labelTag('Time/customer_id', 'Customer'); ?>
		<?php echo $html->selectTag(
			'Time/customer_id',
			$customers,
			$html->tagValue('Time/customer_id'),
			array(),
			array(),
			true
		); ?>
		<?php echo $html->link('Add Customers', '/customers/add/'); ?>
		<?php echo $html->tagErrorMsg('Time/customer_id', 'Please select the Customer.') ?>
	</div>
	<div class="optional">
		<?php echo $form->labelTag('Time/task', 'Task'); ?>
		<?php echo $html->input('Time/task', array('size' => '60')); ?>
		<?php echo $html->tagErrorMsg('Time/task', 'Please enter Task/Project.') ?>
	</div>
	<div class="optional">
		<?php echo $form->labelTag('Time/note', 'Note'); ?>
		<?php echo $html->input('Time/note', array('size' => '60')); ?>
		<?php echo $html->tagErrorMsg('Time/note', 'Please enter the Note.'); ?>
	</div>
	<?php echo $html->hidden('Time/user_id', array('value' => $userid)) ?>
	<div class="submit">
		<?php echo $html->submit('Add'); ?>
	</div>
</form>
