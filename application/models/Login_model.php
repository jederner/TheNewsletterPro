<?php
class Login_model extends CI_Model {

	var $isValid = false;

	public function __construct() {
		$this->load->database();
	}

	function createSessionVariables($objUser) {
		$_SESSION["UserLoggedIn"]		= true;
		$_SESSION["UserID"]				= $objUser->id;
		$_SESSION["UserDisplayName"] 	= $objUser->first_name . " " . $objUser->last_name;
		$_SESSION["UserRole"]			= $objUser->role;
		//$_SESSION["UserCompanyName"] = $objUser->company;

	}

	function validateCredentials($user, $password) {

		if(!empty($user) && !empty($password)) {
			$user = addslashes(trim($user));
			$password = addslashes(md5(trim($password)));

			$sql = "SELECT
						id,
						first_name,
						last_name,
						email,
						role
					FROM
						users
					WHERE
						status = 'active' AND
						email = \"$user\" AND
						password = \"$password\" LIMIT 1";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) {
				$row = $query->row();
				$this->createSessionVariables($row);
				redirect('/dashboard/view');
			}
			else {
				$_SESSION["DisplayMessage"] = "Could not log you in. Please try again.";
				redirect('/home');
			}
			
		}

	}
}