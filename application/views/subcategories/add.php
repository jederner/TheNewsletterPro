<?php
$this->load->helper('form');

// Form
$formData = array(
				'class'	=> 'frmSubcategory',
				'id' 	=> 'frmSubcategory'
			);

// Category 
$formCategory = array(
				'name'			=> 'Label',
				'id'			=> 'Label',
				'placeholder'	=> 'subcategory',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix'
            );

// Submit
$formSubmit = array(
				'name'	=> 'submit',
				'id'	=> 'submit',
				'value'	=> 'Submit'
			);
?>
<?php echo form_open("Subcategories/update/0/$parentID", $formData);?>
<table cellpadding='3' cellspacing='0'>
	<tr>
		<td>New Label</td>
		<td><?php echo form_input($formCategory); ?></td>
	</tr>
</table>

<?php echo form_submit($formSubmit); ?>

<?php echo form_close(); ?>