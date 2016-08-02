<?php
$this->load->helper('form');

// Form
$formData = array(
				'class'	=> 'login',
				'id' 	=> 'login'
			);

// Username
$formUser = array(
				'name'			=> 'username',
				'id'			=> 'username',
				'placeholder'	=> 'user.name',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix'
            );

// Password
$formPass = array(
				'name'			=> 'password',
				'id'			=> 'password',
				'placeholder'	=> 'password',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix'
			);

$formSubmit = array(
				'name'	=> 'submit',
				'id'	=> 'submit',
				'value'	=> 'Login'
			);



echo form_open('Login/authenticate', $formData);
echo form_input($formUser);	
echo form_password($formPass);
echo form_submit('login', 'Login');
echo form_close();