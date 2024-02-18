<?php

class cce_db
{
    private $server_name = "localhost";
    private $db_user_name = "root";
    private $db_password = "";
    private $db_name = "db_cce";

    private $instance;

    function __construct()
    {
        $this->instance = mysqli_connect($this->server_name, $this->db_user_name, $this->db_password, $this->db_name);
        if (!$this->instance) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    function process_db($sql, $strings, $flag, ...$params){
        $stmt = mysqli_stmt_init($this->instance);
        mysqli_stmt_prepare($stmt, $sql);

        if($strings != "")
            mysqli_stmt_bind_param($stmt, $strings, ...$params);

        mysqli_stmt_execute($stmt);

        if($flag){
            $result = mysqli_stmt_get_result($stmt);
            $data = array();
    
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }
    
            return $data;
        }
        

        mysqli_stmt_close($stmt);
    }

    function insert_id() {
        return mysqli_insert_id($this->instance);
    }

    function __destruct() {
        mysqli_close($this->instance);
    }
}

date_default_timezone_set('Asia/Singapore');
$db = new cce_db();
