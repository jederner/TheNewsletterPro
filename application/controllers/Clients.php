<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {
	
	public function view($page="home")
	{
		if ( ! file_exists(APPPATH.'/views/clients/'.$page.'.php'))
		{
			show_404();
		}

		$data['siteTitle'] = "The NewsletterPro";
		$data['title'] = "Clients - " . ucfirst($page); // Capitalize the first letter
		$data['assets'] = asset_url();

		$this->load->model('Clients_model');
		$this->load->model('List_model');

		$data['clientList'] = $this->Clients_model->getClientsArray();
		$data["teamMembers"]	= $this->Clients_model->getTeamMembersArray();
		$data["teamsList"]		= $this->List_model->getList("team");
		$data["schedule"]		= $this->List_model->getList("mailing schedule");
		$data["demographics"]	= $this->List_model->getList("Demographics");


		$this->load->view('templates/header', $data);
		$this->load->view('clients/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}

	public function assignArticles($clientId,$articleId=null,$edition=null) {

		$this->load->model('Clients_model');

		if(is_null($articleId)) { // display page

			$data['siteTitle']	= "The NewsletterPro";
			$data['company']	= $this->Clients_model->getCompanyNameById($clientId);
			$data['title']		= "Clients - Assign Articles - " . $data['company']; // Capitalize the first letter
			$data['assets']		= asset_url();

			$data['articles']	= $this->Clients_model->getArticlesToAssign($clientId);
			$data['clientId']	= $clientId;
			$data['demographicsAvailable'] = $this->Clients_model->getDemographicsAvailable();
			$data['categoriesAvailable'] = $this->Clients_model->getCategoriesAvailable();
			
			$this->load->model('Articles_model');
			$data['assignDate'] = $this->Articles_model->getAssignArticleDate();

			$this->load->view('templates/header', $data);
			$this->load->view('clients/assignArticles', $data);
			$this->load->view('templates/footer', $data);
		}
		else {
			if(!is_numeric($articleId)) {
				show_404();
			}

			$data = array(
				'user_id' => $clientId,
				'article_id' => $articleId,
				'edition' => $edition . "-01"
			);

			$this->db->insert('assigned_articles', $data);

			$_SESSION["DisplayMessage"] = "Article assigned successfully.";

			redirect("Clients/assignArticles/$clientId");
		}
		
	}

	public function unassignArticle($clientId,$articleId,$temp=null) {
		
		$this->load->model('Clients_model');

		if(!empty($clientId) && !empty($articleId)) {

			$whereData = array(
				"user_id" => $clientId,
				"article_id" => $articleId
			);

			$this->db->where($whereData);

			if(!is_null($temp)) {
				$this->db->delete('assigned_articles');
			}
			else {
				$data = array(
					'unassigned' => "1"
				);
				$this->db->update('assigned_articles', $data);
			}

			$_SESSION["DisplayMessage"] = "Article unassigned successfully.";

			redirect("clients/details/$clientId");
		}
		else {
			show_404();
		}
	}

	public function delete($id) {
		if($_SESSION["UserRole"]=="admin") {

			if(is_numeric($id)) {
				$whereData = array(
						"id" => $id
					);
				$this->db->where($whereData);
				$this->db->delete("users");

				$whereData = array(
						"user_id" => $id
					);
				$this->db->where($whereData);
				$this->db->delete("assigned_articles");
			}
			$_SESSION["DisplayMessage"] = "Client deleted successfully.";
			
		}
		redirect("clients/view");
	}
        
        /* 
         * This is an AJAX call
         */
        public function addSecondaryContact($firstname=null, $lastname=null, $email=null, $phone=null, $client) {
            if(!is_numeric($client)) {
                show_404();
            }
            
            if($firstname==="null") { $firstname = null; }
            if($lastname==="null") { $lastname = null; }
            if($email==="null") { $email = null; }
            if($phone==="null") { $phone = null; }
            
            if(!empty($email)) {
                $email = str_replace("-110-", "@", $email);
            }

            $data = array(
                'userid' => $client,
                'first_name' => urldecode($firstname),
                'last_name' => urldecode($lastname),
                'phone' => urldecode($phone),
                'email' => urldecode($email)
            );

            $this->db->insert('contacts', $data);
        }

	public function details($id) {

            if(!empty($id)) {
                $data['siteTitle'] = "The NewsletterPro";
                $data['title'] = "Clients - Details"; // Capitalize the first letter
                $data['assets'] = asset_url();

                $this->load->model('Clients_model');
                $this->load->model('List_model');
                $this->load->model('Note_model');

                $data["image"]              = $this->Clients_model->getClientImage($id);
                $data["teamMembers"]        = $this->Clients_model->getTeamMembersArray();
                $data["details"]            = $this->Clients_model->getClientDetailsArray($id);
                $data["articles"]           = $this->Clients_model->getClientArticlesArray($id);
                $data["teamsList"]          = $this->List_model->getList("team");
                $data["schedule"]           = $this->List_model->getList("mailing schedule");
                $data["articlesCount"]      = count($data["articles"]);
                $data["demographics"]       = $this->List_model->getList("Demographics");
                $data["notes"]              = $this->Note_model->getNotesByClient($id);
                $data["loadDataTables"]     = true;
                $data["secondaryContacts"]  = $this->Clients_model->getSecondaryContacts($id);

                if($_SESSION["UserRole"]=="admin") {
                    $this->load->view('templates/header', $data);
                    $this->load->view('clients/details.php', $data);
                }
                else {
                    $data["noHeader"] = true;
                    $data["teamInfo"] = $this->Clients_model->getTeamInfoById($id);
                    $data["teamName"] = $this->Clients_model->getTeamByClientId($id);
                    $stringDemo = $this->Clients_model->getClientDemographics($id);
                    if(!empty($stringDemo)) {
                        $data["demographicsLabel"] = $this->Clients_model->getDemographicStringByIds($stringDemo);	
                    }
                    else {
                        $data["demographicsLabel"] = "";
                    }
                    $this->load->view('templates/header', $data);
                    $this->load->view('clients/details-team.php', $data);
                }

                $this->load->view('templates/footer', $data);

            }
            else {
                show_404();
            }
	}

	public function checkIfExists($name) {
		$this->load->model('Clients_model');
		if($this->Clients_model->checkCompanyName($name)) {
			echo true;
		}
		else {
			echo false;
		}
	}

	public function update() {
		$id =						trim($_POST["id"]);
		$company = 					trim($_POST["company"]);
		$fname = 					trim($_POST["fname"]);
		$lname = 					trim($_POST["lname"]);
		$status = 					trim($_POST["status"]);
		$email =					trim($_POST["email"]);
		$phone = 					trim($_POST["phone"]);
		$mail_date = 				trim($_POST["mail_date"]);
		$mailing_schedule = 		trim($_POST["mailing_schedule"]);
		$owned_by =                 trim($_POST["owned_by"]);
		$package_type = 			trim($_POST["package_type"]);
		$list_size = 				trim($_POST["list_size"]);
		$versions = 				trim($_POST["versions"]);
		$layout_guide = 			trim($_POST["layout_guide"]);
		$notes = 					trim($_POST["notes"]);
		if(!empty($_POST["demographics"])) {
			$demographics = 			implode(",", $_POST["demographics"]);
		}
		else {
			$demographics = null;
		}
		$date_sold	= 				trim($_POST["date_sold"]);
		$date_onboarded	= 			trim($_POST["date_onboarded"]);
		$sale_source	= 			trim($_POST["sale_source"]);
		if(!empty($_POST["pieces_mailed"])) {
			$pieces_mailed	= 		trim($_POST["pieces_mailed"]);
		}
		else {
			$pieces_mailed	= 		null;
		}
		$price_per_pieces = 		trim($_POST["price_per_pieces"]);
		$team	= 					trim($_POST["team"]);
		$writer	= 					trim($_POST["writer"]);
		$designer	= 				trim($_POST["designer"]);
		$total_pages	= 			trim($_POST["total_pages"]);
		$unique_pages	= 			trim($_POST["unique_pages"]);
		$custom_content	= 			trim($_POST["custom_content"]);
		$filler_content	= 			trim($_POST["filler_content"]);
		$client_submitted_content =	trim($_POST["client_submitted_content"]);
		$side_campaigns	= 			trim($_POST["side_campaigns"]);
		if(!empty($_POST["return_date"])) {
			$return_date = 			trim($_POST["return_date"]);
		}
		else {
			$return_date =			null;
		}

		if(!empty($date_sold)) {
			$date_sold = date("Y-m-d", strtotime($date_sold));
		}
		else {
			$date_sold = null;
		}

		if(!empty($date_onboarded)) {
			$date_onboarded = date("Y-m-d", strtotime($date_onboarded));
		}
		else {
			$date_onboarded = null;
		}

		if(!empty($return_date)) {
			$return_date = date("Y-m-d", strtotime($return_date));
		}
		else {
			$return_date = null;
		}

		if(empty($team)) { $team = null; }
		if(empty($writer)) { $writer = null; }
		if(empty($designer)) { $designer = null; }
		if(empty($versions)) { $versions = null; }
		if(empty($pieces_mailed)) { $pieces_mailed = "0"; }
		if(empty($price_per_pieces)) { $price_per_pieces = "0"; }
		if(empty($total_pages)) { $total_pages = "0"; }
		if(empty($unique_pages)) { $unique_pages = "0"; }
		if(empty($custom_content)) { $custom_content = "0"; }
		if(empty($filler_content)) { $filler_content = "0"; }
		if(empty($client_submitted_content)) { $client_submitted_content = "0"; }

		$data = array(
			'company_name' 				=> $company,
			'first_name' 				=> $fname,
			'last_name' 				=> $lname,
			'status' 					=> $status,
			'email'						=> $email,
			'phone' 					=> $phone,
			'mail_date' 				=> $mail_date,
			'mailing_schedule' 			=> $mailing_schedule,
			'package_type'				=> $package_type,
			'list_size' 				=> $list_size,
			'versions'					=> $versions,
			'demographics' 				=> $demographics,
			'owned_by'                  => $owned_by,
			'date_sold'					=> $date_sold,
			'date_onboarded'			=> $date_onboarded,
			'sale_source'				=> $sale_source,
			'pieces_mailed'				=> $pieces_mailed,
			'price_per_pieces'			=> $price_per_pieces,
			'team'						=> $team,
			'writer'					=> $writer,
			'designer'					=> $designer,
			'total_pages'				=> $total_pages,
			'unique_pages'				=> $unique_pages,
			'custom_content'			=> $custom_content,
			'filler_content'			=> $filler_content,
			'client_submitted_content'	=> $client_submitted_content,
			'side_campaigns'			=> $side_campaigns,
			'return_date'				=> $return_date,
			'mailing_schedule'			=> $mailing_schedule,
			'layout_guide'				=> $layout_guide
		);

		$this->db->where('id', $id);
		$this->db->update('users', $data);
                
                if(!empty($notes)) {
                    $data = array(
                        'userid'    => $_SESSION["UserID"],
                        'clientid'  => $id,
                        'content'   => $notes
                    );
                    $this->db->insert('notes', $data);
                }

		$_SESSION["DisplayMessage"] = "Record updated successfully.";

		redirect("clients/details/$id");
	}

	public function add() {

		$this->load->model('Clients_model');

		$company = 					trim($_POST["company"]);
		$fname = 					trim($_POST["fname"]);
		$lname = 					trim($_POST["lname"]);
		$status = 					trim($_POST["status"]);
		$email =					trim($_POST["email"]);
		$phone = 					trim($_POST["phone"]);
		$mail_date = 				trim($_POST["mail_date"]);
		//$mailing_schedule = 		trim($_POST["mailing_schedule"]);
		$package_type = 			trim($_POST["package_type"]);
		$list_size = 				trim($_POST["list_size"]);
		$versions = 				trim($_POST["versions"]);
		$layout_guide = 			trim($_POST["layout_guide"]);
		$notes = 					trim($_POST["notes"]);
		if(!empty($_POST["demographics"])) {
			$demographics = 		implode(",", $_POST["demographics"]);
		}
		else {
			$demographics = 		null;
		}
		
		$owned_by =					trim($_POST["owned_by"]);
		$role =						"client";
		$date_sold	= 				trim($_POST["date_sold"]);
		$date_onboarded	= 			trim($_POST["date_onboarded"]);
		$sale_source	= 			trim($_POST["sale_source"]);
		$pieces_mailed	= 			trim($_POST["pieces_mailed"]);
		$price_per_pieces = 		trim($_POST["price_per_pieces"]);
		$team	= 					trim($_POST["team"]);
		$writer	= 					trim($_POST["writer"]);
		$designer	= 				trim($_POST["designer"]);
		$total_pages	= 			trim($_POST["total_pages"]);
		$unique_pages	= 			trim($_POST["unique_pages"]);
		$custom_content	= 			trim($_POST["custom_content"]);
		$filler_content	= 			trim($_POST["filler_content"]);
		$client_submitted_content =	trim($_POST["client_submitted_content"]);
		$side_campaigns	= 			trim($_POST["side_campaigns"]);
		$return_date = 				null;
		$mailing_schedule = 		null;
		if(!empty($_POST["return_date"])) {
			$return_date = trim($_POST["return_date"]);
		}

		$mailing_schedule_text = 	trim($_POST["mailing_schedule_text"]);
		$mailing_schedule_select = 	trim($_POST["mailing_schedule_select"]);

		if(!$this->Clients_model->checkCompanyName($company)) {
			if(!empty($mailing_schedule_select)) {
				$mailing_schedule = $mailing_schedule_select;
			}

			if(!empty($mailing_schedule_text)) {
				$mailing_schedule = $mailing_schedule_text;
			}

			if(!empty($mailing_schedule_text) && !empty($mailing_schedule_select)) {
				$mailing_schedule = $mailing_schedule_text;
			}

			if(!empty($date_sold)) {
				$date_sold = date("Y-m-d", strtotime($date_sold));
			}
			else {
				$date_sold = null;
			}

			if(!empty($return_date)) {
				$return_date = date("Y-m-d", strtotime($return_date));
			}
			else {
				$return_date = null;
			}

			if(!empty($date_onboarded)) {
				$date_onboarded = date("Y-m-d", strtotime($date_onboarded));
			}
			else {
				$date_onboarded = null;
			}

			if(empty($team)) { $team = null; }
			if(empty($owned_by)) { $owned_by = null; }
			if(empty($writer)) { $writer = null; }
			if(empty($designer)) { $designer = null; }
			if(empty($mailing_schedule_select)) { $mailing_schedule_select = null; }
			if(empty($mailing_schedule_text)) { $mailing_schedule_text = null; }
			if(empty($versions)) { $versions = null; }
			if(empty($pieces_mailed)) { $pieces_mailed = "0"; }
			if(empty($price_per_pieces)) { $price_per_pieces = "0"; }
			if(empty($total_pages)) { $total_pages = "0"; }
			if(empty($unique_pages)) { $unique_pages = "0"; }
			if(empty($custom_content)) { $custom_content = "0"; }
			if(empty($filler_content)) { $filler_content = "0"; }
			if(empty($client_submitted_content)) { $client_submitted_content = "0"; }

			$data = array(
				'company_name'              => $company,
				'first_name'                => $fname,
				'last_name'                 => $lname,
				'status'                    => $status,
				'email'                     => $email,
				'phone'                     => $phone,
				'mail_date'                 => $mail_date,
				'mailing_schedule'          => $mailing_schedule,
				'package_type'              => $package_type,
				'list_size'                 => $list_size,
				'versions'                  => $versions,
				'layout_guide'              => $layout_guide,
				'demographics'              => $demographics,
				'owned_by'                  => $owned_by,
				'role'                      => $role,
				'date_sold'                 => $date_sold,
				'date_onboarded'            => $date_onboarded,
				'sale_source'               => $sale_source,
				'pieces_mailed'             => $pieces_mailed,
				'price_per_pieces'          => $price_per_pieces,
				'team'                      => $team,
				'writer'                    => $writer,
				'designer'                  => $designer,
				'total_pages'               => $total_pages,
				'unique_pages'              => $unique_pages,
				'custom_content'            => $custom_content,
				'filler_content'            => $filler_content,
				'client_submitted_content'  => $client_submitted_content,
				'side_campaigns'            => $side_campaigns,
				'return_date'               => $return_date,
				'mailing_schedule'          => $mailing_schedule
			);

			$this->db->insert('users', $data);
                        
                        $newId = $this->Clients_model->getClientMaxId();
                        if(!empty($notes)) {
                            $data = array(
                                'userid'    => $_SESSION["UserID"],
                                'clientid'  => $newId,
                                'content'   => $notes
                            );
                            $this->db->insert('notes', $data);
                        }

			$_SESSION["DisplayMessage"] = "Record added successfully.";
		}
		else {
			$_SESSION["DisplayMessage"] = "Company already found. Please try again.";
		}

		redirect("clients/view/add");
	}
}