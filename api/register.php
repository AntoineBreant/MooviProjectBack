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
    sInscrire($data);
}

function sInscrire($data){
    $connection=openCon();

    $query=$connection->query("select count(*), cli_idClient from t_client_cli WHERE cli_pseudo = '" . $data['login']. "';");
    $result=$query->fetch_assoc();
    
    if ($result['count(*)'] > 0)
    {
        $data['retour'] = false;
    } else {
        $query2=$connection->query("INSERT INTO t_client_cli (cli_pseudo, cli_mdp, cli_nom, cli_prenom) VALUES ('". $data['login'] ."','". $data['password'] . "', '". $data['nom'] . "', '". $data['prenom'] ."');");
        $data['retour'] = true;
    }
    echo (json_encode($data));
    closeCon($connection);
}
?>