<template>
<nav class="navbar fixed-top transparent navbar-expand-lg navbar-light">
      <div class="container-fluid h5">
        <a class="navbar-brand" href="#">LOGO</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <router-link :to="{name:'accueil'}" class="nav-link mr-5" aria-current="page" href="/">Accueil</router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{name:'reservation'}" class="nav-link mr-5" href="/reservation">Réservation</router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{name:'salles'}" class="nav-link mr-5" href="/salles">Mes salles</router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{name:'contact'}" class="nav-link" href="/contact">Contact</router-link>
            </li>
          </ul>
        </div>
        <div class="ml-auto"> 
            <router-link :to="{name:'connexion'}" class="nav-link btn" href="/connexion">Se connecter</router-link>
        </div>
      </div>
    </nav>
</template>

<script>
export default {};
</script>

<style>

</style>