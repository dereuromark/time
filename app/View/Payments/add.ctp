<h2>New Payment</h2>
<form action="<?php echo $html->url('/payments/add'); ?>" method="post">
	<div>
		<?php echo $form->labelTag('Payment/user_id', 'User'); ?>
		<?php echo $html->selectTag(
			'Payment/user_id',
			$Users,
			$html->tagValue('Payment/user_id'),
			array(),
			array(),
			true
		); ?>
		<?php echo $html->tagErrorMsg('Payment/user_id', 'Please select the User.') ?>
	</div>
	<div>
		<?php echo $form->labelTag('Payment/hours', 'Hours'); ?>
		<?php echo $html->input('Payment/hours', array('size' => '20')); ?>
		<?php echo $html->tagErrorMsg('Payment/hours', 'Please enter the amount of hours'); ?>
	</div>
	<div>
		<?php echo $form->labelTag('Payment/comment', 'Comment'); ?>
		<?php echo $html->input('Payment/comment', array('size' => '40')); ?>
		<?php echo $html->tagErrorMsg('Payment/hours', 'Please enter a comment'); ?>
	</div>
	<?php echo $html->hidden('Payment/rate', array('value' => 12)) ?>

	<div class="submit">
		<?php echo $html->submit('Add'); ?>
	</div>
</form>
