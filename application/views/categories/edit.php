<?php
$this->load->helper('form');

foreach($arrCategory as $item) {
	$label 	= $item["Label"];
	$id		= $item["UID"];
}

// Form
$formData = array(
				'class'	=> 'frmCategory',
				'id' 	=> 'frmCategory'
			);

// Category 
$formCategory = array(
				'name'			=> 'Label',
				'id'			=> 'Label',
				'placeholder'	=> 'category',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix',
				'value'			=> $label
            );

// Submit
$formSubmit = array(
				'name'	=> 'submit',
				'id'	=> 'submit',
				'value'	=> 'Submit'
			);
?>
<?php echo form_open('Categories/update/' . $id, $formData);?>
<table cellpadding='3' cellspacing='0'>
	<tr>
		<td>New Label</td>
		<td><?php echo form_input($formCategory); ?></td>
	</tr>
</table>

<?php echo form_submit($formSubmit); ?>

<?php echo form_close(); ?>