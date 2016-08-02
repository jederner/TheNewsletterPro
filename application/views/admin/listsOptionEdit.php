<?php

$this->load->helper('form');

$ListUID 	= $option[0]["ListUID"];
$ListLabel	= $option[0]["ListLabel"];

// Form
$formData = array(
	'class'	=> 'frmListCategoryEdit',
	'id' 	=> 'frmListCategoryEdit'
);

// Category Name
$ListLabel = array(
	'name'			=> 'ListLabel',
	'id'			=> 'ListLabel',
	'placeholder'	=> 'List Name',
	'maxlength'		=> '50',
	'size'			=> '25',
	'class'			=> 'clearfix',
	'value'			=> $ListLabel
);

$formSubmit = array(
	'name'	=> 'submit',
	'id'	=> 'submit',
	'value'	=> 'Update'
);


echo anchor("/Admin/lists","Cancel");

echo form_open('Admin/listEntryUpdate', $formData);

echo form_hidden('ListUID',$ListUID);
?>

<br />
<table class="tblClientDetails" cellpadding="3" cellspacing="0">
	<tr>
		<td>New List Name:</td>
		<td><?php echo form_input($ListLabel); ?></td>
		<td><?php echo form_submit('Update', 'Update'); ?></td>
	</tr>
</table>