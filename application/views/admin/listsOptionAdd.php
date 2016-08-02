<?php

$this->load->helper('form');


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
	'class'			=> 'clearfix'
);

$formSubmit = array(
	'name'	=> 'submit',
	'id'	=> 'submit'
);


echo anchor("/Admin/lists","Cancel");

echo form_open("Admin/listEntryAdd/$ListType", $formData);
echo form_hidden("ListType",$ListType);
?>

<br />
<table class="tblClientDetails" cellpadding="3" cellspacing="0">
	<tr>
		<td>New List Name:</td>
		<td><?php echo form_input($ListLabel); ?></td>
		<td><?php echo form_submit('Add', 'Add'); ?></td>
	</tr>
</table>
<?php
echo form_close();
?>