<template>
  <div id="app">
    <Navbar></Navbar>
    <img src="./assets/room1.jpg" alt="room" style="object-fit: contain; width:100%; height:20%; opacity:0.75;"/>
    <div class="centered">
      <h2>
        Réservez des salles de réunion de travail et de conférence 
      </h2>
      <button type="button" class="btn btn-secondary btn-lg" style="margin-left:30%">Réservez !</button>
      <button type="button" class="btn btn-light btn-lg m-3">Contactez nous</button>
    </div>
  </div>
</template>

<script>
import Navbar from "./components/Navbar";

export default {
  name: "App",
  components: {
    Navbar,
  },
};
</script>

<style>
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
