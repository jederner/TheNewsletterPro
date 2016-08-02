<?php

class Customreport_model extends CI_Model {

    private $fieldList = array(
        array(
            "Label" => "Company",
            "fieldName" => "company_name"
        ),
        array(
            "Label" => "Status",
            "fieldName" => "status",
        ),
        array(
            "Label" => "Mail Date",
            "fieldName" => "mail_date"
        ),
        array(
            "Label" => "Package Type",
            "fieldName" => "package_type"
        ),
        array(
            "Label" => "List Size",
            "fieldName" => "list_size"
        ),
        array(
            "Label" => "Versions",
            "fieldName" => "versions"
        ),
        array(
            "Label" => "Campaigns Billed",
            "fieldName" => "campaigns_billed"
        ),
        array(
            "Label" => "Pieces Mailed",
            "fieldName" => "pieces_mailed"
        ),
        array(
            "Label" => "Price Per Piece",
            "fieldName" => "price_per_piece"
        ),
        array(
            "Label" => "Team",
            "fieldName" => "team"
        ),
        array(
            "Label" => "Project Manager",
            "fieldName" => "owned_by"
        ),
        array(
            "Label" => "Writer",
            "fieldName" => "writer"
        ),
        array(
            "Label" => "Designer",
            "fieldName" => "designer"
        ),
        array(
            "Label" => "Total Pages",
            "fieldName" => "total_pages"
        ),
        array(
            "Label" => "Unique Pages",
            "fieldName" => "unique_pages"
        ),
        array(
            "Label" => "Custom Content",
            "fieldName" => "custom_content"
        ),
        array(
            "Label" => "Filler Content",
            "fieldName" => "filler_content"
        ),
        array(
            "Label" => "Client Submitted Content",
            "fieldName" => "client_submitted_content"
        )
    );

    public function getCompanyList() {
        $string = "<option value=''></option>";
        $sql = "SELECT "
                . "id, "
                . "company_name "
                . "FROM `users` where company_name != '' AND company_name IS NOT NULL AND role='client' order by company_name";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $value = $row->id;
                $label = $row->company_name;
                $string .= "<option value=\"$value\">$label</option>";
            }
        }
        return $string;
    }
    
    public function getTeamList() {
        $string = "<option value=''></option>";
        $sql = "SELECT * FROM `lists` where listtype = 'team' and active = 1 order by listlabel";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $value = $row->ListUID;
                $label = $row->ListLabel;
                $string .= "<option value=\"$value\">$label</option>";
            }
        }
        return $string;
    }
    
    public function getTeamMemberList() {
        $string = "<option value=''></option>";
        $sql = "SELECT id, concat(last_name, ', ', first_name) as fullname FROM `users` where role = 'team member' and status='active' order by fullname";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $value = $row->id;
                $label = $row->fullname;
                $string .= "<option value=\"$value\">$label</option>";
            }
        }
        return $string;
    }

    public function getStatusList() {
        $arrOptions = array("active", "inactive", "on hold");
        $string = "";
        foreach ($arrOptions as $item) {
            $string .= "<option value='$item'>$item</option>";
        }
        return $string;
    }

    public function getMailDateList() {
        $arrOptions = array("5th", "15th", "20th", "25th", "30th");
        $string = "";
        foreach ($arrOptions as $item) {
            $string .= "<option value='$item'>$item</option>";
        }
        return $string;
    }
    
    public function getOperatorList() {
        $arrOptions = array("<", "=", ">", "!=");
        $string = "";
        foreach ($arrOptions as $item) {
            $string .= "<option value='$item'>$item</option>";
        }
        return $string;
    }

    public function getFieldList() {
        return $this->fieldList;
    }

    public function getCheckboxList() {
        $arrList = $this->getFieldList();
        $statusList = $this->getStatusList();
        $mailDateList = $this->getMailDateList();
        $teamList = $this->getTeamList();
        $teamMemberList = $this->getTeamMemberList();
        $string = "";
        
        foreach ($arrList as $arrField) {
            $label = $arrField["Label"];
            $field = $arrField["fieldName"];
            $string .= "<div class='fieldHeight'><div><input type='checkbox' name='chk_$field' id='chk_$field' />&nbsp;$label</div><div>";

            switch ($label) {
                case "Status":
                    $string .= "<select name=\"$field\" id=\"$field\"><option value=''></option>$statusList</select>";
                    break;
                case "Mail Date":
                    $string .= "<select name=\"$field\" id=\"$field\"><option value=''></option>$mailDateList</select>";
                    break;
                case "Team":
                    $string .= "<select name=\"$field\" id=\"$field\"><option value=''></option>$teamList</select>";
                    break;
                case "Project Manager":
                case "Writer":
                case "Designer":
                    $string .= "<select name=\"$field\" id=\"$field\"><option value=''></option>$teamMemberList</select>";
                    break;
                case "List Size":
                case "Campaigns Billed":
                case "Pieces Mailed":
                case "Price Per Piece":
                case "Total Pages":
                case "Unique Pages":
                    //echo "<select name=\"operator_$field\" id=\"operator_$field\"><option value=''></option>$operatorList</select>";
                    //echo "&nbsp;<input type='text' name='$field' id='$field' />";
                    break;
                default:
                    //echo "<input type='text' name='$field' id='$field' />";
                    break;
            }
            $string .= "</div></div>";
        }
        return $string;
    }
    
    public function getResults($sql) {
        if(!empty($sql)) {
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $rows = array();
                foreach($query->result() as $row) {
                    $rows[] = $row;
                }
            }
            return json_encode($rows);
        }
        return "";
    }

    public function __construct() {
        $this->load->database();
    }

}
