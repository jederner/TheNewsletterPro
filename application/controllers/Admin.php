<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function view($page="home")
	{

		if ( ! file_exists(APPPATH.'/views/admin/'.$page.'.php'))
		{
			show_404();
		}

		$data['siteTitle'] = "The NewsletterPro";
		$data['title'] = "Admin - " . ucfirst($page); // Capitalize the first letter
		$data['assets'] = asset_url();

		$this->load->model('Admin_model');

		$this->load->view('templates/header', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}

	public function Lists($page="lists") {
		if ( ! file_exists(APPPATH.'/views/admin/'.$page.'.php'))
		{
			show_404();
		}

		$data['siteTitle'] = "The NewsletterPro";
		$data['title'] = "Admin - Lists";
		$data['assets'] = asset_url();

		$this->load->model('Admin_model');
		$this->load->model('List_model');

		$data['lists'] = $this->List_model->getLists();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}

	public function listsOptionToggle($optionID,$active=0) {
		if(!is_numeric($optionID)) {
			echo is_bool($active) . "**<Br />" . is_numeric($optionID);
			show_404();
		}

		$data = array(
			'Active'	=> $active
		);

		$this->db->where('ListUID', $optionID);
		$this->db->update('lists', $data);
		
		$_SESSION["DisplayMessage"] = "Record updated successfully.";

		redirect("/Admin/lists");
	}

	public function listsCategoryAdd() {
		if ( ! file_exists(APPPATH.'/views/admin/listsCategoryAdd.php'))
		{
			show_404();
		}

		$data['siteTitle'] = "The NewsletterPro";
		$data['title'] = "Admin - Add New List";
		$data['assets'] = asset_url();

		$this->load->model('Admin_model');
		$this->load->model('List_model');

		$data['lists'] = $this->List_model->getLists();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/listsCategoryAdd', $data);
		$this->load->view('templates/footer', $data);
	}

	public function listsOptionAdd($category) {
		if ( ! file_exists(APPPATH.'/views/admin/listsOptionAdd.php'))
		{
			show_404();
		}

		$category = urldecode($category);

		$data['siteTitle'] = "The NewsletterPro";
		$data['title'] = "Admin - Lists - $category - Add New Option";
		$data['assets'] = asset_url();
		$data['ListType'] = $category;

		$this->load->model('Admin_model');
		$this->load->model('List_model');

		$categoryLabel = $this->List_model->getLabelById($category);
		$data['lists'] = $this->List_model->getLists();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/listsOptionAdd', $data);
		$this->load->view('templates/footer', $data);
	}

	public function listsOptionEdit($optionID) {
		if(is_numeric($optionID)) {
			$data['siteTitle'] = "The NewsletterPro";
			$data['title'] = "Admin - Edit List Option";
			$data['assets'] = asset_url();

			$this->load->model('Admin_model');
			$this->load->model('List_model');

			$data['option'] = $this->List_model->getListArrayById($optionID);

			$this->load->view('templates/header', $data);
			$this->load->view('admin/listsOptionEdit', $data);
			$this->load->view('templates/footer', $data);
		}
		else {
			show_404();
		}
	}

	public function listEntryUpdate() {
		$ListUID	= $_POST["ListUID"];
		$ListLabel 	= trim($_POST["ListLabel"]);

		if(!is_numeric($ListUID) || empty($ListLabel)) {
			show_404();
		}

		 $data = array(
			'ListUID' 	=> $ListUID,
			'ListLabel'		=> $ListLabel
		);

		$this->db->where('ListUID', $ListUID);
		$this->db->update('lists', $data);

		$_SESSION["DisplayMessage"] = "Record updated successfully.";

		redirect("/Admin/lists");
	}

	public function listEntryAdd($ListType) {
		$ListLabel 	= trim($_POST["ListLabel"]);
		$ListLabel	= urldecode($ListLabel);

		if(empty($ListLabel)) {
			show_404();
		}

		 $data = array(
		 	'ListType'	=> $ListType,
			'ListLabel'	=> $ListLabel,
			'Active'	=> '1'
		);

		$this->db->insert('lists', $data);

		$_SESSION["DisplayMessage"] = "Record added successfully.";

		redirect("/Admin/listsOptionAdd/$ListType");
	}

	public function addNewList() {
		$category 	= trim($_POST["categoryName"]);
		if(!empty($category)) {
			$data = array(
				'ListType' 	=> $category,
				'ListLabel'	=> "default",
				'active'	=> "0"
			);

			$this->db->insert('lists', $data);
			$_SESSION["DisplayMessage"] = "Record added successfully.";
			redirect("/Admin/lists");
		}
		else {
			$_SESSION["DisplayMessage"] = "Please fill out the form.";
			redirect("/Admin/listsCategoryAdd");
		}
	}

	public function updateTeamMember() {

		$this->load->model('Admin_model');
		
		$fname		= $_POST["fname"];
		$lname		= $_POST["lname"];
		$password	= $_POST["password"];
		$status		= $_POST["status"];
		$phone		= $_POST["phone"];
		$email		= $_POST["email"] . "@thenewsletterpro.com";
		$id			= $_POST["id"];
		$team 		= $_POST["team"];
                $department     = $_POST["department"];
                $userrole       = $_POST["userrole"];

		if($team==="") {
                    $team = null;
		}

		if($id==="0") { // new record

                    $data = array(
                            'first_name' 	=> $fname,
                            'last_name'		=> $lname,
                            'email'		=> $email,
                            'status'		=> $status,
                            'phone'		=> $phone,
                            'password'		=> md5($password),
                            'role'		=> 'team member',
                            'team'              => $team,
                            'department'        => $department,
                            'userrole'          => $userrole
                    );

                    $this->db->insert('users', $data);
                    $_SESSION["DisplayMessage"] = "Record added successfully.";

                    //echo "Valid email.<br />";
                    $this->load->library('email');
                    $this->load->model('Email_model');
                    $config = $this->Email_model->getConfig();
                    $this->email->initialize($config);
                    $this->email->from('website@newsletterpro.biz');
                    $this->email->to($email);
                    $this->email->subject('Welcome to the Newsletter Pro');
                    $this->email->message("Welcome, $fname!<br /><br />"
                            . "You have been added to the <a href='http://www.newsletterpro.biz'>"
                            . "Newsletter Pro</a> website! You may log in with password $password.<br /><br />"
                            . "We look forward to seeing you there!<br /><br />- The Newsletter Pro Team");
                    $this->email->send();

                    //echo $this->email->print_debugger();

                    redirect("Admin/teamMembers");

		}
		else { // update record
			$data = array(
				'first_name' 	=> $fname,
				'last_name'		=> $lname,
				'email'			=> $email,
				'status'		=> $status,
				'phone'			=> $phone,
				'team'			=> $team,
                                'department'            => $department,
                                'userrole'              => $userrole
			);

			$this->db->where('id', $id);
			$this->db->update('users', $data);

			$_SESSION["DisplayMessage"] = "Record updated successfully.";

			if(!empty($password)) {
				$data = array(
					'password' =>md5($password)
				);

				$this->db->where('id', $id);
				$this->db->update('users', $data);

				$_SESSION["DisplayMessage"] .= " Password reset.";
			}

			redirect("Admin/editTeamMembers/$id");
		}
	}

	public function bulkReassign() {

		$this->load->model('Admin_model');

		if(!empty($_POST["sourceMember"])) {
			$source = $_POST["sourceMember"];
			$destination = $_POST["destinationMember"];
			$moved = $this->Admin_model->setBulkReassign($source,$destination);
			$_SESSION["DisplayMessage"] = "$moved clients reassigned.";
		}
		$data['siteTitle'] = "The NewsletterPro";
		$data['title'] = "Admin - Bulk Reassign";
		$data['assets'] = asset_url();

		$data['teamList'] = $this->Admin_model->getTeamMembersArray();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/bulkReassign', $data);
		$this->load->view('templates/footer', $data);
	}

	public function teamMembers() {

		$this->load->model('Admin_model');

		$data['siteTitle'] = "The NewsletterPro";
		$data['title'] = "Admin - Team Members";
		$data['assets'] = asset_url();

		$data['teamList'] = $this->Admin_model->getTeamMembersArray();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/teamMembers', $data);
		$this->load->view('templates/footer', $data);
	}

	public function reports($id=null) {
		$this->load->model('Admin_model');
		$data['siteTitle'] = "The NewsletterPro";
		$data['title'] = "Admin - Reports";
		$data['assets'] = asset_url();

		if(is_null($id)) {
			$this->load->view('templates/header', $data);
			$this->load->view('admin/reports', $data);
			$this->load->view('templates/footer', $data);
		}
		else {
			$this->load->model('Report_model');
			$data['total'] = false;
			switch ($id) {
				case '1':
					$data['report'] = $this->Report_model->getActiveClients();
					$data['title'] = $data['title'] . " - Active Clients";
					break;

				case '2':
					$data['report'] = $this->Report_model->getCancelledClients();
					$data['title'] = $data['title'] . " - Cancelled Clients";
					break;

				case '3':
					$data['report'] = $this->Report_model->getOnHoldClients();
					$data['title'] = $data['title'] . " - On Hold Clients";
					break;

				case '4':
					$data['report'] = $this->Report_model->getCampaignsBilled();
					$data['title'] = $data['title'] . " - Campaigns Billed";
					$data['total'] = true;
					break;

				case '5':
					$data['report'] = $this->Report_model->getPiecesMailed();
					$data['title'] = $data['title'] . " - Pieces Mailed";
					$data['total'] = true;
					break;

				case '6':
					$data['report'] = $this->Report_model->getVersions();
					$data['title'] = $data['title'] . " - Versions";
					$data['total'] = true;
					break;
				
				default:
					$data['report'] = null;
					break;
			}
			$data['loadExports'] = true;
			$this->load->view('templates/header', $data);
			$this->load->view('admin/reports-output', $data);
			$this->load->view('templates/footer', $data);
		}
	}

	public function editTeamMembers($teamId) {

		$this->load->model('Admin_model');
		$this->load->model('List_model');

		$data['memberName']	= $this->Admin_model->getTeamMemberNameById($teamId);
		$data['details']	= $this->Admin_model->getTeamMemberDetails($teamId);
                $data['rolesHTML']      = $this->List_model->getSelectListFromString("role","userrole",$data['details'][0]['userrole']);
                $data['departmentsHTML']= $this->List_model->getSelectListFromString("departments","department",$data['details'][0]['department']);
                //$listName,$fieldName,$fieldValue=null
		$data['teamList']	= $this->List_model->getList("team");
		$data['siteTitle'] = "The NewsletterPro";
		$data['title'] = "Admin - Team Member - " . $data['memberName'];
		$data['assets'] = asset_url();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/editTeamMembers', $data);
		$this->load->view('templates/footer', $data);
	}

	public function deleteTeamMember($id) {
		$this->load->model('Admin_model');
		$this->db->where('id',$id);
		$this->db->delete('users');
		$_SESSION["DisplayMessage"] = "Team member successfully deleted.";
		redirect("Admin/teamMembers");
	}

	public function addTeamMembers() {

		$this->load->model('Admin_model');
		$this->load->model('List_model');

		$data['siteTitle'] = "The NewsletterPro";
		$data['title'] = "Admin - Add Team Member";
		$data['assets'] = asset_url();
		$data['teamList']	= $this->List_model->getList("team");
                $data['rolesHTML']      = $this->List_model->getSelectListFromString("role","userrole");
                $data['departmentsHTML']= $this->List_model->getSelectListFromString("departments","department");

		$this->load->view('templates/header', $data);
		$this->load->view('admin/addTeamMembers', $data);
		$this->load->view('templates/footer', $data);

	}
}