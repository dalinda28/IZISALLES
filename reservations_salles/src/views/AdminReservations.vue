<template>
    <div>
        <div class="container-fluid">
            <div class="row bar">
                <div class="col-lg-12 bg-dark">
                    <h1 class="hellobar text-center text-light display-4 pt-2">Bonjour {{ $store.state.firstName }}</h1>
                </div>
                <div class="col-lg-12 bg-secondary">
                    <h2 class="titlebar text-center text-light display-4 pt-2">Gestion des réservations</h2>
                </div>
            </div>        
            <div class="row">
                <div class="col-lg-12 pr-0 pl-0">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="filters">
                                <th><input type="number" class="form-control" name="id" id="id" v-model="idFilterComputed" placeholder="Id"></th>
                                <th>
                                    <select class="form-control" id="nomsSalles" v-model="salleFilterComputed">
                                        <option value="">Toutes les salles</option>
                                        <option v-for="(salle, index) in salles" v-bind:key="index"> {{ salle.nom }} </option>
                                    </select>
                                </th>
                                <th><input type="text" class="form-control" name="lastname" id="lastname" v-model="nameFilterComputed" placeholder="Nom"></th>
                                <th><datepicker class="form-control" id="datePicker" format="DD/MM/yyyy" v-model="dateFilterComputed"/></th>
                                <th>
                                    <select class="form-control" id="timeSelect" v-model="timeFilterComputed">
                                        <option value="">Tout</option>
                                        <option value="matin"> Matin </option>
                                        <option value="aprem"> Après-midi </option>
                                    </select>
                                </th>
                                <th colspan="2"><button  class="btn btn-secondary" name="emptyFilters" id="emptyFilters" @click="emptyFilters">Vider les champs</button></th>
                            </tr>
                            <tr class="text-center bg-info text-light">
                                <th scope="col" class="align-middle">ID de la réservation</th>
                                <th scope="col" class="align-middle">Nom de la salle </th>
                                <th scope="col" class="align-middle">Nom de l'utilisateur</th>
                                <th scope="col" class="align-middle">Date</th>
                                <th scope="col" class="align-middle">Heure</th>
                                <th scope="col" colspan="2" class="align-middle"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="reservation in filterResults" v-bind:key="reservation.details_reservation.id" v-bind:id="reservation.details_reservation.id">
                                <td>{{ reservation.details_reservation.id }}</td>
                                <td>{{ reservation.details_salle.nom}} </td>
                                <td>{{ reservation.details_user.nom }} &nbsp;{{ reservation.details_user.prenom }} </td>
                                <td>{{ reservation.details_reservation.date }}</td>
                                <td>
                                    <span v-if="reservation.details_reservation.heure === 'matin'"> Matin</span> 
                                    <span v-else> Après-midi</span> 
                                </td>
                                <td><button class="btn btn-sm btn-info" @click="modifier" > Modifier </button></td>
                                <td><button class="btn btn-sm btn-danger" type="button" @click="openDeleteDialog(reservation.details_reservation.id)"> Supprimer </button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Popup modification date réservation -->
            <div class="overlay" v-if="showModifModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Modification de la date de réservation </h5>
                            <button type="button" class="close" @click="showModifModal=false">
                                <span aria-hidden="true">&times; </span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <div>
                                <span> Date: <datepicker id="datePicker" v-model="dateComputed"/> </span> <br>   
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="periode" id="periode1" value="matin" v-model="heureComputed" :checked="selectedReserv.details_reservation.heure==='matin'">
                                    <label class="form-check-label" for="periode1">
                                        Matin
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="periode" id="periode2" value="aprem" v-model="heureComputed" :checked="selectedReserv.details_reservation.heure==='aprem'">
                                    <label class="form-check-label" for="periode2">
                                        Après-midi
                                    </label>
                                </div> <hr>
                                <span>Nom de salle: {{ selectedReserv.details_salle.nom }}</span> <br>
                                <span>Nombre de places: {{ selectedReserv.details_salle.places }}</span> <br>
                                <span>Nombre postes étudiant: {{ selectedReserv.details_salle.postes_etud }}</span> <br>
                                <span>Poste enseignant:
                                    <span v-if="selectedReserv.details_salle.poste_prof === '1'"> Oui </span>
                                    <span v-else> Non </span>
                                </span> <br>
                                <span>Climatisation: 
                                    <span v-if="selectedReserv.details_salle.climatisation === '1'"> Oui </span>
                                    <span v-else> Non </span>
                                </span> <br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="save" :disabled="selectedReserv.details_reservation.date == dateString && selectedReserv.details_reservation.heure == heure">Confirmer</button>
                            <button type="button" class="btn btn-secondary" @click="showModifModal=false" data-dismiss="modal">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Popup réponse de la tentative de modification ou de suppression (réussie ou échouée) -->
            <div class="overlay" v-if="showReponseModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body p-4">
                            <div>
                                <p id="reponseReserv"></p>             
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="refreshReservationsDetails" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Supprimer un utilisateur-->
            <div class="overlay" v-if="showDeleteModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Supprimer une réservation </h5>
                            <button type="button" class="close" @click="showDeleteModal=false">
                                <span aria-hidden="true">&times; </span>
                            </button>
                        </div>
                        <div class="modal-body p-4">
                            <p class="modal_msg"> Êtes vous sûr de supprimer la réservation '{{ selectedReserv.details_reservation.id }}' ?</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn" @click="deleteReserv(selectedReserv.details_reservation.id)">Oui</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-secondary btn" @click="showDeleteModal=false">Non</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Datepicker from 'vue3-datepicker';

export default {
    name: 'Reservation',
    components: {
        Datepicker
    },
    data() {
        return {
            // Filtres utilisés par l'utilisateur pour trouver une réservation
            filters: {
                id: "", 
                userName: "", 
                salleName: "", 
                date: "",
                time: ""
            },

            filterResults: [],

            // Reservation sélectionnée à travers les boutons "modifier" et "supprimer"
            selectedReserv: [],

            // Toutes les réservations, toutes les salles, tous les users
            reservations: [],
            salles: [],
            users: [],

            //Chaque réservation avec ses infos (date,heure,etc) et les infos de la salle réservée (nom et autres caractéristiques)
            reservations_infos: [],
            
            date: new Date(),
            dateString: null,
            heure: null,

            //Condition d'affichage des pop-ups
            showReponseModal: false,
            showModifModal: false,
            showDeleteModal: false
        }
    },
    mounted() {
        this.updateUserReservationsdetails();
    },
    methods: {
        modifier: function(event){
            this.showModifModal = true;

            var reserv_id = event.target.parentElement.parentElement.id;
            this.selectedReserv = this.reservations_infos.filter(reserv => reserv.details_reservation.id == reserv_id)[0];

            this.date = new Date(this.selectedReserv.details_reservation.date);
            this.dateString = this.selectedReserv.details_reservation.date;
            this.heure = this.selectedReserv.details_reservation.heure;
        },

        openDeleteDialog(id){
            this.showDeleteModal = true;
            this.selectedReserv = this.reservations_infos.filter(reserv => reserv.details_reservation.id == id)[0];
        },
        updateUserReservationsdetails(){
            this.reservations = [];
            this.salles = [];
            this.users = [];
            this.reservations_infos = [];
            axios.get("http://localhost:8888/reservations_salles/src/api/controllers/ReservationsResource.php") 
            .then((response) => {
                this.reservations = response.data;

                axios.get("http://localhost:8888/reservations_salles/src/api/controllers/SallesResource.php")
                .then((response) => {
                    this.salles = response.data;

                    axios.get("http://localhost:8888/reservations_salles/src/api/controllers/UsersResource.php")
                    .then((response) => {
                        this.users = response.data;
                        for (let i = 0; i < this.reservations.length; i++) {
                            var salle_id = this.reservations[i].id_salle;
                            var salle = this.salles.filter(salle => salle.id == salle_id)[0];
                            var user_id = this.reservations[i].id_user;
                            var user = this.users.filter(user => user.id == user_id)[0];
                            this.reservations_infos[i] = {details_reservation: this.reservations[i], details_salle: salle, details_user: user};
                        }
                        this.filterResults = [];
                        for (var i=0; i<this.reservations_infos.length; i++){
                            this.filterResults[i] = this.reservations_infos[i];
                        }
                    });
                });
            });
        },
         refreshReservationsDetails() {
            this.showReponseModal = false;
            this.updateUserReservationsdetails();
        },

        formatDate(d){
            var month = '' + (d.getMonth() + 1);
            var day = '' + d.getDate();
            var year = d.getFullYear();

            if (month.length < 2) {
                month = '0' + month;
            }             
            if (day.length < 2) {
                day = '0' + day;
            }             
            return [year, month, day].join('-');
        },
        save(){
            this.showModifModal = false;
            this.showReponseModal = true;
            let formData = new FormData();
            formData.append('date', this.dateString);
            formData.append('heure', this.heure);
            axios.put("http://localhost:8888/reservations_salles/src/api/controllers/ReservationsResource.php", 
            JSON.stringify({
                id_reserv: this.selectedReserv.details_reservation.id,
                id_salle: this.selectedReserv.details_salle.id,
                date: this.dateString,
                heure: this.heure
            }))
            .then((response) => { 
                console.log(response.data);
                if (response.data){
                    document.getElementById("reponseReserv").textContent = "La modification de votre réservation a été validée avec succès"
                }
                else {
                    document.getElementById("reponseReserv").textContent = "La modification de votre réservation n'est pas valide"
                }
            });
        },
        deleteReserv(reserv_id){
            this.showReponseModal = true;
            this.showDeleteModal = false;
            axios.delete("http://localhost:8888/reservations_salles/src/api/controllers/ReservationsResource.php?id="+reserv_id)
                .then ((response) => {
                    if (response.data){
                        document.getElementById("reponseReserv").textContent = "Votre réservation à été annulée avec succès"
                    }
                });
        },

        //Functions about filters

        changeFilterResults(){
            this.filterResults = [];
            for (var i=0; i<this.reservations_infos.length; i++){
                this.filterResults[i] = this.reservations_infos[i];
            }

            this.filterResults = this.filters.id != "" ? this.filterResults.filter(reserv => parseInt(reserv.details_reservation.id, 10) == parseInt(this.filters.id, 10)) : this.filterResults;
            this.filterResults = this.filters.userName != "" ? this.filterResults.filter(reserv => reserv.details_user.nom.toLowerCase().includes(this.filters.userName.toLowerCase()) || reserv.details_user.prenom.toLowerCase().includes(this.filters.userName.toLowerCase())) : this.filterResults;
            this.filterResults = this.filters.salleName != "" ? this.filterResults.filter(reserv => reserv.details_salle.nom === this.filters.salleName) : this.filterResults;
            this.filterResults = this.filters.date != "" ? this.filterResults.filter(reserv => reserv.details_reservation.date === this.formatDate(this.filters.date)) : this.filterResults;
            this.filterResults = this.filters.time != "" ? this.filterResults.filter(reserv => reserv.details_reservation.heure === this.filters.time) : this.filterResults;
        },

        emptyFilters(){
            this.idFilterComputed = "";
            this.nameFilterComputed = "";
            this.salleFilterComputed = "";
            this.dateFilterComputed = "";
            this.timeFilterComputed = "";
        }
    },
    computed: {
    dateComputed: {
        get: function() {
            return this.date;
        },
        set: function(input) {
            this.date = input;
            this.dateString = this.formatDate(this.date);
        }
    },
    heureComputed: {
        get: function() {
            return this.heure;
        },
        set: function(input) {
            this.heure = input;    
        }
    },
    idFilterComputed: {
        get: function() {
            return this.filters.id;
        },
        set: function(input) {
            this.filters.id = input;
            this.changeFilterResults()
        }
    },
    salleFilterComputed: {
        get: function() {
            return this.filters.salleName;
        },
        set: function(input) {
            this.filters.salleName = input;  
            this.changeFilterResults()   
        }
    },
    nameFilterComputed: {
        get: function() {
            return this.filters.userName;
        },
        set: function(input) {
            this.filters.userName = input; 
            this.changeFilterResults()      
        }
    },
    dateFilterComputed: {
        get: function() {
            return this.filters.date;
        },
        set: function(input) {
            this.filters.date = input; 
            this.changeFilterResults()    
        }
    },
    timeFilterComputed: {
        get: function() {
            return this.filters.time;
        },
        set: function(input) {
            this.filters.time = input;   
            this.changeFilterResults()   
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
.row{
    background: white;
}

</style>