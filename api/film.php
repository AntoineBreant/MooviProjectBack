<?php 
include('db_connector.php');
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//$data = json_decode(file_get_contents("php://input"));
//permet de choper les variables données par le client

//permet de choper le chemin


$method = $_SERVER['REQUEST_METHOD'];
$param= isset($_GET['idFilm']);
//permet de choper la methode (get, post, put, etc...)

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
  $connection=openCon();
  $query=$connection->query('select * from t_film_fil');
  $tab;
  while($result=$query->fetch_assoc()){
    $tab[]=$result;
  }
  
 echo(utf8_encode(json_encode($tab)));
  
  closeCon($connection);
}

function find($idFilm){
  $connection=openCon();

  $query=$connection->query('select fil_idFilm, fil_nom, fil_duree, fil_noteMoyenne, fil_resume, fil_dateSortie, fil_realisateur, fil_bandeAnnonce from t_film_fil where fil_idFilm='.$idFilm.';');
  $result=$query->fetch_assoc();

  $data['fil_idFilm'] = $result['fil_idFilm'];
  $data['fil_nom'] = $result['fil_nom'];
  $data['fil_duree'] = $result['fil_duree'];
  $data['fil_noteMoyenne'] = $result['fil_noteMoyenne'];
  $data['fil_resume'] = $result['fil_resume'];
  $data['fil_dateSortie'] = $result['fil_dateSortie'];
  $data['fil_realisateur'] = $result['fil_realisateur'];
  $data['fil_bandeAnnonce'] = $result['fil_bandeAnnonce'];

  $query=$connection->query('select G.gen_nom from t_film_fil F, t_genre_gen G, t_fil_gen FG where F.fil_idFilm='.$idFilm.' AND F.fil_idFilm = FG.con_idFilm AND FG.con_idGenre = G.gen_idGenre;');
 
  while($result=$query->fetch_assoc()){
    $data['gen_nom'][]=$result['gen_nom'];
  }

  $query=$connection->query('select A.act_nom from t_film_fil F, t_acteur_act A, t_fil_act FA where F.fil_idFilm='.$idFilm.' AND F.fil_idFilm = FA.jou_idFilm AND FA.jou_idActeur = A.act_idActeur;');

  while($result=$query->fetch_assoc()){
    $data['act_nom'][]=$result['act_nom'];
  }

  echo(utf8_encode(json_encode($data)));
  closeCon($connection);
}
