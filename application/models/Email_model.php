<?php
class Email_model extends CI_Model {
    
    private $config = array(
            "protocol"  => "smtp",
            "smtp_host" => "mail.newsletterpro.biz",
            "smtp_port" => "25",
            "smtp_user" => 'website@newsletterpro.biz',
            "smtp_pass" => "Q1w2e3R$",
            "charset" => 'utf-8',
            "newline" => "\r\n",
            "wordwrap" => TRUE,
            "mailtype" => 'html'
        );
    
    function isLocal() {
        $local = true;
        if($_SERVER['SERVER_ADDR']!=="127.0.0.1") {
            $local = false;
        }
        return $local;
    }
    
    function getConfig() {
        return $this->config;
    }

    public function __construct() {
            $this->load->database();
    }

}