<?php 
include('db_connector.php');

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"),true);
//permet de choper les variables données par le client

$method = $_SERVER['REQUEST_METHOD'];
if ($method=='POST'){
    $data = json_decode(file_get_contents("php://input"),true);
    createComment($data);
} elseif ($method=='GET') {

    if(isset($_GET['idClient']) && $_GET['idFilm']){
        canComment($_GET['idClient'],$_GET['idFilm']);
        exit;
    }
    if(isset($_GET['idFilm'])){
        findWithFilmId($_GET['idFilm']);
        exit;
    }    

} 


function findWithFilmId($idFilm){
    $connection=openCon();
    $query=$connection->query('select * from t_commentaire_com a join t_client_cli b on a.com_idClient=b.cli_idClient where com_idFilm='.$idFilm.' ;');
    $tab;
    while($result=$query->fetch_assoc()){
      $tab[]=$result;
    }
    
   echo(utf8_encode(json_encode($tab)));
    
    closeCon($query);
}

function canComment($idClient, $idFilm) {
    $connection=openCon();
    $query=$connection->query('select count(*) from t_cde_fil a join t_commande_cde b on a.eff_idCommande=b.cde_idCommande where eff_idFilm='.$idFilm.' and cde_idClient='.$idClient.' ;');
    $result=$query->fetch_assoc();
    if($result['count(*)']>=1){
        echo 'true';
    }
    else 
    echo 'false';    
    closeCon($query);
    closeCon($connection);

}

function createComment($data){
    $connection=openCon();
    $datedujour = date('Y-m-d');    
    $querySelect=$connection->query("INSERT INTO t_commentaire_com (com_idFilm, com_idClient, com_texte, com_date, com_note) VALUES ('". $data['idFilm'] ."','".$data['idClient'] . "', '". $data['texte'] . "', '". $datedujour . "', '". $data['note'] ."');");
    
    $query=$connection->query("SELECT max(com_idCommentaire) as idMax FROM t_commentaire_com ;");
    $result=$query->fetch_assoc();

    if(isset($data['photo'])){
        foreach ($data['photo'] as $d){
            $query2=$connection->query("INSERT INTO t_photo_pho (pho_idCommentaire, pho_lien) VALUES ('". $result['idMax'] ."','".$d['lien'] . "');");
        }   
    }
    closeCon($connection);


}
