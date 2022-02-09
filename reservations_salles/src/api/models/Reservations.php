<?php
require_once ('../config/database.php');

class Reservations {
    protected $pdo;

    public function __construct(){
        global $pdo;
        $pdo = getPdo();
    }

    public function getReservations() {
        global $pdo;
        $sql = $pdo->query('SELECT * FROM Reservation');
        $sql->setFetchMode(\PDO::FETCH_ASSOC);
        return $sql;
    }

    public function getReservation($id=0) {
        global $pdo;
        if ($id!=0 || $id!=null){
            $sql = $pdo->query("SELECT * FROM Reservation WHERE Reservation.id = $id");
            $sql->fetch();
            return $sql;
        }
        else {
            return null;
        }
    }

    public function getReservationsByUser($id){
        global $pdo;
        if ($id!=0 || $id!=null){
            $sql = $pdo->query("SELECT * FROM Reservation WHERE id_user = $id");
            $sql->setFetchMode(\PDO::FETCH_ASSOC);
            return $sql;
        }
    }

    public function addReservation(){
        global $pdo;
        $id_salle = $_POST["id_salle"];
        $id_user = $_POST["id_user"];
        $date = $_POST["date"];
        $heure = $_POST["heure"];
        
        if ($id_salle!=null && $id_user!=null && $date!=null && $heure!=null) {
            if (!$this->findReservation($id_salle, $date, $heure)) {
                $query="INSERT INTO Reservation(id_salle, id_user, date, heure)
                VALUES('".$id_salle."', '".$id_user."', '".$date."', '".$heure."')";
                if (!$pdo->query($query)){
                    echo "Erreur: les données ne se sont pas insérées dans la BDD";
                    return false;
                }
                return true;
            }
            else {
                return false;
            }
        }
        else {
            echo "Erreur: les données ne se sont pas insérées dans la BDD (données manquantes)";
            return false;
        }      
    }

    public function updateReservation(){
        global $pdo;
        $id_reserv = $_POST["id_reserv"];
        $id_salle = $_POST["id_salle"];
        $newdate = $_POST["date"];
        $newheure = $_POST["heure"];
        if (!$this->findReservation($id_salle, $newdate, $newheure)) {
            $query = "UPDATE Reservation SET date = '$newdate', heure = '$newheure' WHERE id = '$id_reserv'";
            if (!$pdo->query($query)){
                echo "Erreur: les données ne se sont pas insérées dans la BDD";
                return false;
            }
            return true;
        }
        else {
            return false;
        }
    }

    public function deleteReservation($id){
        global $pdo;     
        $query = $pdo->query("DELETE FROM Reservation WHERE id = '$id'");
        $count = $query->rowCount();
        if ($count == 0){
            return "Erreur: les données saisies n'ont pas pu être supprimées de la BDD";
        }
        else {
            return "ok";
        }
    
    }

    public function deleteReservationsByUser($id){
        global $pdo;     
        $query = $pdo->query("DELETE FROM Reservation WHERE id_user = '$id'");
        $count = $query->rowCount();
        return "ok";

    }

    public function findReservation($id_salle, $date, $heure){
        global $pdo;
        $sql = $pdo->query("SELECT * FROM Reservation WHERE id_salle = '$id_salle' AND date = '$date' AND heure = '$heure'");
        $sql->setFetchMode(\PDO::FETCH_ASSOC);
        return $sql->fetch();
    }
}
?>