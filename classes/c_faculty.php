<?php
require_once('../../includes/database.php');

class Faculty_Account {
    public $firstname;
    public $middlename;
    public $lastname;
    public $username;
    public $email;
    public $password;
    public $faculty_role;
    public $identification;

    public function create_faculty_acc(){
        global $db;

        $sql = "INSERT INTO tbl_accounts (firstname, middlename, lastname, username, email, password, faculty_role, identification) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $db->process_db($sql, "ssssssss", false, $this->firstname, $this->middlename, $this->lastname, $this->username, $this->email, $this->password, $this->faculty_role, $this->identification);
    }

    public function check_existing(){
        global $db;

        $sql = "SELECT * FROM tbl_accounts WHERE username = ? OR email = ?";
        if(!empty(($db->process_db($sql, "ss", true, $this->username, $this->email)))) {
            return true;
        }
    }
    
}