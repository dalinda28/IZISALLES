<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, origin");

require_once ('../models/Users.php');

$model = new Users();

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method === 'OPTIONS') {
    return $error;
}

switch($request_method){
    case 'GET':
        if(!empty($_GET["id"]))
        {
            // Récupérer un seul user
            $id = intval($_GET["id"]);
            $sql = $model->getUser($id);
        }
        else
        {
            // Récupérer tous les users
            $sql = $model->getUsers();
        }

        header('Content-Type: application/json');
        echo json_encode($sql->fetchAll());
        
        break;

    case 'POST':
        // Ajouter un user
        $sql = $model->addUser();

        header('Content-Type: application/json');
        echo json_encode($sql);

        break;

    case 'PUT':
        // Modifier un user
        $array = json_decode(file_get_contents('php://input'), true);
        foreach ($array as $key => $value){
            $_POST["$key"]="$value";
        }
        $sql = $model->updateUser();

        header('Content-Type: application/json');
        echo json_encode($sql);

        break;

        case 'DELETE':
            // Supprimer un user
            $id = intval($_GET["id"]);
            $sql = $model->deleteUser($id);
    
            header('Content-Type: application/json');
            echo json_encode($sql);
    
            break;
    
        default:
            // Requête invalide
            header("HTTP/1.0 405 Method Not Allowed");
            break;
}

?>