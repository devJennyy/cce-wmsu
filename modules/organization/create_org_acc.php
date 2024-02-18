<?php
    include_once '../../classes/c_organization.php';
    include_once '../../includes/functions.php';
    include_once '../../includes/database.php';

        $organization = new Organization();

        $encrypted_pwd = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $organization->firstname = ucfirst($_POST["firstname"]);
        $organization->middlename = ucfirst($_POST["middlename"]);
        $organization->lastname = ucfirst($_POST["lastname"]);
        $organization->username = $_POST["username"];
        $organization->email = $_POST["email"];
        $organization->password = $encrypted_pwd;
        $organization->faculty_role = "Organization";

        $organization->org_name = $_POST["org-name"];
        $organization->org_shortname = $_POST["org-shortname"] . " " . $_POST["org-suffix"];
        $organization->org_descrip = $_POST["description"];
        $organization->org_activities = $_POST["activities"];
        $organization->org_mission = $_POST["mission"];
        $organization->org_goal = $_POST["goal"];

        // Add File Handling
        $fileName = $_FILES['identification']['name'];
        $fileTmpName = $_FILES['identification']['tmp_name'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if(in_array($fileActualExt, $allowed)){
            $fileNameNew = $fileName;
            $filesDestination = '../../assets/attachments/faculty/' . $fileNameNew;

            move_uploaded_file($fileTmpName, $filesDestination);
            $organization->identification = "$fileNameNew";
        }
        else {
            echo "File type not allowed!";
        }

        $fileName = $_FILES['logo']['name'];
        $fileTmpName = $_FILES['logo']['tmp_name'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png', 'gif');

        if(in_array($fileActualExt, $allowed)){
            $fileNameNew = $fileName;
            $filesDestination = '../../assets/attachments/faculty/' . $fileNameNew;

            move_uploaded_file($fileTmpName, $filesDestination);
            $organization->org_logo = "$fileNameNew";
        }
        else {
            echo "File type not allowed!";
        }
        
        if($organization->check_existing()){
            echo "User already exist!";
            exit();
        }
        else {
            $lastid = $organization->create_org_acc();
            $orgid = $organization->create_org($lastid);
            $organization->add_member($lastid, $orgid, "Admin");
            
            echo login_user($db, $organization->username, $organization->email, $_POST["password"]);
        }

