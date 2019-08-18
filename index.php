<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
try
{
//	$params = $_REQUEST;
        
  //      $controller = ucfirst(strtolower(trim($params['controller'])));
//        $action = strtolower(trim($params['action']))."Action";

$obj1 = file_get_contents("php://input",true);
$obj = json_decode($obj1,true);

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
