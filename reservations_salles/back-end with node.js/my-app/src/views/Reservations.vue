<template>
  <div class="container-fluid">
    <div class="row">
      <!-- Tableau des réservations de l'utilisateur -->
      <div class="table-responsive col-lg-6">
        <table class="table table-bordered table-hover">
            <thead>
              <tr class="text-center bg-info text-light ">
                <th scope="col" class="align-middle"> Nom </th>
                <th scope="col" class="align-middle"> Date/heure </th>
                <th scope="col" class="align-middle"> Modifier </th>
                <th scope="col" class="align-middle"> Annuler</th>
                <th scope="col" class="align-middle"> Visualiser </th>
              </tr>
            </thead>
            <tbody>
                <tr  v-for="reservation in reservations_infos" v-bind:key="reservation.details_reservation.id" v-bind:id="reservation.details_reservation.id">
                    <td class="room_name"> {{ reservation.details_salle.nom }} </td>
                    <td>{{ formatDate(new Date(reservation.details_reservation.date)) }}&nbsp; &nbsp;{{ reservation.details_reservation.heure === "matin" ? "Matin" : "Après-midi" }} </td>
                    <td class="text-center"><button class="btn btn-sm btn-info " @click="edit"> Modifier </button></td>
                    <td class="text-center"><button class="btn btn-sm btn-danger" type="button" @click="deleteReserv(reservation.details_reservation.id)" :disabled="timeExpired(reservation.details_reservation.id)"> <span v-if="!timeExpired(reservation.details_reservation.id)">Supprimer</span><span v-else>Délai passé</span> </button></td>
                    <td><button class="btn btn-sm btn-secondary" type="button" @click="takeId"> Voir </button></td>
                </tr>
            </tbody>
        </table>
      </div>
      <!-- Plan des salles -->
      <div class="col-lg-6">
        <Map :idSalle="idSalle" :details="details" :detailsSalle="detailsSalle" :affiche="affiche"></Map>
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
                      <button type="button" class="btn btn-info" @click="saveEdit" :disabled="selectedReserv.details_reservation.date == dateString && selectedReserv.details_reservation.heure == heure">Confirmer</button>
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
  </div>
</template>

<script>
import axios from 'axios';
import Datepicker from 'vue3-datepicker';

import Map from '../components/Map.vue';
export default {
  components: {
    Datepicker,
    Map
  },
  data(){
    return {
      tabBtn:'',
      suppMsg:'',
      affiche : true,
      idSalle : '',
      details : '',
      detailsSalle : '',
      reservations_infos: [],
      showModifModal: false,
      showModifModal2: false,
      showReponseModal: false,
      selectedReserv: [],
      date: new Date(),
      dateString: null,
      heure: null
    }
  },
  
  mounted() {
    this.updateUserReservationsdetails();
  },
 
  methods: {
    
    //Modifier une réservation suite au clic sur un bloc la représentant
    edit: function(event){
      this.showModifModal = true;
      var reserv_id = event.target.parentElement.parentElement.id;
      this.selectedReserv = this.reservations_infos.filter(reserv => reserv.details_reservation.id == reserv_id)[0];
      this.date = new Date(this.selectedReserv.details_reservation.date);
      this.dateString = this.selectedReserv.details_reservation.date;
      this.dateString = this.formatDate(new Date(this.selectedReserv.details_reservation.date));
      this.heure = this.selectedReserv.details_reservation.heure;
    },

    //Récupérer les infos d'une salle pour les faire circuler dans le composant Map
    takeId(event){
      var reserv_id = event.target.parentElement.parentElement.id;
      this.selectedReserv = this.reservations_infos.filter(reserv => reserv.details_reservation.id == reserv_id)[0];
      var nameCompare = this.selectedReserv.details_salle.nom;
      var varDetails = this.selectedReserv.details_reservation;
      var varDetailsSalle = this.selectedReserv.details_salle;
      this.details = varDetails;
      this.idSalle = nameCompare;
      this.detailsSalle = varDetailsSalle;
    },

    //Supprimer une réservation suite au clic sur un bloc la représentant 
    deleteReserv(reserv_id){
      this.showReponseModal = true;
      if (!this.timeExpired(reserv_id)) {
        axios.delete("http://localhost:3000/reservations/"+reserv_id)
        .then ((response) => {
          if (response.data === "ok"){
            document.getElementById("reponseReserv").textContent = "Votre réservation à été annulée avec succès";
          }
          else {
            document.getElementById("reponseReserv").textContent = "Votre réservation n'a pas pu être annulée";
          }
        });
      }  
    },

    //Sauvegarder la modification de la réservation selectionnée
    saveEdit(){
      this.showModifModal = false;
      this.showReponseModal = true;
      axios.put("http://localhost:3000/reservations", 
      {
        "id_reserv": this.selectedReserv.details_reservation.id,
        "id_salle": this.selectedReserv.details_salle.id,
        "date": this.dateString,
        "heure": this.heure
      })
      .then((response) => {
          if (response.data === "update"){
          document.getElementById("reponseReserv").textContent = "La modification de votre réservation a été validée avec succès"
        }
        else if (response.data === "exists_reservation"){
          document.getElementById("reponseReserv").textContent = "La modification de votre réservation n'est pas valide"
        }
      });
    },

    //Mettre à jour les données des réservations
    updateUserReservationsdetails(){
      this.reservations_infos = [];
      axios.get("http://localhost:3000/reservations/user/"+this.$store.state.id_user)
      .then((response) => {
        var reservations_user = response.data;
        axios.get("http://localhost:3000/salles")
        .then((response) => {
          var liste_salles = response.data;
          for (let i = 0; i < reservations_user.length; i++) {
            var salle_id = reservations_user[i].id_salle;  
            var salle = liste_salles.filter(salle => salle.id == salle_id)[0];

            var currDate = new Date(reservations_user[i].date);
            currDate.setHours = reservations_user[i].heure === "matin" ? 0 : 12;

            //Sélectionner les futures réservations seulement (à compter de la date et heure actuelle)
            if (currDate - new Date() >= -86400000){            
              this.reservations_infos.push({details_reservation: reservations_user[i], details_salle: salle});
            }
          }
          //Trier les réservations des plus récentes au plus éloignées
          this.reservations_infos.sort(function(a, b) {
            return new Date(b.details_reservation.date) - new Date(a.details_reservation.date); 
          });
        });
        
         
      });
    },
    
    //Rafraichir les réservations suite au clic et fermer la fenêtre
    refreshReservationsDetails() {
      this.showReponseModal = false;
      this.updateUserReservationsdetails();
      
    },

    //Convertir une date en format YYYY-MM-JJ
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

    //Vérifier si une réservation peut être supprimée (doit être dans + de 24h)
    timeExpired(reserv_id){
      var selectedReserv = this.reservations_infos.filter(reserv => reserv.details_reservation.id == reserv_id)[0];
      var date = new Date(selectedReserv.details_reservation.date);
      var heure = selectedReserv.details_reservation.heure;
      var currDate = new Date();
      date.setHours(heure === "matin" ? 0 : 12);
      var dateDiff = date - currDate;
      return dateDiff >= 86400000 ? false : true;
    }

  },

  computed: {
    dateComputed: {
        get: function() {
            return this.date;
        },
        set: function(saisie) {
            this.date = saisie;
            this.dateString = this.formatDate(this.date);
        }
    },
    heureComputed: {
        get: function() {
            return this.heure;
        },
        set: function(saisie) {
            this.heure = saisie;
       
        }
    }
  }
}
</script>

<style scoped>
.overlay{
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.6);
}
td{
  text-align: center;
}
.modal-dialog{
  top:15%
}
.row{
  margin-top: 10%;
  margin-left: 5%;
  display: flex;
  align-items: center;
}
table th{
  color: black;
  background-color: #d7d2d2;
}
</style>