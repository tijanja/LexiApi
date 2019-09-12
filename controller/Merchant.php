<?php
include_once './model/include.php';

class Merchant
{
    private $_params;
    
    function __construct($params)
    {
        $this->_params = $params;
    }
    
    function createAction()
    {
       $reg = new Register($this->_params);
       return $reg->register();
    }
    
    function loginAction()
    {
         $client = new Client();
        return $client->getsaveData($this->_params['username'], $this->_params['password']);
    }
    
    function statuteListAction()
    {
        $statuteList = new Statute();
        return $statuteList->newSearch($this->_params);//getStatuteList($this->_params['search_query']);
    }
    
    function partListAction()
    {
        $statutePartList = new Statute();
        return $statutePartList->getPartSubpartSection($this->_params['statuteId']);
    }
    
    function subpartListAction()
    {
       $subPartList = new Statute();
       return $subPartList->subpart_section_List($this->_params);
    }
    
    function sectionListAction()
    {
        $statuteid = $this->params['statuteid'];
        $partid = $this->params['partid'];
        $subpartid = $this->params['subpartid'];

        $sql = "Select * FROM statute_sections WHERE statuteid='$statuteid' AND partid= '$partid' AND subpartid='$subpartid';";
        $res = mysql_query($sql);

              while($row= mysql_fetch_array($res))
              {
                  $first = preg_replace("/&#?[a-z0-9]+;/i","",strip_tags($row["section_text"]));
                  
                  preg_match_all('/\w+\./',preg_replace("/\r\n/", "",$first),$matches);
                  
                  for($i=0;$i<count($matches[0]);$i++)
                 {
                        $acts=explode(' ',$matches[0][$i]);
                        //$newString  = str_ireplace($matches[0][$i], $acts, $first);
                        $newString = str_replace($acts[$i],$acts[$i]."\n \n",$first);
                 } 
                 
                 
                  $items[] = array("type"=>"SECTION","section_title"=>$row['section_title'],"section_text"=>preg_replace("/\r\n/", "",$first));
              }   
        return $items;//$section->section_list($this->_params);
    }
    
    
    
}
