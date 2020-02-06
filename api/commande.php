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
    createCommande($data);
} elseif ($method=='GET') {

    if(isset($_GET['idClient'])){
        canComment($_GET['idClient']);
        exit;
} 

function createCommande($data){
    $connection=openCon();
    $datedujour = date('Y-m-d');    
    $query=$connection->query("INSERT INTO t_commande_cde (cde_idClient, cde_statut, cde_date) VALUES ('". $data['idClient'] ."', 'Commandé', '". $datedujour . "');");
    $result=$query->fetch_assoc();
    
    $query=$connection->query("SELECT cde_idCommande FROM t_commande_cde WHERE com_idClient = '" . $data['idClient'] . "' AND cde_date = '" . $datedujour . "';");
    $result=$query->fetch_assoc();
    

    foreach ($d as $data['film']){
        $query2=$connection->query("INSERT INTO t_cde_fil (eff_idCommande, eff_idFilm) VALUES ('". $result['cde_idCommande'] ."','".$d['idFilm'] . "');");
        $result2=$query2->fetch_assoc();
        
    }
    closeCon($query);
    closeCon($query2);
    
}
