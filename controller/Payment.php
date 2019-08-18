<?php

    if(file_get_contents("https://google.com"))
    {
        echo file_get_contents("https://google.com",true);
    }
    else
    {
        throw new Exception("Error cant read url contents");
    }