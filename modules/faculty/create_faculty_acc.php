<?php
    include_once '../../classes/c_faculty.php';
    include_once '../../includes/functions.php';
    include_once '../../includes/database.php';


        $acc_faculty = new Faculty_Account();

        $encrypted_pwd = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $acc_faculty->firstname = ucfirst($_POST["firstname"]);
        $acc_faculty->middlename = ucfirst($_POST["middlename"]);
        $acc_faculty->lastname = ucfirst($_POST["lastname"]);
        $acc_faculty->username = $_POST["username"];
        $acc_faculty->email = $_POST["email"];
        $acc_faculty->password = $encrypted_pwd;
        $acc_faculty->faculty_role = $_POST["faculty"];

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
            $acc_faculty->identification = "$fileNameNew";
        }
        else {
            echo "File type not allowed!";
        }
        
        
        if($acc_faculty->check_existing()){
            echo "User already exist!";
            exit();
        }
        else {
            $acc_faculty->create_faculty_acc();

            echo login_user($db, $acc_faculty->username, $acc_faculty->email, $_POST["password"]);
        }
        

?>