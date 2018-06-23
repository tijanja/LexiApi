<?php

class Connection
{
    
    function __construct()
    {
        $this->connect();
    }


    private function connect()
    {
        mysql_connect("localhost","gpaye_lex","Project123");
        mysql_select_db("gpayexpress1_lex");
    }
}
 new Connection();
?>