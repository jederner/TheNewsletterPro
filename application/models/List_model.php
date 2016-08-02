<?php
class List_model extends CI_Model {
    
	public function __construct() {
		$this->load->database();
	}
        
        public function getSelectListFromString($listName,$fieldName,$fieldValue=null) {
            $base = "<select name=\"$fieldName\"><option value=''></option>";
            $options = array();
            if(!empty($fieldName) && !empty($listName)) {
                $sql = "SELECT ListUID, ListLabel FROM lists WHERE ListType=\"$listName\"";
                $query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
                    foreach($query->result() as $row) {
                        $arrCurrent = array(
                            "ListUID"	=>$row->ListUID,
                            "ListLabel"	=>$row->ListLabel
                        );
                        array_push($options,$arrCurrent);
                    }
		}
                foreach($options as $option) {
                    $myValue = $option["ListUID"];
                    $myLabel = $option["ListLabel"];
                    $base .= "<option value=\"$myValue\"";
                    if($fieldValue===$myValue) {
                        $base .= " selected='selected'";
                    }
                    $base .= ">$myLabel</option>";
                }
            }
            $base .= "</select>";
            return $base;
        }

	public function getList($name,$active=1) {
		$arrList = array();
		$name = addslashes(trim($name));
		if(!is_numeric($active)) {
			$active = 1;
		}
		$sql = "SELECT ListUID, ListLabel FROM `lists` where ListType=\"$name\" AND active=$active";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"ListUID"	=>$row->ListUID,
								"ListLabel"	=>$row->ListLabel
							);
				array_push($arrList,$arrCurrent);
			}
		}
		return $arrList;
	}

	public function getLists($active=1) {
		$arrLists = array();
		if(!is_numeric($active)) {
			$active = 1;
		}
		$sql = "SELECT * FROM `lists` ORDER BY ListType, ListLabel";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"ListUID"	=>$row->ListUID,
								"ListType"	=>$row->ListType,
								"ListLabel"	=>$row->ListLabel,
								"active"	=>$row->Active
							);
				array_push($arrLists,$arrCurrent);
			}
		}
		return $arrLists;
	}

	public function getLabelById($id) {
		$label = "Default";
		if(!is_numeric($id)) {
			return "Unknown";
		}
		$sql = "SELECT ListLabel FROM `lists` where ListUID = $id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$label = $row->ListLabel;
			}
		}
		return $label;
	}

	public function getListArrayById($id) {
		$arrList = array();
		if(!is_numeric($id)) {
			show_404();
		}
		$sql = "SELECT ListUID, ListType, ListLabel FROM `lists` WHERE ListUID=$id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"ListUID"	=>$row->ListUID,
								"ListType"	=>$row->ListType,
								"ListLabel"	=>$row->ListLabel
							);
				array_push($arrList,$arrCurrent);
			}
		}
		return $arrList;
	}

	public function getLabelsByStringList($stringList,$active=1) {
		$stringList = addslashes(trim($stringList));
		if(!is_numeric($active)) {
			$active = 1;
		}
		$returnStr = "";
		$sql = "SELECT ListLabel FROM `lists` where ListUID IN ($stringList) AND active=$active";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$tick = 1;
			foreach($query->result() as $row) {
				$returnStr .= $row->ListLabel;
				if($tick<$query->num_rows()) {
					$returnStr .= ", ";
				}
				$tick++;
			}
		}
		return $returnStr;
	}
}