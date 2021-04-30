<template>
    <div class="container-fluid">
        <div class="row formFiltre">
          <form class="col-lg-10 offset-lg-1">
            <fieldset class="p-3">
              <legend> Réservez une salle </legend>
              <div class= "row">
                  <div class="col-lg-5 offset-lg-1 pl-5">
                      <div class="form-group">
                          <label for="nomsSalles">Nom de la salle</label>
                          <select class="form-control" style="width: 30%" id="nomsSalles" v-model="nomComputed">
                              <option></option>
                              <option v-for="(salle, index) in salles" v-bind:key="index"> {{ salle.nom }} </option>
                          </select>
                      </div>
                      <div class="form-row">
                          <label class="control-label" for="date">Date</label>
                          <datepicker class="form-control" id="datePicker" format="DD/MM/yyyy" v-model="dateComputed"/>
                      </div>
                      <div class="form-check">
                          <label class="form-check-label" for="periode1">
                              Matin
                          </label>
                          <input class="form-check-input" type="radio" name="periode" id="periode1" value="matin" v-model="heureComputed">

                      </div>
                      <div class="form-check">
                          <label class="form-check-label" for="periode2">
                              Après-midi
                          </label>
                          <input class="form-check-input" type="radio" name="periode" id="periode2" value="aprem" v-model="heureComputed" checked>
                      </div>                         
                  </div>
              
                  <div class="col-lg-5 pl-5" style="border-left: 1px solid #ccc;">
                      <div class="form-group">
                          <label for="nombrePlaces">Nombre de places</label>
                          <input type="number" name="nombrePlaces" id="nombrePlaces" v-model="placesComputed">
                      </div>
                      <div class="form-group">
                          <label for="nombreOrdinateurs">Nombre d'ordinateurs</label>
                          <input type="number" name="nombreOrdinateurs" id="nombreOrdinateurs" v-model="ordiEtudComputed">
                      </div>
                      <div class="form-check">
                          <label class="form-check-label" for="ordinateurEnseignant">
                              Ordinateur pour enseignant
                          </label>
                          <input class="form-check-input" type="checkbox" value="" id="ordinateurEnseignant" v-model="ordiProfComputed">

                      </div>
                      <div class="form-check">
                          <label class="form-check-label" for="climatisation">
                              Climatisation
                          </label>
                          <input class="form-check-input" type="checkbox" value="" id="climatisation" v-model="climatisationComputed">
                      </div>
                  </div>
              </div>
            </fieldset>
          </form>
          <div id="resultatRecherche">
            {{ resultats.length }} Salles correspondent à votre recherche !
          </div>
        </div>
        <div class="sectionTabMap row px-2 pt-2">
          <div class="table-responsive col-lg-7" id="down">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="text-center bg-info text-light ">
                  <th scope="col" class="align-middle"> Nom de la salle</th>
                  <th scope="col" class="align-middle"> Nombre de places </th>
                  <th scope="col" class="align-middle"> Nombre d'ordinateurs étudiant </th>
                  <th scope="col" class="align-middle"> Ordinateur enseignant </th>
                  <th scope="col" class="align-middle"> Climatisation </th>
                  <th scope="col" class="align-middle">Réserver</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(salle,item) in resultats" v-bind:key="item">
                  <td> {{ salle.nom }} </td>
                  <td> {{ salle.places }} </td>
                  <td> {{ salle.postes_etud }} </td>
                  <td> 
                        <span v-if="salle.poste_prof.data[0] === 1"> Oui </span> 
                        <span v-else> Non </span> 
                    </td>
                    <td> 
                        <span v-if="salle.climatisation.data[0] === 1"> Oui </span> 
                        <span v-else> Non </span> 
                    </td>
                  <td> <button class="btn btn-sm btn-outline-secondary" v-bind:id="salle.id" @click="confirmerReserv(salle.id)" :disabled="timeExpired()"> <span v-if="!timeExpired()">Réserver</span><span v-else>Délai passé</span> </button> </td>
                      
                  </tr>
              </tbody>
            </table>
          </div>
          <!--ajout du composant map -->
          <Map :resultats="resultats"></Map>
        </div>
        <!-- Popup confirmation de la réservation -->
        <div class="overlay" v-if="showSaveModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"> Confirmation de la réservation </h5>
                <button type="button" class="close" @click="showSaveModal=false">
                  <span aria-hidden="true">&times; </span>
                </button>
              </div>
              <div class="modal-body p-4">
                <div>
                  <span> Date: {{ dateString }} </span> <br>   
                  <span> Heure: 
                    <span v-if="heure === 'matin'"> Matin</span> 
                    <span v-else> Après-midi</span> 
                  </span> <hr>
                  <span>Nom de salle: {{ selectedSalle.nom }}</span> <br>
                  <span>Nombre de places: {{ selectedSalle.places }}</span> <br>
                  <span>Nombre postes étudiant: {{ selectedSalle.postes_etud }}</span> <br>
                  <span>Poste enseignant:
                    <span v-if="selectedSalle.poste_prof.data[0] === 1"> Oui </span> 
                    <span v-else> Non </span> 
                  </span> <br>
                  <span>Climatisation: 
                    <span v-if="selectedSalle.climatisation.data[0] === 1"> Oui </span> 
                    <span v-else> Non </span> 
                  </span> <br>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="saveReserv">Réserver</button>
                <button type="button" class="btn btn-secondary" @click="showSaveModal=false" data-dismiss="modal">Annuler</button>
              </div>
            </div>
          </div>
        </div>
         <!-- Popup réponse de la tentative de réservation (réussie ou échouée) -->
        <div class="overlay" v-if="showReponseModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body p-4">
                <div>
                  <p id="reponseReserv"></p>             
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="showReponseModal=false" data-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>
    </div>
    
</template>

<script>
import axios from 'axios';
import Datepicker from 'vue3-datepicker'
import Map from '../components/Map.vue'
export default {
    components: {
        Datepicker, Map
    },
     
    data() {
        return {
            title: '',
            salles: [],
            resultatSalles: [],
            criteres: {
                nom: "", 
                places: 0, 
                postes_etud: 0, 
                poste_prof: false, 
                climatisation: false,
            },

            date: new Date(),
            dateString: this.formatDate(new Date()),
            heure: "aprem",
            reservations: [],
            resultatReserv: [],

            resultats: [],

            showSaveModal: false,
            showReponseModal: false,

            selectedSalle: [],
            
        }
        
    },
    
    mounted() {
        this.refreshData();
    },
    methods: {    
        refreshData(){
            this.salles = axios.get("http://localhost:3000/salles")
            .then((response) => {
                this.salles = response.data;
                this.resultatSalles = this.salles;
                this.reservations = axios.get("http://localhost:3000/reservations")
                    .then((response) => {
                        this.reservations = response.data;
                        this.changeResults();
                });   
            });
        }, 
        confirmerReserv(id_salle){
            this.selectedSalle = this.salles.filter(salle => salle.id == id_salle)[0];
            this.showSaveModal = true;
        },
        saveReserv: function (){
            this.showSaveModal = false;
            this.showReponseModal = true;
            
            axios.post("http://localhost:3000/reservations", {
                'id_salle': this.selectedSalle.id,
                'id_user': this.$store.state.id_user,
                'date': this.dateString,
                'heure': this.heure
            })
            .then((response) => {
                if (response.data === "inserted"){
                    document.getElementById("reponseReserv").textContent = "Votre réservation a été validée avec succès";
                    this.refreshData();
                }
                else if (response.data == "exists_reservation"){
                    document.getElementById("reponseReserv").textContent = "Votre réservation n'est plus disponible"
                }
                else {
                    document.getElementById("reponseReserv").textContent = "Problème serveur"
                }
            })
        },
        init() {
            this.dateString = this.formatDate(this.date);
            this.changeResults();
        }, 
        
        changeResults(){
            this.resultats = [];
            this.changeSalles();
            this.changeReservations();
            var id_salles_occupes = this.resultatReserv.map(reservation => reservation.id_salle);
            this.resultatSalles.forEach(salle => {
                if (!id_salles_occupes.includes(salle.id)){
                    this.resultats.push(salle);
                }
            });
        },
        changeSalles(){
            this.resultatSalles = this.salles;
            this.resultatSalles = this.criteres.poste_prof === true ? this.resultatSalles.filter(salle => salle.poste_prof.data[0] === 1) : this.resultatSalles;
            this.resultatSalles = this.criteres.climatisation === true ? this.resultatSalles.filter(salle => salle.climatisation .data[0] === 1) : this.resultatSalles;
            this.resultatSalles = this.criteres.nom != "" ? this.resultatSalles.filter(salle => salle.nom === this.criteres.nom) : this.resultatSalles;
            this.resultatSalles = this.resultatSalles.filter(salle => parseInt(salle.places,10) >= parseInt(this.criteres.places,10));
            this.resultatSalles = this.resultatSalles.filter(salle => parseInt(salle.postes_etud, 10) >= parseInt(this.criteres.postes_etud, 10));
        },

        changeReservations(){
            this.resultatReserv = this.reservations;
            this.resultatReserv = this.reservations.filter(reservation => this.formatDate(new Date(reservation.date)) === this.dateString && reservation.heure === this.heure);
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

        scrollToElementDown(){
            const bt = document.getElementById('down');
            if (bt) {
                bt.scrollIntoView({behavior: 'smooth'});
          } 
        },
        timeExpired(){
            if (this.date - new Date() < 0){
                if (this.formatDate(this.date) == this.formatDate(new Date())){
                    if (this.heure === "matin"){
                        return true;
                    }
                    else {
                        if (new Date().getHours>=12) {
                            return true;
                        }
                    }
                }
                else {
                    return true;
                }
            }  
            return false;     
        }  
    },

    computed: {
        nomComputed: {
            get: function() {
                return this.criteres.nom;
            },
            set: function(saisie) {
                this.criteres.nom = saisie;
                this.changeResults();
            }
        },
        placesComputed: {
            get: function() {
                return this.criteres.places;
            },
            set: function(saisie) {
                this.criteres.places = saisie;
                this.changeResults();
            }
        },
        ordiEtudComputed: {
            get: function() {
                return this.criteres.postes_etud;
            },
            set: function(saisie) {
                this.criteres.postes_etud = saisie;
                this.changeResults();
            }
        },
        ordiProfComputed: {
            get: function() {
                return this.criteres.poste_prof;
            },
            set: function(saisie) {
                this.criteres.poste_prof = saisie;
                this.changeResults();
            }
        },
        climatisationComputed: {
            get: function() {
                return this.criteres.climatisation;
            },
            set: function(saisie) {
                this.criteres.climatisation = saisie;
                this.changeResults();
            }
        },
        dateComputed: {
            get: function() {
                return this.date;
            },
            set: function(saisie) {
                this.date = saisie;
                this.dateString = this.formatDate(this.date);
                this.changeResults();
            }
        },
        heureComputed: {
            get: function() {
                return this.heure;
            },
            set: function(saisie) {
                this.heure = saisie;
                this.changeResults();
            }
        }
    }
}
</script>

<style scoped>

.sectionTabMap{
  margin-top: 3%;
}
#resultatRecherche{
  background: grey;
  color: white;
  width: 30%;
  margin-left: auto;
  margin-right: auto;
  text-align: center;
  padding: 5px;
  border-radius: 9px;
  margin-top: -1%;
  z-index: 1;
}
.overlay{
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: 1;
}
.modal-dialog{
    top:15%;
}

body{
    padding-top: 5%;
    background: rgb(245,245,245);
}

fieldset {
    border:1px solid #999;
    border-radius:8px;
    box-shadow:0 0 5px #999;
}

legend {
    width: 200px;
    background:#fff;
}
.form-check,.form-group fieldset {
    margin: 6px 0;
    padding-left: 0;
}
.form-control{
    display: initial;
}

.form-check-input {
    margin-left: 0rem; 
}

.formFiltre{
      margin-top: 120px;
}
label {
  display: inline-block;
  width: 60%;
  vertical-align: top;
}
.table{
  width: 80%;
    margin-left: auto;
    margin-right: auto;
}
table th{
  color: black;
  background-color: #d7d2d2;
}
.map{
    margin-left: 15px;
}
svg{
    width: 100%;
    height: 100%;
        
}
rect{
fill:green;
opacity: 0.5;
}

</style>