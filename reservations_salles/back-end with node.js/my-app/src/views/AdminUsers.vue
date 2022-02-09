<template>
    <div class="container-fluid">
        <div class="row bar">
            <div class="col-lg-12 bg-dark">
                <h1 class="hellobar text-center text-light display-4 pt-2">Bonjour {{ $store.state.firstName }}</h1>
            </div>
            <div class="col-lg-12 bg-secondary">
                <h2 class="titlebar text-center text-light display-4 pt-2">Gestion des utilisateurs</h2>
            </div>
        </div> 
        <div class="row">
            <button class="col-sm-3 btn btn-info float-center ml-2" @click="showAddModal=true">
                Ajouter un nouvel utilisateur 
            </button>
            <div class="col-sm-7"></div>
        </div>
        <hr>
        <br>
        <div class="row">
            <div class="col-lg-12 pr-0 pl-0">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="filters">
                            <th scope="col"><input type="number" class="form-control" name="id" id="id" v-model="idComputed" placeholder="Id"></th>
                            <th scope="col"><input type="text" class="form-control" name="lastname" id="lastname" v-model="lastnameComputed" placeholder="Nom"></th>
                            <th scope="col"><input type="text" class="form-control" name="firstname" id="firstname" v-model="firstnameComputed" placeholder="Prénom"></th>
                            <th scope="col"><input type="text" class="form-control" name="mail" id="mail" v-model="mailComputed" placeholder="Adresse mail"></th>
                            <th scope="col" colspan="2"><button class="btn btn-secondary" name="emptyFilters" id="emptyFilters" @click="emptyFilters">Vider les champs</button></th>
                        </tr>
                        <tr class="text-center bg-info text-light">
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Email</th>
                            <th scope="col" colspan="2" class="align-middle"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center" v-for="user in results" :key="user.id" v-bind:id="user.id">
                            <td>{{ user.id }}</td>
                            <td>{{ user.nom }}</td>
                            <td>{{ user.prenom }}</td>
                            <td>{{ user.mail }}</td>
                            <td><button class="btn btn-sm btn-info" @click="selectUser"><i class="bi bi-pencil-square"></i>Modifier</button></td>
                            <td><button class="btn btn-sm btn-danger" @click="openDeleteModal(user.id)"><i class="bi bi-pencil-square"></i>Supprimer</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Fenêtre d'ajout d'un utilisateur-->
    <div class="overlay" v-if="showAddModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un nouvel utilisateur </h5>
                    <button type="button" class="close" @click="showAddModal=false">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form @submit.prevent>
                        <span id="error_msg2"></span>
                        <div class="form-group">
                            <input type="text" v-model="userData.nom" name="nom" class="form-control form-control" placeholder="Nom" required>
                        </div> 
                        <div class="form-group">
                            <input type="text" v-model="userData.prenom" name="prenom" class="form-control form-control" placeholder="Prénom" required> 
                        </div>
                        <div class="form-group">
                            <input type="email" v-model="userData.mail" name="email" class="form-control form-control" placeholder="Email" required>
                        </div> 
                        <div class="form-group">
                            <input type="password" v-model="userData.mdp" name="mdp" class="form-control form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-block" @click="addUser()" :disabled="!canAddUser()">Ajouter l'utilisateur </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fenêtre de modification d'un utilisateur-->
    <div class="overlay" v-if="showEditModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier l'utilisateur </h5>
                    <button type="button" class="close" @click="showEditModal=false">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div>
                        <div class="form-group">
                            <input type="text" v-model="userData.nom" name="nom" class="form-control form-control-lg" placeholder="Nom">
                        </div> 
                        <div class="form-group">
                            <input type="text" v-model="userData.prenom" name="prenom" class="form-control form-control-lg" placeholder="Prénom">
                        </div>
                        <div class="form-group">
                            <input type="email" v-model="userData.mail" name="mail" class="form-control form-control-lg" placeholder="Email">
                            <span id="error_msg"></span>
                        </div> 
                        <div class="form-group">
                            <input type="password" v-model="userData.mdp" name="password" class="form-control form-control-lg" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info btn-block btn-lg" @click="updateUser()">Modifier l'utilisateur </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Suppression d'un utilisateur -->
    <div class="overlay" v-if="showDeleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supprimer un utilisateur </h5>
                    <button type="button" class="close" @click="showDeleteModal=false">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <p class="modal_msg"> Êtes-vous sûr de vouloir supprimer '{{ selectedUser.prenom }} {{ selectedUser.nom }}' ?</p>                      
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn" @click="deleteUser">Oui</button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-secondary btn" @click="showDeleteModal=false">Non</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';
var bcrypt = require('bcryptjs');

export default {
name: 'app',
  data(){
    return {
        //résultat du filtre
        results: [],

        // Filtres utilisés par l'administrateur pour trouver un user
        filters: {
            id: "", 
            lastname: "", 
            firstname: "", 
            mail: ""
        },

        // Tous les users
        users: [],

        // Condition d'affichage des pop-ups
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,

        // L'utilisateur sélectionner
        selectedUser: [],

        // Les données de l'utilisateur
        userData: []
    }
  },
    mounted() {
        this.refreshUsers();
    },
    methods:{ 
        canAddUser(){
            if (this.userData.nom != null && this.userData.prenom != null && this.userData.mail != null && this.userData.mdp != null 
            && this.userData.nom != "" && this.userData.prenom != "" && this.userData.mail != "" && this.userData.mdp != ""){
                return true;
            }
            else {
                return false;
            }
        },

        addUser(){
            if (this.canAddUser()) {
                var hashedPassword = bcrypt.hashSync(this.userData.mdp, 10);     

                let formData = new FormData();
                formData.append('nom', this.userData.nom);
                formData.append('prenom', this.userData.prenom);
                formData.append('mail', this.userData.mail);
                formData.append('profil', 'enseignant');
                formData.append('mdp', hashedPassword);
                
                axios.post("http://localhost:8888/reservations_salles/src/api/controllers/UsersResource.php", formData) 
                .then((response) => {
                    var msg = "";
                    if (response.data === "inserted"){
                        this.refreshUsers(); 
                        this.userData = [];
                        this.showAddModal=false;
                    }
                    else if (response.data === "exists_user_same_mail"){
                        msg = "Ce mail est déjà utilisé par un autre utilisateur";
                        document.getElementById("error_msg2").textContent = msg;
                    }
                    else {
                        msg = "Les données saisies ne peuvent pas être insérées";
                        document.getElementById("error_msg2").textContent = msg;
                        console.log(response.data);
                    }
                })
            }  
            else {
                document.getElementById("error_msg2").textContent = "Veuillez remplir correctement tous les champs";
            }                        
        }, 

        selectUser: function(event){
            this.showEditModal = true;
            var currUserId = event.target.parentElement.parentElement.id;
            this.selectedUser = this.users.filter(user => user.id == currUserId)[0];  
            //Copy datas of selectUser in userData
            for (var key in this.selectedUser){
                this.userData[key] = this.selectedUser[key];
            }
        },

        updateUser(){
            axios.put("http://localhost:8888/reservations_salles/src/api/controllers/UsersResource.php", 
                JSON.stringify({
                    id: this.userData.id,
                    nom: this.userData.nom,
                    prenom: this.userData.prenom,
                    mail: this.userData.mail,
                    mdp: this.userData.mdp
                }))
                .then((response) => {
                    if (response.data === "updated"){
                        this.showEditModal = false;
                        this.refreshUsers();
                    }
                    else if (response.data === "exists_user_same_mail") {
                        var msg = "Ce mail est déjà utilisé par un autre utilisateur";
                        document.getElementById("error_msg").textContent = msg;
                    }
                    else {
                        console.log("Problème dans le serveur");
                    }
                })
        },

        openDeleteModal($id_user){
            this.showDeleteModal = true;
            this.selectedUser = this.users.filter(user => user.id === $id_user)[0];
        },

        deleteUser(){
            //On supprime toutes les réservations de l'user
            axios.delete("http://localhost:8888/reservations_salles/src/api/controllers/ReservationsResource.php?id_user="+this.selectedUser.id)
            .then((response) => {
                if (response.data === "ok"){
                    //On supprime l'user
                    axios.delete("http://localhost:8888/reservations_salles/src/api/controllers/UsersResource.php?id="+this.selectedUser.id)
                    .then((response) => {
                        //Réponse de requête réussie
                        if (response.data === "ok"){
                            this.showDeleteModal = false;
                            this.refreshUsers();
                        }
                        else {
                            //Afficher message d'erreur php
                            console.log(response.data);
                        }
                     })
                }
                else {
                    //Afficher message d'erreur php
                    console.log(response.data);
                }
            });

        },

        //rechargement / rafraîchissement automatique des données
        refreshUsers(){
            this.users = axios.get("http://localhost:8888/reservations_salles/src/api/controllers/UsersResource.php")
            .then((response) => {
                this.users = response.data;
                this.results = [];
                for (var key in this.users){
                    this.results[key] = this.users[key];
                }
            });
        },

        changeResults(){
            this.results = [];
            for (var key in this.users){
                this.results[key] = this.users[key];
            }
            this.results = this.filters.firstname != "" ? this.results.filter(user => user.prenom.toLowerCase().includes(this.filters.firstname.toLowerCase())) : this.results;
            this.results = this.filters.lastname != "" ? this.users.filter(user => user.nom.toLowerCase().includes(this.filters.lastname.toLowerCase())) : this.results;
            this.results = this.filters.mail != "" ? this.results.filter(user => user.mail.toLowerCase().includes(this.filters.mail.toLowerCase())) : this.results;
            this.results = this.filters.id != "" ? this.results.filter(user => parseInt(user.id, 10) == parseInt(this.filters.id, 10)) : this.results;
        },
        emptyFilters(){
            this.idComputed = "";
            this.lastnameComputed = "";
            this.firstnameComputed = "";
            this.mailComputed = "";
        }
    },
    computed: {
        idComputed: {
            get: function() {
                return this.filters.id;
            },
            set: function(input) {
                this.filters.id = input;
                this.changeResults();
            }
        },
        lastnameComputed: {
            get: function() {
                return this.filters.lastname;
            },
            set: function(input) {
                this.filters.lastname = input;
                this.changeResults();
            }
        },
        firstnameComputed: {
            get: function() {
                return this.filters.firstname;
            },
            set: function(input) {
                this.filters.firstname = input;
                this.changeResults();
            }
        },
        mailComputed: {
            get: function() {
                return this.filters.mail;
            },
            set: function(input) {
                this.filters.mail = input;
                this.changeResults();
            }
        }
    }
}
</script>

<style scoped>
.container-fluid {
        margin:0 auto; 
}
.hellobar {
    font-size:25px;
}
.titlebar{
    font-size:18px;
    padding: 3px;
}
.bar {
    margin-top: 5%;
    margin-bottom: 5%;
    margin-top: 5%;
}

.overlay{
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
}
.modal-dialog{
    top:15%
}
.modal_msg{
    font-size: 18px;
}
#error_msg, #error_msg2 {
    color: red
}
.container-top{
    display: initial;
}
</style>
