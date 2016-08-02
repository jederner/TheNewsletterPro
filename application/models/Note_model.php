<?php
class Note_model extends CI_Model {
    
    private $id = "0";
    private $clientid = "0";
    private $userid = "0";
    private $content = "";
    private $entered = "";

    public function __construct() {
        $this->load->database();
    }
    
    function getId() {
        return $this->id;
    }

    function getClientid() {
        return $this->clientid;
    }

    function getUserid() {
        return $this->userid;
    }

    function getContent() {
        return $this->content;
    }

    function getEntered() {
        return $this->entered;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setClientid($clientid) {
        $this->clientid = $clientid;
    }

    function setUserid($userid) {
        $this->userid = $userid;
    }

    function setContent($content) {
        $this->content = $content;
    }

    function setEntered($entered) {
        $this->entered = $entered;
    }

    public function setNoteById($id) {
        if(!is_numeric($id)) {
            show_404();
        }
        $sql = "SELECT "
                . "* "
                . "FROM `notes` where id = $id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $this->setClientid($row->clientid);
                $this->setUserid($row->userid);
                $this->setContent($row->content);
                $this->setEntered($row->entered);
            }
        }
    }
    
    public function getNoteById($id) {
        if(!is_numeric($id)) {
            show_404();
        }
        $this->setNoteById($id);
        $arrNote = array(
            "clientid" => $this->getClientid(),
            "userid" => $this->getUserid(),
            "content" => $this->getContent(),
            "entered" => $this->getEntered()
        );
        return $arrNote;
    }
    
    public function getNotesByClient($id) {
        if(!is_numeric($id)) {
            show_404();
        }
        $sql = "SELECT
                    a.*,
                    concat(b.first_name,' ',b.last_name) as username
                FROM
                    `notes` a
                left join
                    users b on b.id = a.userid
                where clientid = $id";
        $query = $this->db->query($sql);
        $notes = array();
        if ($query->num_rows() > 0) {
            $tick = 0;
            foreach($query->result() as $row) {
                $notes[$tick]['clientid'] = $row->clientid;
                $notes[$tick]['username'] = $row->username;
                $notes[$tick]['content'] = $row->content;
                $notes[$tick]['entered'] = $row->entered;
                $tick++;
            }
        }
        return $notes;
    }
    
    public function addNote() {
        $data = array(
            'clientid' => $this->getClientid(),
            'userid' => $this->getUserid(),
            'content' => $this->getContent()
        );
        
        $this->db->insert('notes', $data);
    }
    
}