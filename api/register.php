<?php 
include('db_connector.php');
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];
$param= isset($_GET['login']);
$param2= isset($_GET['password']);
$param3= isset($_GET['prenom']);
$param4= isset($_GET['nom']);


if ($method=='GET'){
  if($param && $param2 && $param3 && $param4){
      sInscrire($_GET['login'], $_GET['password'], $_GET['prenom'], $_GET['nom']);
  }

}

function sInscrire($login, $password, $prenom, $nom){
    $connection=openCon();

    $query=$connection->query("select count(*), cli_idClient from t_client_cli WHERE cli_pseudo = '" . $login . "' AND cli_mdp = '" . $password . "';");
    $result=$query->fetch_assoc();
    closeCon($query);

    if ($result['count(*)'] > 0)
    {
        $data['retour'] = false;
    } else {
        $query2=$connection->query("INSERT INTO t_client_cli (cli_pseudo, cli_mdp, cli_nom, cli_prenom) VALUES ('". $login ."','". $password . "', '". $nom . "', '". $prenom ."');");
        $data['retour'] = true;
    }
    echo (json_encode($data));
    
}
?>