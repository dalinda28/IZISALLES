<?php
require_once ('../config/database.php');

class Users {
    protected $pdo;

    public function __construct(){
        global $pdo;
        $pdo = getPdo();
    }

    public function getUsers() {
        global $pdo;
        $sql = $pdo->query('SELECT * FROM User');
        $sql->setFetchMode(\PDO::FETCH_ASSOC);
        return $sql;
    }

    public function getUser($id=0) {
        global $pdo;
        if ($id!=0){
            $sql = $pdo->query("SELECT * FROM User WHERE User.id = $id");
            $sql->setFetchMode(\PDO::FETCH_ASSOC);
            return $sql;
        }
        else {
            return null;
        }
    }

    public function addUser(){
        global $pdo;
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $profil = $_POST["profil"];
        $mail = $_POST["mail"];
        $mdp = $_POST["mdp"];

        if (!$this->existsOtherUserWitSamehMail($mail, null)) {
            $query="INSERT INTO User(nom, prenom, profil, mail, mdp)
            VALUES('".$nom."', '".$prenom."', '".$profil."', '".$mail."', '".$mdp."')";
            
            if (!$pdo->query($query)){
                return "request_problem";
            }
            return "inserted";
        }
        else {
            return "exists_user_same_mail";
        }
    }

    public function updateUser(){
        global $pdo;
        $id = $_POST["id"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $mail = $_POST["mail"];
        $mdp = $_POST["mdp"];

        if (!$this->existsOtherUserWitSamehMail($mail, $id)) {
            $query = "UPDATE User SET nom = '$nom', prenom = '$prenom', mail = '$mail', mdp = '$mdp' WHERE id = '$id'";
            if (!$pdo->query($query)){
                return "request_problem";
            }
            return "updated";
        }
        else {
            return "exists_user_same_mail";
        }
    }

    public function deleteUser($id){
        global $pdo;     
        $query = $pdo->query("DELETE FROM User WHERE id = '$id'");
        $count = $query->rowCount();
        if ($count == 0){
            return "request_error";
        }
        else {
            return "ok";
        }
    }

    public function existsOtherUserWitSamehMail($mail, $id_user){
        global $pdo;
        if ($id_user!=null){
            $sql = $pdo->query("SELECT * FROM User WHERE mail = '$mail' AND id <> '$id_user'");
            $sql->setFetchMode(\PDO::FETCH_ASSOC);
            return $sql->fetch();
        }
        else {
            $sql = $pdo->query("SELECT * FROM User WHERE mail = '$mail'");
            $sql->setFetchMode(\PDO::FETCH_ASSOC);
            return $sql->fetch();
        }   
    }
}
?>