<?php

// if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
   // }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0); 
    }
 
try
{
//	$params = $_REQUEST;
        
  //      $controller = ucfirst(strtolower(trim($params['controller'])));
//        $action = strtolower(trim($params['action']))."Action";

$obj1 = file_get_contents("php://input");
$obj = json_encode($obj1,true);

var_dump($obj);

$controller = ucfirst(strtolower(trim($obj->controller)));
$action = strtolower(trim($obj->action))."Action";
if(file_exists("controller/{$controller}.php"))
{
include_once "controller/{$controller}.php";
}
else
{
  throw new Exception('Controller is invalid.');
}
$controller = new $controller($obj);
if(method_exists($controller, $action)===false)
{
throw new Exception('Action is invalid.');
}
$return = $controller->$action();
if($return !== FALSE)
{
$result["data"] = $return;
$result["success"] = TRUE;
}
else
{
$result["data"] =$return;
$result["success"] = FALSE;
}
}
catch( Exception $e ) {
//catch any exceptions and report the problem
$result = array();
$result['success'] = false;
$result['errormsg'] = $e->getMessage();
}
//echo the result of the API call
echo json_encode($result);
exit();
