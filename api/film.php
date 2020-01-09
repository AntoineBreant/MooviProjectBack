<?php 
include('db_connector.php');
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//$data = json_decode(file_get_contents("php://input"));
//permet de choper les variables données par le client

//permet de choper le chemin

/* ------------REQUETE TYPE -----------------*/
$connection=openCon();
$query=$connection->query('select * from t_film_fil');
$tab;
while($result=$query->fetch_assoc()){
  $tab[]=$result;
}

var_dump(utf8_encode(json_encode($tab)));

closeCon($query);

/* -----------------------------------------*/
$method = $_SERVER['REQUEST_METHOD'];
$param= isset($_GET['idFilm']);
//permet de choper la pethode (get, post, put, etc...)

if ($method=='GET'){
  if(!$param){
    findAll();
  }
  else {
    $idFilm=$_GET['idFilm'];
    find($idFilm);
  }
}

 function findAll(){
  echo ('[
            {
              "idFilm" : 1,
              "titre" : "les evades"
            },
            {
              "idFilm" : 2,
              "titre" : "deuxiemeFilm"
            }
          ]');
}

function find($idFilm){
  echo ('
            {
              "idFilm" : 1,
              "titre" : "les evades"
            }
          ');
}
