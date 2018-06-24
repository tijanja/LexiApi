<?php

class Statute extends Connection
{
    var $query ;
     var $result;
     var $searchKeyWord;
     var $resultList;
     
     function __construct() {
         parent::__construct();
     }
             
    function getStatuteList($search)
    {
        if(preg_match("/[0-9]{4} No\. [0-9]{1,4}/i", $search))
                    {
                        preg_match_all("/[0-9]{4} No\. [0-9]{1,4}/i", $search, $matches);

                        foreach($matches[0] as $value)
                    {
                        $value;
                    }
                    $res =  explode(" ", $value);
                    $year= $res[0];
                    $no = $res[2];
                    
                    //echo '1';

                    $this->result = mysql_query("SELECT * FROM statute_citator WHERE statute_year='$year' and statute_num='$no';");  

                    
                    $items = array();
                    while($row=  mysql_fetch_array($this->result))
                    {
                       
                       $items[] = array('id' => $row['statuteid'], 'title' => $row["statute_title"],'year'=>$row['statute_year'],'number'=>$row['statute_num'],"commence"=>$row['commence_date']);

                    }
                    return $items;

                    }
                    else if (preg_match("/\[[0-9]{4}\] NELR\([0-9]{1,4}\)/i", $search))
                    {
                        preg_match_all("/\[[0-9]{4}\] NELR\([0-9]{1,4}\)/i", $search, $matches);

                        foreach($matches[0] as $value)
                    {
                        $value;
                    }
                    $res =  explode(" ", $value);
                    $year= $res[0];

                    $no = $res[1];

                    //echo '2';
                    //$sql ='select * from case_citator where'; 
                    }
                    else if (preg_match("/\[[0-9]{4}\] NELR \([0-9]{1,4}\)/i", $search))
                    {
                      //echo 'it works123'; 
                    }
                    else if (preg_match("/[0-9]{4}/", $search)) 
                    {
                        preg_match_all("/[0-9]{4}/", $search, $matches);

                        foreach($matches[0] as $value)
                    {
                        $value;
                    }
                    $res =  explode(" ", $value);
                    $year= $res[0];
                    $no = $res[2];
                    //echo '7';
                    $this->result = mysql_query("SELECT * FROM statute_citator WHERE statute_year='$year';");  
                    
                    $items = array();
                    while($row=  mysql_fetch_array($this->result))
                    {
                       
                       $items[] = array('id' => $row['statuteid'], 'title' => $row["statute_title"],'year'=>$row['statute_year'],'number'=>$row['statute_num'],"commence"=>$row['commence_date']);

                    }
                    return $items;

                    }
                    else if(preg_match("/[A-Za-z0-9]* Vs [A-Za-z0-9]*/i", $search))
                    {
                       
                        preg_match_all("/[A-Za-z0-9]* Vs [A-Za-z0-9]*/i",$search,$matches);
                        foreach($matches[0] as $values)
                        {
                           $values;
                        }

                        $res =  explode(" ", $values);
                        echo $plaintiff= $res[0]."<br/>";
                        echo $defendant = $res[2];

                        $this->result = mysql_query("SELECT * FROM statute_citator WHERE plaintiff='$plaintiff' or defendant='$defendant';");  
                        $items = array();
                    while($row=  mysql_fetch_array($this->result))
                    {
                       
                       $items[] = array('id' => $row['statuteid'], 'title' => $row["statute_title"],'year'=>$row['statute_year'],'number'=>$row['statute_num']);

                    }
                    return $items;
                    }      
                    else if(preg_match("/[A-Za-z0-9] /i", $search))
                    {
                       echo '3';
                        $this->result = mysql_query("SELECT * FROM statute_citator WHERE statute_title like '%$this->searchKeyWord%' or '$this->searchKeyWord%' or '%$this->searchKeyWord';");    
                    
                        $items = array();
                    while($row=  mysql_fetch_array($this->result))
                    {
                       
                       $items[] = array('id' => $row['statuteid'], 'title' => $row["statute_title"],'year'=>$row['statute_year'],'number'=>$row['statute_num'],"commence"=>$row['commence_date']);

                    }
                    return $items;
                    }
                    else if(preg_match("/[A-Za-z0-9] [A-Za-z0-9]/i", $search))
                    {
                       echo '4';
                    //return 'just words!!'; 
                    }
                    else 
                    {
                        //echo 'na here!!';
                        $this->result = mysql_query("SELECT * FROM statute_citator WHERE statute_title LIKE '%$this->searchKeyWord%'  limit 10;");   
                    
                        $items = array();
                    while($row=  mysql_fetch_array($this->result))
                    {
                       
                       $items[] = array('id' => $row['statuteid'], 'title' => $row["statute_title"],'year'=>$row['statute_year'],'number'=>$row['statute_num']);

                    }
                    return $items;
                    }
        
        
        /*$sql = "Select * from statute_citator where statute_title like '%$query';";
        $res =  mysql_query($sql);
        $items = array();
        
        while($row=  mysql_fetch_array($res))
        {
           $arrayList[]=$row["statute_title"]; 
           $items[] = array('id' => $row['statuteid'], 'title' => $row["statute_title"],'year'=>$row['statute_year'],'number'=>$row['statute_num']);
            
        }
        return $items;*/
    
    }
    
    function newSearch($param)
    {
        $search = $param->search_query;
        
        $this->result = $this->db->query("SELECT * FROM statute_citator WHERE statute_title like '%$search%' or statute_year='$search';");  
                    
                    $items = array();
                    while($row=  mysql_fetch_array($this->result))
                    {
                     
                        /*$retrieved = str_replace("-","",$row['commence_date']);
                        $date = DateTime::createFromFormat('Ymd', $retrieved);
                        $newDate=$date->format('d/m/Y');*/
                       $items[] = array('id' => $row['statuteid'], 'title' => $row["statute_title"],'year'=>$row['statute_year'],'number'=>$row['statute_num'],"commence"=>$row['commence_date']);
                    }
                    return $items;
    }
            
    function getPartSubpartSection($statuteid)
    {
        $sql = "Select * FROM statute_part WHERE statuteid='$statuteid';";
        $res = mysql_query($sql);
        
        //$list = mysql_fetch_array($res);
        
        if(mysql_num_rows($res)!=0)
        {
           while($row= mysql_fetch_array($res))
            {
                $items[] = array("partid"=>$row['id'],"statuteid"=>$row["statuteid"],"part_title"=>$row["part_title"],"type"=>"PART");
            } 
        }
        else
        {
            $sql = "Select * FROM statute_sections WHERE statuteid='$statuteid';";
            $res = mysql_query($sql);
            
          
            
            
            while($row= mysql_fetch_array($res))
            {
                $items[] = array("section_title"=>$row['section_title'],"section_text"=>preg_replace("/&#?[a-z0-9]+;/i","",strip_tags($row["section_text"])),"type"=>"SECTION");
            } 
        }

        
        return $items;
        
    }
    
  
  function subpart_section_List($params)
  {
      $partid = $params['partid'];
      $statuteid= $params['statuteid'];
      
      $sql="select * from statute_subpart where statuteid='$statuteid' and partid='$partid';";
      $res = mysql_query($sql);
      
      if(mysql_num_rows($res)!=0)
      {
          while($row= mysql_fetch_array($res))
          {
             $items[] = array("type"=>"SUBPART","subpartid"=>$row['id'],"partid"=>$row['partid'],"statuteid"=>$row['statuteid'],"subpart_title"=>$row['subpart_title']); 
          }
      }
     else
     {
         $sql = "Select * FROM statute_sections WHERE statuteid='$statuteid' AND partid= '$partid';";
            $res = mysql_query($sql);
            
          
            
            
            while($row= mysql_fetch_array($res))
            {
                $items[] = array("type"=>"SECTION","section_title"=>$row['section_title'],"section_text"=>preg_replace("/&#?[a-z0-9]+;/i","",strip_tags($row["section_text"])));
            }  
      }
      
      
      return $items; 
  }
  
    function section_list($params)
    {
        $statuteid = $params['statuteid'];
        $partid = $params['partid'];
        $subpartid = $params['subpartid'];

        $sql = "Select * FROM statute_sections WHERE statuteid='$statuteid' AND partid= '$partid' AND subpartid='$subpartid';";
        $res = mysql_query($sql);

              while($row= mysql_fetch_array($res))
              {
                  $items[] = array("type"=>"SECTION","section_title"=>$row['section_title'],"section_text"=>preg_replace("/&#?[a-z0-9]+;/i","",strip_tags($row["section_text"])));
              } 

              return $items; 
    }
}
