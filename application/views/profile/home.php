<?php
$this->load->helper('form');

$first_name	= $arrProfile["first_name"];
$last_name	= $arrProfile["last_name"];
$email	= $arrProfile["email"];
$phone	= $arrProfile["phone"];
    
// Form
$formData = array(
    'class' => 'frmProfile',
    'id'    => 'frmProfile'
);

// First Name
$formFirstName = array(
    'name'          => 'first_name',
    'id'            => 'first_name',
    'placeholder'   => 'first name',
    'maxlength'     => '50',
    'size'          => '25',
    'class'         => 'clearfix',
    'value'         => $first_name
);

$formLastName = array(
    'name'          => 'last_name',
    'id'            => 'last_name',
    'placeholder'   => 'last name',
    'maxlength'     => '50',
    'size'          => '25',
    'class'         => 'clearfix',
    'value'         => $last_name
);

$formPassword = array(
    'name'          => 'password',
    'id'            => 'password',
    'placeholder'   => 'enter to reset password',
    'maxlength'     => '50',
    'size'          => '25',
    'class'         => 'clearfix'
);

$formPhone = array(
    'name'          => 'phone',
    'id'            => 'phone',
    'placeholder'   => 'ex. 831-555-1234',
    'maxlength'     => '12',
    'size'          => '15',
    'class'         => 'clearfix',
    'value'         => $phone
);

$formEmail = array(
    'name'          => 'email',
    'id'            => 'email',
    'placeholder'   => 'email@example.com',
    'maxlength'     => '100',
    'size'          => '25',
    'class'         => 'clearfix',
    'value'         => $email
);

$formSubmit = array(
    'name'  => 'submit',
    'id'    => 'submit',
    'value' => 'Submit'
);

?>
<?php echo form_open('profile/update', $formData);?>
<table class="tblClientDetails" cellpadding="3" cellspacing="0">		
    <tr>
        <td>First Name</td>
        <td><?php echo form_input($formFirstName); ?></td>
    </tr>
    <tr>
        <td>Last Name</td>
        <td><?php echo form_input($formLastName); ?></td>
    </tr>
    <tr>
        <td>Password</td>
        <td><?php echo form_password($formPassword); ?></td>
    </tr>
    <tr>
        <td>Phone</td>
        <td><?php echo form_input($formPhone); ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?php echo form_input($formEmail); ?></td>
    </tr>
</table>
<?php
echo form_submit('update', 'Update');
echo form_close();
?>