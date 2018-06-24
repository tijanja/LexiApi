<?php 
 class Connection
{
    var $db;
    function __construct() {
        $this->db = new mysqli("localhost","root","Project12");
        
        if($this->db->connect_errno > 0){
            die('Unable to connect to database [' . $this->db->connect_error . ']');
        }

    }
    function getDBObject()
    {
        return $this->db; 
    }
}
