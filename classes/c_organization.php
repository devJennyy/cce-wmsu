<?php
require_once('../../includes/database.php');

class Organization {
    public $firstname;
    public $middlename;
    public $lastname;
    public $username;
    public $email;
    public $password;
    public $faculty_role = "Organization";
    public $identification;

    public $org_name;
    public $org_shortname;
    public $org_logo;
    public $org_descrip;
    public $org_activities;
    public $org_mission;
    public $org_goal;


    public function create_org_acc(){
        global $db;

        $sql = "INSERT INTO tbl_accounts (firstname, middlename, lastname, username, email, password, faculty_role, identification) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $db->process_db($sql, "ssssssss", false, $this->firstname, $this->middlename, $this->lastname, $this->username, $this->email, $this->password, $this->faculty_role, $this->identification);
    
        return $db->insert_id();
    }

    public function create_org($lastid){
        global $db;
        
        $sql = "INSERT INTO tbl_organization (account_id, org_name, org_shortname, org_logo, org_descrip, org_activities, org_mission, org_goal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $db->process_db($sql, "ssssssss", false, $lastid, $this->org_name, $this->org_shortname, $this->org_logo, $this->org_descrip, $this->org_activities, $this->org_mission, $this->org_goal);
        
        return $db->insert_id();
    }

    public function check_existing(){
        global $db;

        $sql = "SELECT * FROM tbl_accounts WHERE username = ? OR email = ?";
        if(!empty(($db->process_db($sql, "ss", true, $this->username, $this->email)))) {
            return true;
        }
    }

    public function add_member($id, $orgid, $role){
        global $db;

        $sql = "INSERT INTO tbl_organization_members (account_id, organization_id, role) VALUES (?, ?, ?)";
        $db->process_db($sql, "sss", false, $id, $orgid, $role);
    }
}