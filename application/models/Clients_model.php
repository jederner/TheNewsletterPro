<?php
class Clients_model extends CI_Model {

    private $categoriesAvailable = array();
    private $demographicsAvailable = array();

    public function __construct() {
        $this->load->database();
        if(empty($_SESSION["UserLoggedIn"])) {
            redirect(base_url()."index.php/Pages/view/home");
        }
    }

    public function getTeamByClientId($id) {
        $team = "";
        $sql = "SELECT
                    a.team,
                    b.ListLabel
                FROM
                        users a
                LEFT JOIN
                        lists b ON b.ListUID = a.team
                WHERE
                        a.id = $id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $team = $row->ListLabel;
            }
        }
        return $team;
    }
    
    public function getSecondaryContacts($id) {
        if(!is_numeric($id)) {
            show_404();
        }
        $clients = array();
        $sql = "SELECT "
                . "* "
                . "from "
                . "contacts "
                . "WHERE "
                . "userid=$id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $curArray = array(
                    "userid"    =>$row->userid,
                    "first_name"=>$row->first_name,
                    "last_name" =>$row->last_name,
                    "phone"     =>$row->phone,
                    "email"     =>$row->email
                );
                array_push($clients,$curArray);
            }
        }
        return $clients;
    }

    public function getTeamInfoById($id) {
            $info = array();
            $sql = "SELECT
                        a.id,
                        concat(b.first_name,' ',b.last_name) as pm,
                        concat(c.first_name,' ',c.last_name) as writer,
                        concat(d.first_name,' ',d.last_name) as designer
                    FROM
                            users a
                    LEFT JOIN
                            users b ON b.id = a.owned_by
                    LEFT JOIN
                            users c ON c.id = a.writer
                    LEFT JOIN
                            users d ON d.id = a.designer
                    WHERE
                            a.id = $id";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                            $info["pm"] = $row->pm;
                            $info["writer"] = $row->writer;
                            $info["designer"] = $row->designer;
                    }
            }
            return $info;
    }

    public function getUsernameById($id) {
            $name = "default";
            $sql = "SELECT CONCAT(first_name,' ',last_name) as contact_name FROM `users` WHERE id=$id";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                            $name = $row->contact_name;
                    }
            }
            return $name;
    }

    public function getCompanyNameById($id) {
            $sql = "SELECT company_name FROM `users` WHERE id=$id";
            $query = $this->db->query($sql);
            $name = "default";
            if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                            $name = $row->company_name;
                    }
            }
            return $name;
    }

    public function getFullNameById($id) {
            $name = "";
            if(!empty($id)) {
                    $sql = "SELECT CONCAT(last_name,', ',first_name) as fullname FROM `users` WHERE id=$id";
                    $query = $this->db->query($sql);
                    if ($query->num_rows() > 0) {
                            foreach($query->result() as $row) {
                                    $name = $row->fullname;
                            }
                    }
            }
            return $name;
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
                                    ListUID IN (" . $arrValues . ")
                            ORDER BY ListLabel";
            $query = $this->db->query($sql);	
            if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                            array_push($arrReturn,$row->ListLabel);
                    }
            }
            return $arrReturn;
    }

    public function checkCompanyName($name) {
            $exists = true; // true by default
            $checkName = "";
            $name = addslashes(trim(urldecode($name)));
            $sql = "SELECT company_name FROM `users` WHERE company_name = \"$name\"";
            $query = $this->db->query($sql);
            foreach($query->result() as $row) {
                    $checkName = $row->company_name;
            }
            if($checkName==="") {
                    $exists = false;
            }
            return $exists;
    }

    public function getClientMaxId() {
        $sql = "SELECT max(id) as theMax FROM users WHERE role='client'";
        $query = $this->db->query($sql);
        $id = "999999";
        if ($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $id = $row->theMax;
            }
        }
        return $id;
    }

    public function getClientImage($id) {
            $sql = "SELECT path FROM `attachments` WHERE module='clients' AND module_id=$id AND Active=1";
            $query = $this->db->query($sql);
            $path = "http://fakeimg.pl/200x200/?text=Coming Soon";
            if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                            $path = $row->path;
                    }
            }
            return $path;
    }

    public function getTeamMembersArray() {
            $arrTeam = array();
            $sql = "SELECT * FROM `users` where role = 'team member' and `status` = 'active' order by last_name";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                            $arrCurrent = array(
                                                            "id"		=>$row->id,
                                                            "fname"		=>$row->first_name,
                                                            "lname"		=>$row->last_name
                                                    );
                            array_push($arrTeam,$arrCurrent);
                    }
            }
            return $arrTeam;
    }

    public function getClientsArray() {
            $arrClients = array();
            $sql = "SELECT * FROM `users` where role = 'client'";
            $query = $this->db->query($sql);
            $this->load->model('List_model');
            if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                            $arrCurrent = array(
                                                            "id"				=>$row->id,
                                                            "company"			=>$row->company_name,
                                                            "fname"				=>$row->first_name,
                                                            "lname"				=>$row->last_name,
                                                            "status"			=>$row->status,
                                                            "mail_date"			=>$row->mail_date,
                                                            "mailing_schedule"	=>$row->mailing_schedule,
                                                            "pm"				=>$this->getFullNameById($row->owned_by),
                                                            "writer"			=>$this->getFullNameById($row->writer),
                                                            "designer"			=>$this->getFullNameById($row->designer),
                                                            "package_type"		=>$row->package_type,
                                                            "team"				=>$this->List_model->getLabelById($row->team)
                                                    );
                            array_push($arrClients,$arrCurrent);
                    }
            }
            return $arrClients;
    }

    public function getArticlesToAssign($id) {

            if(!is_numeric($id)) {
                    show_404();
            }

            $arrArticles = array();

            $sql = "SELECT
                                    a.*,
                                    b.Label as category_label,
                                    c.Label as subcategory_label
                            FROM
                                    articles a
                            LEFT JOIN
                                    `categories` b 
                            ON
                                    b.uid = a.article_category
                            LEFT JOIN
                                    `categories` c 
                            ON
                                    c.uid = a.article_subcategory
                            WHERE
                                    a.id not in 
                                ( select article_id from assigned_articles WHERE user_id=$id)";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                            $arrCurrent = array(
                                                            "id"					=>$row->id,
                                                            "article_name"			=>$row->article_name,
                                                            "article_path"			=>$row->article_path,
                                                            "article_demographic"	=>$row->article_demographic,
                            								"article_description"	=>$row->article_description,
                                                            "article_keywords"		=>$row->article_keywords,
                                                            "category"				=>$row->category_label
                                                    );
                            if(!empty($arrCurrent["article_demographic"])) {
                                    $this->load->model('List_model');
                                    $arrCurrent["article_demographic"] = $this->List_model->getLabelsByStringList($arrCurrent["article_demographic"]);
                                    $this->addDemographicsAvailable($arrCurrent["article_demographic"]);
                            }
                            $this->addCategoriesAvailable($arrCurrent["category"]);
                            array_push($arrArticles,$arrCurrent);
                    }
            }
            return $arrArticles;
    }

    public function addCategoriesAvailable($newValue) {
            if(!in_array($newValue, $this->categoriesAvailable)) {
                    array_push($this->categoriesAvailable, $newValue);
            }
    }

    public function addDemographicsAvailable($newValue) {
            if(!in_array($newValue, $this->demographicsAvailable)) {
                    array_push($this->demographicsAvailable, $newValue);
            }
    }

    public function getCategoriesAvailable() {
            return $this->categoriesAvailable;
    }

    public function getDemographicsAvailable() {
            return $this->demographicsAvailable;
    }

    public function getDemographicStringByIds($string) {
            $arrLabels = array();
            $sql = "SELECT
                                    ListLabel
                            FROM 
                                    lists
                            WHERE ListUID in ($string)";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                            array_push($arrLabels, $row->ListLabel);
                    }
            }
            $returnLabels = implode(", ", $arrLabels);
            return $returnLabels;
    }

    public function getClientDemographics($id) {
            if(!is_numeric($id)) {
                    show_404();
            }
            $returnDemographics = "";
            $sql = "SELECT 
                                    demographics
                            FROM
                                    users
                            WHERE
                                    id=$id";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                            $returnDemographics = $row->demographics;
                    }
            }
            return $returnDemographics;
    }

    public function getClientArticlesArray($id) {

            if(!is_numeric($id)) {
                    show_404();
            }

            $arrArticles = array();
            $sql = "SELECT
                                    a.*,
                                    b.*,
                                    c.Label as category_label,
                                    d.Label as subcategory_label
                            FROM
                                    `assigned_articles` a
                            LEFT JOIN
                                    `articles` b
                            ON
                                    b.id = a.article_id
                            LEFT JOIN
                                    `categories` c 

                            ON
                                    c.uid = b.article_category
                            LEFT JOIN
                                    `categories` d 
                            ON
                                    d.uid = b.article_subcategory
                            WHERE
                                    a.user_id = $id
                                    AND a.unassigned IS NULL";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                            $arrCurrent = array(
                                                            "id"					=>$row->id,
                                                            "uid"					=>$row->user_id,
                                                            "article_id"			=>$row->article_id,
                                                            "article_name"			=>$row->article_name,
                                                            "article_path"			=>$row->article_path,
                                                            "article_demographic"	=>$row->article_demographic,
                                                            "article_description"	=>$row->article_description,
                                                            "article_keywords"		=>$row->article_keywords,
                                                            "category"				=>$row->category_label,
                                                            "subcategory"			=>$row->subcategory_label,
                                                            "edition"				=>$row->edition
                                                    );
                            if(!empty($arrCurrent["article_demographic"])) {
                                    $arrCurrent["article_demographic"] = $this->getListLabelByValues($arrCurrent["article_demographic"]);
                            }
                            array_push($arrArticles,$arrCurrent);
                    }
            }
            return $arrArticles;		
    }

    public function getClientDetailsArray($id) {

            if(!is_numeric($id)) {
                    show_404();
            }

            $arrDetails = array();
            $sql = "SELECT
                                    a.*,
                                    b.id as pm_id,
                                    b.first_name as pm_fname,
                                    b.last_name as pm_lname
                            FROM
                                    `users` a 
                            left join
                                    users b on a.owned_by = b.id
                            WHERE
                                    a.id = $id";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                            $arrCurrent = array(
                                                            "id"						=>$row->id,
                                                            "company"					=>$row->company_name,
                                                            "fname"						=>$row->first_name,
                                                            "lname"						=>$row->last_name,
                                                            "status"					=>$row->status,
                                                            "email"						=>$row->email,
                                                            "phone"						=>$row->phone,
                                                            "mail_date"					=>$row->mail_date,
                                                            "timezone"					=>$row->timezone,
                                                            "pm_id"						=>$row->pm_id,
                                                            "pm_fname"					=>$row->pm_fname,
                                                            "pm_lname"					=>$row->pm_lname,
                                                            "package_type"				=>$row->package_type,
                                                            "list_size"					=>$row->list_size,
                                                            "mail_date"					=>$row->mail_date,
                                                            "mailing_schedule"			=>$row->mailing_schedule,
                                                            "versions"					=>$row->versions,
                                                            "demographics"				=>$row->demographics,
                                                            "project_manager"			=>$row->project_manager,
                                                            "date_sold"					=>$row->date_sold,
                                                            "date_onboarded"			=>$row->date_onboarded,
                                                            "sale_source"				=>$row->sale_source,
                                                            "campaigns_billed"			=>$row->campaigns_billed,
                                                            "pieces_mailed"				=>$row->pieces_mailed,
                                                            "price_per_pieces"			=>$row->price_per_pieces,
                                                            "team"						=>$row->team,
                                                            "writer"					=>$row->writer,
                                                            "designer"					=>$row->designer,
                                                            "total_pages"				=>$row->total_pages,
                                                            "unique_pages"				=>$row->unique_pages,
                                                            "custom_content"			=>$row->custom_content,
                                                            "filler_content"			=>$row->filler_content,
                                                            "client_submitted_content"	=>$row->client_submitted_content,
                                                            "side_campaigns"			=>$row->side_campaigns,
                                                            "return_date" 				=>$row->return_date,
                                                            "layout_guide"				=>$row->layout_guide,
                                                            "notes" 					=>$row->notes
                                                    );
                            if(!empty($arrCurrent["demographics"])) {
                                    if(gettype($arrCurrent["demographics"])!=="string") {
                                            $arrCurrent["demographics"] = implode(",", $arrCurrent["demographics"]);
                                    }
                            }

                            array_push($arrDetails,$arrCurrent);
                    }
            }
            return $arrDetails;
    }

}
?>