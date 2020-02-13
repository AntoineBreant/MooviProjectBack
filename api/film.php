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
$param2= isset($_GET['titre']);
$param3= isset($_GET['date1']);
$param4= isset($_GET['date2']);
$param5= isset($_GET['genre']);
$param6= isset($_GET['idClient']);
//permet de choper la methode (get, post, put, etc...)

if ($method=='GET'){
  if((!$param) && (!$param2) && (!$param3) && (!$param4) && (!$param5) && (!$param6)){
    findAll();
  }
  elseif (($param) && (!$param2) && (!$param3) && (!$param4) && (!$param5) && (!$param6)) {
    $idFilm=$_GET['idFilm'];
    find($idFilm);  
  }
  elseif ((!$param) && ($param2) && (!$param3) && (!$param4) && (!$param5) && (!$param6)) {
    $titre=$_GET['titre'];
    rechercheTitre($titre);
  }
  elseif ((!$param) && (!$param2) && ($param3) && ($param4) && (!$param5) && (!$param6)) {
    $date1=$_GET['date1'];
    $date2=$_GET['date2'];
    rechercheDate($date1, $date2);
  }

  elseif ((!$param) && (!$param2) && (!$param3) && (!$param4) && ($param5) && (!$param6)) {
    $genre=$_GET['genre'];
    rechercheGenre($genre);
  }

  elseif ((!$param) && (!$param2) && (!$param3) && (!$param4) && (!$param5) && ($param6)) {
    $idClient=$_GET['idClient'];
    historique($idClient);
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

function rechercheTitre($titre){
  $connection=openCon();

  $query=$connection->query("select * from t_film_fil where fil_nom LIKE '%" . $titre . "%' OR fil_realisateur LIKE '%" . $titre . "%' OR fil_resume LIKE '%" . $titre . "%';");

  $tab;
  while($result=$query->fetch_assoc()){
    $tab[]=$result;
  }
  echo(utf8_encode(json_encode($tab)));
  closeCon($connection);
}

function rechercheDate($date1, $date2){
  $connection=openCon();

  $query=$connection->query("select * from t_film_fil where fil_dateSortie >= '" . $date1 ."' and fil_dateSortie <= '" .$date2 . "';");

  $tab;
  while($result=$query->fetch_assoc()){
    $tab[]=$result;
  }
  echo(utf8_encode(json_encode($tab)));
  closeCon($connection);
}

function rechercheGenre($genre){
  $connection=openCon();

  $query=$connection->query("select F.fil_idFilm, F.fil_nom, F.fil_duree, F.fil_noteMoyenne, F.fil_resume, F.fil_dateSortie, F.fil_realisateur, F.fil_bandeAnnonce from t_film_fil F, t_genre_gen G, t_fil_gen FG where G.gen_nom='". $genre ."' AND F.fil_idFilm = FG.con_idFilm AND FG.con_idGenre = G.gen_idGenre;");

  $tab;
  while($result=$query->fetch_assoc()){
    $tab[]=$result;
  }
  echo(utf8_encode(json_encode($tab)));
  closeCon($connection);
}

function historique($idClient){
  $connection=openCon();

  $query=$connection->query("SELECT F.fil_idFilm, F.fil_nom, F.fil_duree, F.fil_noteMoyenne, F.fil_resume, F.fil_dateSortie, F.fil_realisateur, F.fil_bandeAnnonce FROM t_film_fil F, t_cde_fil CF, t_commande_cde CD, t_client_cli C WHERE C.cli_idClient = " . $idClient . " AND C.cli_idClient = CD.cde_idClient AND CD.cde_idCommande = CF.eff_idCommande AND CF.eff_idFilm = F.fil_idFilm;");

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
