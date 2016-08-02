<?php
class Dashboard_model extends CI_Model {
    
    private $clientList = array();
    private $menuList = array(
        array(
                "icon"=>"users",
                "label"=>"Clients",
                "url"=>"/index.php/Clients/view"
            ),
        array(
                "icon"=>"newspaper-o",
                "label"=>"Articles",
                "url"=>"/index.php/Articles/view"
            ),
        array(
                "icon"=>"user",
                "label"=>"My Profile",
                "url"=>"/index.php/Profile/details"
           ),
        array(
                "icon"=>"bar-chart",
                "label"=>"Reports",
                "url"=>"/index.php/Reports/view"
            ),
        array(
                "icon"=>"wikipedia-w",
                "label"=>"Wiki",
                "url"=>"http://wiki.newsletterpro.biz",
                "target"=>"_blank"
        )
    );
    
    function getClientList() {
        return $this->clientList;
    }

    function getMenuList() {
        return $this->menuList;
    }

    function setClientList($clientList) {
        $this->clientList = $clientList;
    }

    function setMenuList($menuList) {
        $this->menuList = $menuList;
    }
    
    function addMenuList($arr) {
        array_push($this->menuList, $arr);
    }
    
    function addClientList($arr) {
        array_push($this->clientList,$arr);
    }
    
    function fillClientList() {
        $sql = "SELECT "
                . "id, "
                . "company_name, "
                . "CONCAT(first_name,' ',last_name) as contact, "
                . "status "
                . "FROM `users` where role='client' "
                . "AND owned_by=" . $_SESSION["UserID"] . " "
                . "ORDER BY status, company_name";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $this->addClientList(
                    array(
                        "id"=>$row->id,
                        "company"=>$row->company_name,
                        "contact"=>$row->contact,
                        "status"=>$row->status
                    )
                );
            }
        }
    }
    
    function checkAdmin() {
        if($this->isAdmin()) {
            $this->addMenuList(
                    array(
                        "icon"=>"gears",
                        "label"=>"Admin",
                        "url"=>"/index.php/Admin/view"
                    )
            );
        }
    }

    function isAdmin() {
        $retVal = false;
        if($_SESSION["UserRole"]=="admin") {
            $retVal = true;
        }
        return $retVal;
    }
    
    public function setProfileById($id) {
        if(!is_numeric($id)) {
            show_404();
        }
        $sql = "SELECT "
                . "first_name, "
                . "last_name, "
                . "email, "
                . "phone "
                . "FROM `users` where id = $id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $this->setFirst_name($row->first_name);
                $this->setLast_name($row->last_name);
                $this->setEmail($row->email);
                $this->setPhone($row->phone);
            }
        }
    }
    
}