<?php 
include('db_connector.php');
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//$data = json_decode(file_get_contents("php://input"));
//permet de choper les variables données par le client

//permet de choper le chemin


$method = $_SERVER['REQUEST_METHOD'];

if ($method=='GET'){
    getGenre();
} 

function getGenre(){
    $connection=openCon();
    $query=$connection->query('SELECT gen_idGenre, gen_nom FROM t_genre_gen');
    $tab;
    while($result=$query->fetch_assoc()){
      $tab[]=$result;
    }
  
   echo(utf8_encode(json_encode($tab)));
    
    closeCon($connection);
}