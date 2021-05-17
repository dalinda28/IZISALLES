<template>
  <div>
    <div class="container1" id="top">
        <div class="container2">
          <h2 class="text-center">Réservez des salles de réunion de travail et de conférence </h2>
          <router-link v-if="$store.state.id_user != ''" :to="{name:'salles'}"><button type="button" class="btn btn-secondary btn-lg" style="margin-left:30%">Réservez !</button></router-link>
          <router-link v-else :to="{name:'connexion'}"><button type="button" class="btn btn-secondary btn-lg" style="margin-left:30%">Réservez !</button></router-link>
          <router-link v-if="$store.state.id_user != ''" :to="{name:'contact'}"><button style="background-color: #d7d2d2; " type="button" class="btn btn-light btn-lg m-3">Contactez nous</button></router-link>
          <router-link v-else :to="{name:'connexion'}"><button style="background-color: #d7d2d2; " type="button" class="btn btn-light btn-lg m-3">Contactez nous</button></router-link>
        </div>
        <div class="overlay"></div>
    </div>
    <section class="jumbotron text-center mb-0">
          <div class="container">
            <h1 class="jumbotron-heading"><img class="card-img-top" src="../assets/logo.png" style="width: 200px" data-holder-rendered="true"></h1>
            <p class="lead text-muted">Izisalles dispose de 8 salles de réunion pouvant accueillir des groupes jusqu'à 48 personnes. Toutes les chambres sont équipées de tableaux blancs, de tables et de chaises. Le wifi est disponible.
              Si vous souhaitez réserver une salle pour un groupe d'étude, veuillez réserver dans l'onglet "Réservez une salle".
              Les salles de réunion sont gratuites pour les étudiants et les départements de l'Université Sorbonne.
            </p>
            <p class="float-top">
              <a @click="scrollToElementDown"><img class="mt-3" src=https://cdn.jsdelivr.net/npm/bootstrap-icons/icons/arrow-bar-down.svg width="32" height="32" alt="fléche en bas"></a>
            </p> 
          </div>
    </section>

    <div class="album py-5 bg-light" id="down">
          <div class="container">
            <div class="row">
              <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                  <img class="card-img-top" src="../assets/room1.jpg" data-holder-rendered="true">
                  <div class="card-body">
                    <p class="card-text text-center">La salle <strong>Jobs</strong> peut accueillir jusqu'à 40 personnes. Elle est équipée de tableaux blancs, de 20 tables et 40 chaises, d'un climatiseur. Le wifi est disponible</p>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="btn-group" v-if="$store.state.profile == 'enseignant'">
                        <router-link :to="{name:'salles'}"><button type="button" class="btn btn-sm btn-outline-secondary">Réservez !</button></router-link>
                      </div>
                      <div class="btn-group" v-if="$store.state.profile == ''">
                        <router-link :to="{name:'connexion'}"><button type="button" class="btn btn-sm btn-outline-secondary">Réservez !</button></router-link>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                  <img class="card-img-top" src="../assets/room3.jpg" data-holder-rendered="true">
                  <div class="card-body">
                    <p class="card-text text-center">La salle <strong>Carry</strong> peut accueillir jusqu'à 25 personnes. Elle est équipée de tableaux blancs, de 15 tables et 25 chaises, d'un climatiseur et d'un poste enseignant.</p>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="btn-group" v-if="$store.state.profile == 'enseignant'">
                        <router-link :to="{name:'salles'}"><button type="button" class="btn btn-sm btn-outline-secondary">Réservez !</button></router-link>
                      </div>
                      <div class="btn-group" v-if="$store.state.profile == ''">
                        <router-link :to="{name:'connexion'}"><button type="button" class="btn btn-sm btn-outline-secondary">Réservez !</button></router-link>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                  <img class="card-img-top" src="../assets/room4.jpg" data-holder-rendered="true">
                  <div class="card-body">
                    <p class="card-text text-center">La salle <strong>Robbins</strong> peut accueillir jusqu'à 30 personnes. Elle est équipée de tableaux blancs, de 15 tables et 30 chaises et d'un poste enseignant.</p>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="btn-group" v-if="$store.state.profile == 'enseignant'">
                        <router-link :to="{name:'salles'}"><button type="button" class="btn btn-sm btn-outline-secondary">Réservez !</button></router-link>
                      </div>
                      <div class="btn-group" v-if="$store.state.profile == ''">
                        <router-link :to="{name:'connexion'}"><button type="button" class="btn btn-sm btn-outline-secondary">Réservez !</button></router-link>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <footer class="text-muted">
          <div class="container">
            <p class="float-right">
              <a @click="scrollToElementTop"><img src=https://cdn.jsdelivr.net/npm/bootstrap-icons/icons/arrow-bar-up.svg width="32" height="32" alt="fléche en haut"></a>
            </p>
            <p class="mt-4">© Copyright 2021 Tous droits réservés - Melinna ∣ Dalinda ∣ Issam - Sorbonne Université</p>
          </div>
      </footer>
  </div>
</template>

<script>
export default {
  name: '',
  data() {
        return {
        }
  },
  methods:{
    scrollToElementTop() {
      const tp = document.getElementById('top');
      if (tp) {
        tp.scrollIntoView({behavior: 'smooth'});
      }
    }, 
    scrollToElementDown(){
      const bt = document.getElementById('down');
      if (bt) {
        bt.scrollIntoView({behavior: 'smooth'});
      } 
    }    
  }
}
</script>
<style scoped>
  .container1{
    background-image: url("../assets/room.jpg");
    background-repeat: no-repeat;
    background-size: 100%;
    background-size: cover;
    position: relative;
    width:100%;
    height: 600px;
  }
  .container2{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
    color: #d7d2d2;
  }
  .overlay{
    background: #0000008a;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
  }
</style>