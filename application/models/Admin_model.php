<?php
class Admin_model extends CI_Model {

	public function __construct() {
		$this->load->database();
		if(empty($_SESSION["UserLoggedIn"]) || ($_SESSION["UserRole"]!=="admin")) {
			redirect(base_url()."index.php/Pages/view/home");
		}
	}

	public function getTeamMemberNameById($id) {
		$name = "default";
		$sql = "SELECT concat(first_name,' ',last_name) as name FROM `users` WHERE id=$id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$name = $row->name;
			}
		}
		return $name;
	}

	public function getTeamMemberDetails($id) {
		$arrDetails = array();
		$sql = "
			SELECT
				a.*,
				b.*
			FROM
				users a
			left join
				lists b 
			on
				b.ListUID = a.team 
			WHERE
				id=$id
		";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"id"		=>$row->id,
								"company"	=>$row->company_name,
								"fname"		=>$row->first_name,
								"lname"		=>$row->last_name,
								"status"	=>$row->status,
								"email"		=>$row->email,
								"phone"		=>$row->phone,
								"team"		=>$row->ListLabel,
								"teamID"	=>$row->ListUID,
                                                                "userrole"      =>$row->userrole,
                                                                "department"    =>$row->department
							);
				array_push($arrDetails,$arrCurrent);
			}
		}
		return $arrDetails;
	}

	public function getTeamMembersArray() {
		$arrTeamMembers = array();
		$sql = "SELECT a.*, b.* FROM users a left join lists b on b.ListUID = a.team where role = 'team member' order by last_name";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"id"		=>$row->id,
								"company"	=>$row->company_name,
								"fname"		=>$row->first_name,
								"lname"		=>$row->last_name,
								"status"	=>$row->status,
								"email"		=>$row->email,
								"phone"		=>$row->phone,
								"team"		=>$row->ListLabel
							);
				array_push($arrTeamMembers,$arrCurrent);
			}
		}
		return $arrTeamMembers;
	}

	public function setBulkReassign($source,$destination) {
		$data = array(
					'owned_by' 	=> $destination
				);

		$this->db->where('owned_by', $source);
		$this->db->update('users', $data);
		return $this->db->affected_rows();
	}

}
?>