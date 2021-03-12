<template>
    <div>
        <section class="form my-5 mx-5">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-lg-5">
                        <img src="../assets/room2.jpg" class="img-fluid" alt="room">
                    </div>

                    <div class="col-lg-7 px-5 pt-5">
                        <h1 class="font-weight-bold py-3">Logo</h1>
                        <h4></h4>
                        <form>
                            <div class="form-row">
                                <div class="col-lg-7">
                                    <input type="email" placeholder="test@gmail.fr" class="form-control my-3 p-4">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-7">
                                    <input type="password" placeholder="*********" class="form-control my-3 p-4">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-7">
                                    <button type="button" class="btn1 mt-3 mb-5">Se connecter</button>
                                </div>
                            </div>
                            <p>Pas de compte? 
                            <router-link :to="{name:'inscription'}" class="nav-link" href="/inscription">Enregistrer</router-link></p>
                            <main class="App__main">
                                <transition
                                    name="fade"
                                    mode="out-in"
                                >
                                    <router-view/>
                                </transition>
                            </main>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {

}
</script>

<style>
*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body{
    padding-top: 5%;
    background: rgb(216,216,216);
}
.container{
    width: 70%;
}
.row{
    background: white;
    border-radius: 30px;
    box-shadow: 12px 12px 22px grey;
}
img{
    border-top-left-radius: 30px;
    border-bottom-left-radius: 30px;
}
.btn1{
    border: none;
    outline:  none;
    height: 50px;
    width: 100%;
    background-color: black;
    color: white;
    border-radius: 4px;
    font-weight: bold;
}
.btn1:hover{
    background-color: white;
    border: 1px solid;
    color: black; 
}
.fade-enter-active,
.fade-leave-active {
  transition-duration: 0.3s;
  transition-property: opacity;
  transition-timing-function: ease;
}

.fade-enter,
.fade-leave-active {
  opacity: 0
}
</style>