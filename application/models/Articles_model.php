<?php
class Articles_model extends CI_Model {

	var $isValid = false;

	public function __construct() {
		$this->load->database();
	}
	
	public function getAssignArticleDate() {
		return date('Y-m-d', strtotime("+3 months", strtotime(date("Y-m-d"))));
	}

	public function getArticleTypes() {
		$arrTypes = array();
		$sql = "SELECT ListUID, ListLabel FROM `lists` where ListType = 'Category' AND active='1' ORDER BY ListLabel";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"UID"	=>$row->ListUID,
								"Label"	=>$row->ListLabel
							);
				array_push($arrTypes,$arrCurrent);
			}
		}
		return $arrTypes;
	}

	public function getArticlesArray() {
		$arrArticles = array();
		$sql = "SELECT
					*
				FROM
					`articles`";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"id"					=>$row->id,
								"uid"					=>$row->uid,
								"article_name"			=>$row->article_name,
								"article_category"		=>$row->article_category,
								"article_path"			=>$row->article_path,
								"article_demographic"	=>$this->getListLabelByValues($row->article_demographic),
								"article_keywords"		=>$row->article_keywords,
								"article_wordcount_sm"	=>$row->article_wordcount_sm,
								"article_wordcount_md"	=>$row->article_wordcount_md,
								"article_wordcount_lg"	=>$row->article_wordcount_lg,
								"article_description"	=>$row->article_description,
								"linked_images"			=>$row->linked_images,
								"article_created"		=>$row->article_created
							);
				if(!empty($arrCurrent["article_category"])) {
					$this->load->model('List_model');
					$arrCurrent["article_category"] = $this->List_model->getLabelsByStringList($arrCurrent["article_category"]);
				}
				array_push($arrArticles,$arrCurrent);
			}
		}
		return $arrArticles;
	}

	public function getArticleDetailsArray($id) {
		
		if(!is_numeric($id)) {
			show_404();
		}

		$arrDetails = array();
		$sql = "SELECT
					a.*,
				    b.label as category_label
				FROM
					`articles` a
				LEFT JOIN
					categories b 
				ON
					b.uid = a.article_category
				WHERE
					a.id = $id";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"id"					=>$row->id,
								"uid"					=>$row->uid,
								"article_name"			=>$row->article_name,
								"article_path"			=>$row->article_path,
								"article_category"		=>$row->article_category,
								"category_label"		=>$row->category_label,
								"article_demographic"	=>$row->article_demographic,
								"article_keywords"		=>$row->article_keywords,
								"article_description"	=>$row->article_description,
								"linked_images"			=>$row->linked_images,
								"article_attachment_sm"	=>$row->article_attachment_sm,
								"article_attachment_md"	=>$row->article_attachment_md,
								"article_attachment_lg"	=>$row->article_attachment_lg,
								"article_wordcount_sm"	=>$row->article_wordcount_sm,							
								"article_wordcount_md"	=>$row->article_wordcount_md,							
								"article_wordcount_lg"	=>$row->article_wordcount_lg,
								"article_image_sm"		=>$row->article_image_sm,
								"article_image_md"		=>$row->article_image_md,
								"article_image_lg"		=>$row->article_image_lg,
								"article_uploaded"		=>$row->article_uploaded,
								"article_created"		=>$row->article_created
							);

				array_push($arrDetails,$arrCurrent);
			}
		}
		return $arrDetails;
	}

	public function getAttachmentByArticleId($articleId) {
		if(!is_numeric($articleId)) {
			show_404();
		}
		$pathName = "";
		$sql = "SELECT
					path
				FROM
					attachments
				WHERE
					module = 'articles' AND
					module_id = $articleId";
		$query = $this->db->query($sql);	
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$pathName = $row->path;
			}
		}
		return $pathName;
	}

	public function getImageByArticleId($articleId) {
		if(!is_numeric($articleId)) {
			show_404();
		}
		$pathName = "";
		$sql = "SELECT
					path
				FROM
					attachments
				WHERE
					module = 'articles_image' AND
					module_id = $articleId";
		$query = $this->db->query($sql);	
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$pathName = $row->path;
			}
		}
		return $pathName;
	}
	
	public function getListLabelByValues($arrValues) {
		if($arrValues=="") {
			return "";
		}
		$arrReturn = array();
		$sql = "SELECT
					ListLabel
				FROM
					lists
				WHERE
					ListUID IN (" . addslashes($arrValues) . ")
				ORDER BY ListLabel";
		$query = $this->db->query($sql);	
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				array_push($arrReturn,$row->ListLabel);
			}
		}
		return $arrReturn;
	}

	public function getList($listName,$active=1) {
		$listName = addslashes($listName);
		$arrList = array();
		$sql = "SELECT
					ListUID,
				    ListLabel
				FROM
					lists
				WHERE
					ListType = '$listName' AND
					Active = $active
				ORDER BY ListLabel";
		$query = $this->db->query($sql);	
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"uid"	=>$row->ListUID,
								"label"	=>$row->ListLabel
							);
				array_push($arrList,$arrCurrent);
			}
		}
		return $arrList;
	}

	public function getAvailableClients($id) {
		if(!is_numeric($id)) {
			show_404();
		}
		$arrClients = array();
		$sql = "select
					a.id as clientid,
				    a.company_name as company_name
				FROM
					users a
				where
					a.id not in 
						(SELECT user_id FROM assigned_articles where article_id = $id)
				    AND a.role = \"client\"";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"client_id"		=>$row->clientid,
								"company_name"	=>$row->company_name
							);
				array_push($arrClients,$arrCurrent);
			}
		}
		return $arrClients;
	}

	public function assignArticle($clientid,$articleid, $edition) {
		if(!is_numeric($clientid) || !is_numeric($articleid)) {
			show_404();
		}
		$data = array(
				"user_id"=>$clientid,
				"article_id"=>$articleid,
				"edition"=>$edition . "-01"
		);                

		$this->db->insert('assigned_articles', $data);

	}

	public function getUsageByArticleId($articleId) {
		
		if(!is_numeric($articleId)) {
			show_404();
		}

		$arrUsage = array();
		$sql = "SELECT
					a.user_id,
				    a.edition,
				    b.company_name
				FROM
					assigned_articles a
				LEFT JOIN
					users b 
				ON 
					b.id = a.user_id
				WHERE
					article_id = $articleId
				    AND unassigned Is NULL";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"user_id"		=>$row->user_id,
								"edition"		=>$row->edition,
								"company_name"	=>$row->company_name
							);
				array_push($arrUsage,$arrCurrent);
			}
		}
		return $arrUsage;
	}

}