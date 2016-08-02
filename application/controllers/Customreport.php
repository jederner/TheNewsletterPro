<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customreport extends CI_Controller {
	
    public function view($page="home")
    {
        if ( ! file_exists(APPPATH."/views/customreport/$page.php")) {
            show_404();
        }

        $data['siteTitle'] = "The NewsletterPro";
        $data['title'] = "Custom Report"; // Capitalize the first letter
        $data['assets'] = asset_url();

        $this->load->model('Customreport_model');
        
        $data["fieldList"]      = $this->Customreport_model->getFieldList();
        $data["checkboxList"] 	= $this->Customreport_model->getCheckboxList();
        $data["companyList"]	= $this->Customreport_model->getCompanyList();
        
        $this->load->view('templates/header', $data);
        $this->load->view('customreport/home', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function process() {
        
        $arrDisplay = array();
        $arrFilter = array();
        
    	foreach($_POST as $k=>$v) {
            if(substr($k, 0,4)=="chk_") {
                $getField = substr($k, 4);
                array_push($arrDisplay,$getField);
            }
            else {
                if(!empty($v) && $k!=="process") {
                    array_push($arrFilter,array($k,$v));
                }
            }
        }
        /*
        echo "Display<br />"; 
        print_r($arrDisplay); 
        echo "<br /><Br />Filter<br />";
        print_r($arrFilter);
         * 
         */
        $sqlFields = "";
        $sqlConditions = "";
        $sqlJoin = "";
        
        foreach($arrDisplay as $item) {
            switch($item) {
                case "writer":
                    $sqlFields .= " concat(b.last_name,', ',b.first_name) as writer,";
                    $sqlJoin .= " LEFT JOIN users b on b.id = a.writer ";
                    break;
                case "designer":
                    $sqlFields .= " concat(c.last_name,', ',c.first_name) as designer,";
                    $sqlJoin .= " LEFT JOIN users c on c.id = a.designer ";
                    break;
                case "owned_by":
                    $sqlFields .= " concat(d.last_name,', ',d.first_name) as owned_by,";
                    $sqlJoin .= " LEFT JOIN users d on d.id = a.owned_by ";
                    break;
                case "team":
                    $sqlFields .= " e.ListLabel as Team ,";
                    $sqlJoin .= " LEFT JOIN lists e on e.ListUID = a.team ";
                    break;
                default:
                    $sqlFields .= "a.$item,";
                    break;
            }
            
        }
        $sqlFields = rtrim($sqlFields, ",");
        $sqlFields = rtrim($sqlFields, " AND ");
        
        
        foreach($arrFilter as $item) {
            $fieldName = $item[0];
            $fieldValue = $item[1];
            switch($fieldName) {
                
                default:
                    $sqlConditions .= "a.$fieldName = \"$fieldValue\" AND ";
                    break;
            }
            
        }
        $sqlConditions = rtrim($sqlConditions," AND ");

        $sql = "SELECT $sqlFields FROM users a $sqlJoin WHERE a.role='client'";
        if(!empty($sqlConditions)) {
            $sql .= " AND $sqlConditions";
        }
        if(strpos($sqlFields, "company_name")>-1) {
            $sql .= " ORDER BY Company_name";
        }
        
        //echo $sql;exit;

        $this->load->model('Customreport_model');
        
        echo $this->Customreport_model->getResults($sql);

        exit;
    }
}