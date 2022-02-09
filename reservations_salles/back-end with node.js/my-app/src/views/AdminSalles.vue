<template>
    <div>
        <div class="container-fluid">
            <div class="row bar">
                <div class="col-lg-12 bg-dark">
                    <h1 class="hellobar text-center text-light display-4 pt-2">Bonjour {{ $store.state.firstName }}</h1>
                </div>
                <div class="col-lg-12 bg-secondary">
                    <h2 class="titlebar text-center text-light display-4 pt-2">Gestion des salles</h2>
                </div>
            </div> 
            <div class="row">
                <div class="col-lg-12 pr-0 pl-0">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="filters">
                                <th>
                                    <select class="form-control" id="nomsSalles" v-model="nomComputed">
                                    <option value="">Toutes les salles</option>
                                    <option v-for="(salle, index) in salles" v-bind:key="index"> {{ salle.nom }} </option>
                                </select>
                                </th>
                                <th><input class="form-control" type="number" name="nombrePlaces" id="nombrePlaces" v-model="placesComputed"></th>
                                <th><input class="form-control" type="number" name="nombreOrdinateurs" id="nombreOrdinateurs" v-model="ordiEtudComputed"></th>
                                <th>
                                    <select class="form-control" name="ordinateurEnseignant" id="ordinateurEnseignant" v-model="ordiProfComputed">
                                        <option value="">Tout</option>
                                        <option value=true> Oui </option>
                                        <option value=false> Non </option>
                                    </select>
                                </th>
                                <th>
                                    <select class="form-control" name="climatisation" id="climatisation" v-model="climatisationComputed">
                                        <option value="">Tout</option>
                                        <option value=true> Oui </option>
                                        <option value=false> Non </option>
                                    </select>
                                </th>
                            </tr>
                            <tr class="text-center bg-info text-light">
                                 <th scope="col"> Nom </th>
                                <th scope="col"> Nombre de places </th>
                                <th scope="col"> Nombre d'ordinateurs étudiant </th>
                                <th scope="col"> Ordinateur enseignant </th>
                                <th scope="col"> Climatisation </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center" v-for="(salle,item) in results" v-bind:key="item">
                                <td> {{ salle.nom }} </td>
                                <td> {{ salle.places }} </td>
                                <td> {{ salle.postes_etud }} </td>
                                <td> {{ salle.poste_prof }} </td>
                                <td> {{ salle.climatisation }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            salles: [],
            filters: {
                nom: "", 
                places: 0, 
                postes_etud: 0, 
                poste_prof: false, 
                climatisation: false,
            },
            results: [],
            selectedSalle: []
        }
    },
    mounted() {
        this.salles = axios.get("http://localhost:8888/reservations_salles/src/api/controllers/SallesResource.php")
            .then((response) => {
            this.salles = response.data;
            for (var key in this.salles){
                this.results[key] = this.salles[key];
            }
        });
    },
    methods: {
        changeResults(){
            this.results = [];
            for (var key in this.salles){
                this.results[key] = this.salles[key];
            }
            this.results = this.filters.poste_prof === "true" ? this.results.filter(salle => salle.poste_prof === "1") : this.filters.poste_prof === "false" ? this.results.filter(salle => salle.poste_prof === "0"): this.results;
            this.results = this.filters.climatisation === "true" ? this.results.filter(salle => salle.climatisation === "1"): this.filters.climatisation === "false" ? this.results.filter(salle => salle.climatisation === "0") : this.results;
            this.results = this.filters.nom != "" ? this.results.filter(salle => salle.nom === this.filters.nom) : this.results;
            this.results = this.results.filter(salle => parseInt(salle.places,10) >= parseInt(this.filters.places,10));
            this.results = this.results.filter(salle => parseInt(salle.postes_etud, 10) >= parseInt(this.filters.postes_etud, 10));
        }
    },
    computed: {
        nomComputed: {
            get: function() {
                return this.filters.nom;
            },
            set: function(input) {
                this.filters.nom = input;
                this.changeResults();
            }
        },
        placesComputed: {
            get: function() {
                return this.filters.places;
            },
            set: function(input) {
                this.filters.places = input;
                this.changeResults();
            }
        },
        ordiEtudComputed: {
            get: function() {
                return this.filters.postes_etud;
            },
            set: function(input) {
                this.filters.postes_etud = input;
                this.changeResults();
            }
        },
        ordiProfComputed: {
            get: function() {
                return this.filters.poste_prof;
            },
            set: function(input) {
                this.filters.poste_prof = input;
                this.changeResults();
            }
        },
        climatisationComputed: {
            get: function() {
                return this.filters.climatisation;
            },
            set: function(input) {
                this.filters.climatisation = input;
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
body{
    padding-top: 5%;
    background: rgb(245,245,245);
}
.row{
    background: white;
}
legend {
    width: 220px;
    background:#fff;
}
#error_msg{
    color: red
}
</style>