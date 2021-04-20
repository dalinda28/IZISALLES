<?php
require_once ('../config/database.php');

class Salles {
    protected $pdo;

    public function __construct(){
        global $pdo;
        $pdo = getPdo();
    }

    public function getSalles() {
        global $pdo;
        $sql = $pdo->query('SELECT * FROM Salle');
        $sql->setFetchMode(\PDO::FETCH_ASSOC);
        return $sql;
    }

    public function getSalle($id=0) {
        global $pdo;
        if ($id!=0){
            $sql = $pdo->query("SELECT * FROM Salle WHERE Salle.id = $id");
            $sql->setFetchMode(\PDO::FETCH_ASSOC);
            return $sql;
        }
        else {
            return null;
        }
    }

    public function addSalle(){
        global $pdo;
        $nom = $_POST["nom"];
        $places = $_POST["places"];
        $postes_etud = $_POST["postes_etud"];
        $postes_prof = $_POST["postes_prof"];
        $climatisation = $_POST["climatisation"];

        if ($nom && $places && $postes_etud && $postes_prof && $climatisation) {
            echo $query="INSERT INTO Reservation(nom, places, postes_etud, postes_prof, climatisation)
            VALUES('".$nom."', '".$places."', '".$postes_etud."', '".$postes_prof."','".$climatisation."')";

            if (!$pdo->query($query)){
                echo "Erreur: les données ne se sont pas insérées dans la BDD";
            }
        }
        else {
            echo "Erreur: les données ne se sont pas insérées dans la BDD (données manquantes)";
        }
    }

    public function updateSalle($id){
        // Remplir fonction pour mettre à jour une réservation de la BDD
    }

    public function deleteSalle($id){
        // Remplir fonction pour supprimer une réservation de la BDD
    }
}
?>