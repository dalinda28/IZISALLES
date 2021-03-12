<template>
  <div class="app">
    <img src="../assets/room1.jpg" alt="room" style="object-fit: contain; width:100%; height:20%; opacity:0.75;"/>
    <div class="centered">
      <h2>
        Réservez des salles de réunion de travail et de conférence 
      </h2>
      <router-link :to="{name:'reservation'}"><button type="button" class="btn btn-secondary btn-lg" style="margin-left:30%">Réservez !</button></router-link>
      <router-link :to="{name:'contact'}"><button type="button" class="btn btn-light btn-lg m-3">Contactez nous</button></router-link>
   </div>
  </div>
</template>

<script>
export default {
  name: '',
  components: {
  }
}
</script>
<style scoped>
html {
  font-size: 1rem;
}
img{
}
.centered {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>