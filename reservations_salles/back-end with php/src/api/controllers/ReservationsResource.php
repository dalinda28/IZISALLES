<?php
header("Access-Control-Allow-Origin:*");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, origin");

require_once ('../models/Reservations.php');

$model = new Reservations();

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method === 'OPTIONS') {
    return $error;
}

switch($request_method){
    case 'GET':
        if(!empty($_GET["id"]))
        {
            // Récupérer une seule réservation
            $id = intval($_GET["id"]);
            $sql = $model->getReservation($id);
            
        }
        else if(!empty($_GET["id_user"])){
             // Récupérer les réservations d'un user
             $id = intval($_GET["id_user"]);
             $sql = $model->getReservationsByUser($id);
        }
        else
        {
            // Récupérer toutes les réservations
            $sql = $model->getReservations();
        }

        header('Content-Type: application/json');
        echo json_encode($sql->fetchAll());
        
        break;

    case 'POST':
        // Ajouter une réservation
        $sql = $model->addReservation();

        header('Content-Type: application/json');
        echo json_encode($sql);

        break;

    case 'PUT':
        // Modifier une réservation
        $array = json_decode(file_get_contents('php://input'), true);
        foreach ($array as $key => $value){
            $_POST["$key"]="$value";
        }
        $sql = $model->updateReservation();

        header('Content-Type: application/json');
        echo json_encode($sql);

        break;

    case 'DELETE':
        // Supprimer une réservation
        if (!empty($_GET["id"])){
            $id = intval($_GET["id"]);
            $sql = $model->deleteReservation($id);
        }
        else if (!empty($_GET["id_user"])){
            $id = intval($_GET["id_user"]);
            $sql = $model->deleteReservationsByUser($id);
        }
        

        header('Content-Type: application/json');
        echo json_encode($sql);

        break;

    default:
        // Requête invalide
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

?>