<h2>Edit Customer</h2>
<form action="<?php echo $html->url('/customers/edit/' . $html->tagValue('Customer/id')); ?>" method="post">
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
	<?php echo $html->hidden('Customer/id') ?>
	<div class="submit">
		<?php echo $html->submit('Save'); ?>
	</div>
</form>

