<?php 
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"),true);
//permet de choper les variables données par le client

$method = $_SERVER['REQUEST_METHOD'];
if ($method=='POST'){
    $data = json_decode(file_get_contents("php://input"),true);
    createComment($data);
} 

function createComment($data){
    var_dump($data);
}
