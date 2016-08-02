<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function authenticate() {
		if(!empty($_POST["username"])) {
			$user = $_POST['username'];
			$user =	trim(str_replace("@thenewsletterpro.com", "", $user));
			$user .= "@thenewsletterpro.com";
			$password =	$_POST['password'];

			$this->load->model('Login_model');

			$this->Login_model->validateCredentials($user,$password);
		}
		
		$_SESSION["DisplayMessage"] = "Could not log you in. Please try again.";
		redirect("/home");
	}

	public function signout() {
		session_unset();
		$_SESSION["DisplayMessage"] = "You have successfully signed out.";
		redirect('/home');
	}
}