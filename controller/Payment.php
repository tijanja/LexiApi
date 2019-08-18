<?php

    if(file_get_contents("http://206.189.115.158/LexiApi/?controller=Merchant&action=partList&statuteId=327"))
    {
        print_r(json_decode(file_get_contents("http://206.189.115.158/LexiApi/?controller=Merchant&action=partList&statuteId=327",true),true));
    }
    else
    {
        throw new Exception("Error cant read url contents");
    }