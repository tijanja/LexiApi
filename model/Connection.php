<?php

class Connection
{
    
    function __construct()
    {
        $this->connect();
    }


    private function connect()
    {
        mysql_connect("localhost","root","Project123");
        mysql_select_db("lexi");
    }
}
 new Connection();
?>