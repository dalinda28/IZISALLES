<?php
header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, origin");

require_once ('../models/Salles.php');

$model = new Salles();

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method === 'OPTIONS') {
    return $error;
}

switch($request_method){
    case 'GET':
        if(!empty($_GET["id"]))
        {
            // Récupérer un seule salle
            $id = intval($_GET["id"]);
            $sql = $model->getSalle($id);
            
        }
        else
        {
            // Récupérer toutes les salles
            $sql = $model->getSalles();
        }

        header('Content-Type: application/json');
        echo json_encode($sql->fetchAll());
        
        break;

    case 'POST':
        // Ajouter un salle
        $sql = $model->addSalle();
        break;

    case 'PUT':
        // Modifier un salle
        $id = intval($_GET["id"]);
        $sql = $model->updateSalle($id);
        break;

    case 'DELETE':
        // Supprimer un salle
        $id = intval($_GET["id"]);
        $sql = $model->deleteSalle($id);
    default:
        // Requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

?>