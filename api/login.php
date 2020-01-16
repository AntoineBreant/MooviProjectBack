<?php 
include('db_connector.php');
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];
$param= isset($_GET['login']);
//permet de choper la pethode (get, post, put, etc...)

$param2= isset($_GET['password']);
//permet de choper la pethode (get, post, put, etc...)

if ($method=='GET'){
  if($param && $param2){
      seConnecter($_GET['login'], $_GET['password']);
  }

}

function seConnecter($login, $password){
    $connection=openCon();

    $query=$connection->query("select count(*), cli_idClient from t_client_cli WHERE cli_pseudo = '" . $login . "' AND cli_mdp = '" . $password . "';");
    $result=$query->fetch_assoc();

    if ($result['count(*)'] > 0)
    {
        $idClient=$result['cli_idClient'];
        $data['retour'] = true;
        $data['idClient'] = $idClient;
    } else {
        $data['retour'] = false;
    }
    echo (json_encode($data));
    closeCon($query);
}
?>