<template>
<div>
  <div class="app-header">
    <Navbar></Navbar>
  </div>
    <div class="">
      <router-view></router-view>
    </div>
</div>
</template>

<script>
import Navbar from './components/Navbar'
export default {
  components: {
    Navbar
  } 
}
</script>

<style>

</style>
