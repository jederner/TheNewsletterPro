<?php
$this->load->helper('form');

// Form
$formData = array(
    'class' => 'frmCustomReport',
    'id' => 'frmCustomReport'
);


$formSubmit = array(
    'name' => 'submit',
    'id' => 'submit',
    'value' => 'Submit'
);
?>
<?php echo form_open('customreport/process', $formData); ?>
<div class='left' id='customReportCheckList'>
    <p>Show me...</p>
    <?php echo $checkboxList; ?>
    <?php echo form_submit('process', 'Process', $formSubmit); ?>
</div>
<div class='left' id='customReportResults'>
    <h1>Results</h1>
    <table id='results'><tr><td>Report will display here.</td></tr></table>
</div>
<div class='clearfix'></div>
<?php
echo form_close();
?>