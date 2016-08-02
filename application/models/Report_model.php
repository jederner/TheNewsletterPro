<?php
class Report_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

	public function getActiveClients() {
		$arrList = array(
				array("Company","First Name","Last Name")
			);
		$sql = "SELECT * FROM users where role='client' and status='active'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"company_name"	=>$row->company_name,
								"first_name"	=>$row->first_name,
								"last_name"		=>$row->last_name
							);
				array_push($arrList,$arrCurrent);
			}
		}
		return $arrList;
	}
	
	public function getClientAuditList() {
		$arrList = array(
				array("Company Name","First Name","Last Name","Email Address","Phone Number","Mail Date","Project Manager","Package Type","List Type","Versions","Demographics","Project Manager","Date Sold","Date Onboarded","Sale Source","Campaigns Billed","Pieces Billed","Price Per Pieces","Team","Writer","Designer","Total Pages","Unique Pages","Custom Content","Filler Content","Client Submitted Content","Side Campaigns","Mailing Schedule","Layout Guide")
		);
		$sql = "SELECT * FROM users where role='client'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
					"company_name" =>$row->company_name,
					"first_name" =>$row->first_name,
					"last_name" =>$row->last_name,
					"email" =>$row->email,
					"phone" =>$row->phone,
					"mail_date" =>$row->mail_date,
					"owned_by" =>$row->owned_by,
					"package_type" =>$row->package_type,
					"list_size" =>$row->list_size,
					"versions" =>$row->versions,
					"demographics" =>$row->demographics,
					"project_manager" =>$row->project_manager,
					"date_sold" =>$row->date_sold,
					"date_onboarded" =>$row->date_onboarded,
					"sale_source" =>$row->sale_source,
					"campaigns_billed" =>$row->campaigns_billed,
					"pieces_mailed" =>$row->pieces_mailed,
					"price_per_pieces" =>$row->price_per_pieces,
					"team" =>$row->team,
					"writer" =>$row->writer,
					"designer" =>$row->designer,
					"total_pages" =>$row->total_pages,
					"unique_pages" =>$row->unique_pages,
					"custom_content" =>$row->custom_content,
					"filler_content" =>$row->filler_content,
					"client_submitted_content" =>$row->client_submitted_content,
					"side_campaigns" =>$row->side_campaigns,
					"mailing_schedule" =>$row->mailing_schedule,
					"layout_guide" =>$row->layout_guide
				);
				array_push($arrList,$arrCurrent);
			}
		}
		return $arrList;
	}

	public function getCancelledClients() {
		$arrList = array(
				array("Company","First Name","Last Name")
			);
		$sql = "SELECT * FROM users where role='client' and status='cancelled'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"company_name"	=>$row->company_name,
								"first_name"	=>$row->first_name,
								"last_name"		=>$row->last_name
							);
				array_push($arrList,$arrCurrent);
			}
		}
		return $arrList;
	}

	public function getOnHoldClients() {
		$arrList = array(
				array("Company","First Name","Last Name")
			);
		$sql = "SELECT * FROM users where role='client' and status='on hold'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"company_name"	=>$row->company_name,
								"first_name"	=>$row->first_name,
								"last_name"		=>$row->last_name
							);
				array_push($arrList,$arrCurrent);
			}
		}
		return $arrList;
	}

	public function getCampaignsBilled() {
		$arrList = array(
				array("Company","Campaigns Billed")
			);
		$sql = "select company_name, campaigns_billed from users where role='client' order by company_name";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"company_name"		=>$row->company_name,
								"campaigns_billed"	=>$row->campaigns_billed
							);
				array_push($arrList,$arrCurrent);
			}
		}
		return $arrList;
	}

	public function getPiecesMailed() {
		$arrList = array(
				array("Company","Pieces Mailed")
			);
		$sql = "select company_name, pieces_mailed from users where role='client' order by company_name";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"company_name"	=>$row->company_name,
								"pieces_mailed"	=>$row->pieces_mailed
							);
				array_push($arrList,$arrCurrent);
			}
		}
		return $arrList;
	}

	public function getVersions() {
		$arrList = array(
				array("Company","Versions")
			);
		$sql = "select company_name, versions from users where role='client' order by company_name";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"company_name"	=>$row->company_name,
								"versions"		=>$row->versions
							);
				array_push($arrList,$arrCurrent);
			}
		}
		return $arrList;
	}

}
?>