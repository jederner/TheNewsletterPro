<?php

$this->load->helper('form');

// Form
$formData = array(
	'class'	=> 'frmListCategoryAdd',
	'id' 	=> 'frmListCategoryAdd'
);

// Category Name
$categoryName = array(
	'name'			=> 'categoryName',
	'id'			=> 'categoryName',
	'placeholder'	=> 'List Name',
	'maxlength'		=> '50',
	'size'			=> '25',
	'class'			=> 'clearfix'
);

$formSubmit = array(
	'name'	=> 'submit',
	'id'	=> 'submit',
	'value'	=> 'Add'
);


echo anchor("/Admin/lists","Cancel");

echo form_open('Admin/addNewList', $formData);?>
<br />
<table class="tblClientDetails" cellpadding="3" cellspacing="0">
	<tr>
		<td>New List Name:</td>
		<td><?php echo form_input($categoryName); ?></td>
		<td><?php echo form_submit('Add', 'Add'); ?></td>
	</tr>
</table>