<template>
  <nav class="navbar fixed-top transparent navbar-expand-lg navbar-light">
          <a class="navbar-brand" href="#"><img class="logo_header" src="../assets/logo.png" data-holder-rendered="true"></a>
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>

          </button>
          <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item" v-if="$store.state.profile != 'administrateur'">
                <router-link :to="{name:'accueil'}" class="nav-link mr-5" aria-current="page" href="/">Accueil</router-link>
              </li>
               <li class="nav-item" v-if="$store.state.profile == 'enseignant'">
                <router-link :to="{name:'salles'}" class="nav-link mr-5" href="/salles">Réservez une salle</router-link>
              </li>
              <li class="nav-item" v-if="$store.state.profile == ''">
                <router-link :to="{name:'connexion'}" class="nav-link mr-5" href="/connexion"> Réservez une salle</router-link>
              </li>
              <li class="nav-item" v-if="$store.state.profile == 'enseignant'">
                <router-link :to="{name:'reservations'}" class="nav-link mr-5" href="/reservations">Mes réservations</router-link>
              </li>
              <li class="nav-item" v-if="$store.state.profile == 'enseignant'">
                <router-link :to="{name:'contact'}" class="nav-link mr-5" href="/contact">Contact</router-link>
              </li>
              <li class="nav-item" v-if="$store.state.profile == 'administrateur'">
                <router-link :to="{name:'adminUsers'}" class="nav-link mr-5" href="/admin-users">Utilisateurs</router-link>
              </li>
              <li class="nav-item" v-if="$store.state.profile == 'administrateur'">
                <router-link :to="{name:'adminSalles'}" class="nav-link mr-5" href="/admin-salles">Salles</router-link>
              </li>
              <li class="nav-item" v-if="$store.state.profile == 'administrateur'">
                <router-link :to="{name:'adminReservations'}" class="nav-link mr-5" href="/admin-reservations">Réservation</router-link>
              </li>
              
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item" v-if="$store.state.profile == ''">
                  <router-link :to="{name:'connexion'}" class="nav-link btn btn-dark text-white" href="/connexion">Se connecter</router-link>
                </li>
                <li class="nav-item" v-else>
                  <router-link :to="{name:'connexion'}" class="nav-link btn btn-dark text-white" href="/connexion" @click="disconnect">Se déconnecter</router-link> 
                </li>
            </ul>
          </div>
          
    </nav>
</template>

<script>
export default {
  methods: {
    disconnect: function(){
      this.$store.commit("setId", '');
      this.$store.commit("setFirstName", '');    
      this.$store.commit("setLastName", '');    
      this.$store.commit("setProfile", '');  
      this.$store.commit("setMail", '');
    }
  }
};
</script>

<style scoped>
.logo_header{
  width: 50px;
  height: 50px;
}
nav {
  box-shadow: 0px 5px 2px 0px #6c757d;
  background-color: white;
  opacity: 95%;
  height: 68px;
  font-size:20px;
}
.nav-item{
  text-align: center;
}
.nav-item>a{
  width: 100%;
}
@media (max-width: 960px) { 
  #navbarNavDropdown{
    background: #6c757d;
  }

  #navbarNavDropdown>ul>li>a{
    text-align: center;
    width: 100%;
    color: white;
  }
}


</style>
