<h2>New Customer</h2>
<form action="<?php echo $html->url('/customers/add'); ?>" method="post">
	<div class="optional">
		<?php echo $form->labelTag('Customer/name', 'Name'); ?>
		<?php echo $html->input('Customer/name', array('size' => '60')); ?>
		<?php echo $html->tagErrorMsg('Customer/name', 'Please enter the Name.'); ?>
	</div>
	<div class="optional">
		<?php echo $form->labelTag('Customer/description', 'Description'); ?>
		<?php echo $html->input('Customer/description', array('size' => '60')); ?>
		<?php echo $html->tagErrorMsg('Customer/description', 'Please enter the Description.'); ?>
	</div>
	<div class="submit">
		<?php echo $html->submit('Add'); ?>
	</div>
</form>
