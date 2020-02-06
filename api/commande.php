<?php 
include('db_connector.php');

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//$data = json_decode(file_get_contents("php://input"),true);
//permet de choper les variables données par le client

$method = $_SERVER['REQUEST_METHOD'];
if ($method=='POST'){
    $data = json_decode(file_get_contents("php://input"),true);
    createCommande($data);
} 

function createCommande($data){
    $connection=openCon();
    $datedujour = date('Y-m-d');    
    $querySelect=$connection->query("INSERT INTO t_commande_cde (cde_idClient, cde_statut, cde_date) VALUES ('". $data['idClient'] ."', 'Commandé', '". $datedujour . "');");
    
    $query=$connection->query("SELECT max(cde_idCommande) as idMax FROM t_commande_cde ;");
    $result=$query->fetch_assoc();

    foreach ($data['film'] as $d){
        $query2=$connection->query("INSERT INTO t_cli_cde (eff_idCommande, eff_idFilm) VALUES ('". $result['idMax'] ."','".$d['idFilm'] . "');");
        
    }
    closeCon($connection);
    
}
