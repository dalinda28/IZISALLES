<template>
    <div class="container">
        <section class="form my-5 mx-5 mt-5">
            <div class="row no-gutters">
                <div class="col-lg-5">
                    <img src="../assets/room2.jpg" class="img-fluid" alt="salle de réunion">
                </div>
                <div class="col-lg-7 p-5">
                    <img src="../assets/logo.png" class="logo" alt="salle de réunion">
                    <div>
                        <div class="form-row">
                            <p class="alert alert-danger" v-if="error">{{ error }}</p>
                            <p class="alert alert-danger" v-if="alert">{{ alert }}</p>
                            <div class="col-lg-7">
                                <input type="mail" @keyup.enter="login()" placeholder="test@gmail.fr" v-model="mail" class="form-control my-3 p-4">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7">
                                <input type="password" @keyup.enter="login()" placeholder="*********" v-model="mdp" class="form-control my-3 p-4">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-7">
                                <button type="button" class="btn1 mt-3 mb-5" @click="login()">Se connecter</button>
                            </div>
                        </div>
                        <p>Vous n'avez pas encore de compte ?
                        <router-link :to="{name:'inscription'}" class="nav-link" href="/inscription">Créer un compte</router-link></p>
                        <main class="App__main">
                            <transition
                                name="fade"
                                mode="out-in">
                                <router-view/>
                            </transition>
                        </main>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
const bcrypt = require('bcryptjs');

export default {
    data(){
        return {
            // Les données saisie par l'utilisateur
            mail: '',
            mdp: '',

            // Popup 
            error: '',
            alert: ''
        }
    },
    methods:{
        login(){
            if (this.mail != '' && this.mdp != '') {
                this.axios.get("http://localhost:3000/users")
                    .then((response) => {
                        for (let i = 0; i < response.data.length; i++) {
                                // Vérification du mot de passe (décryptage) et adresse mail 
                            if (response.status == 200 && this.mail == response.data[i].mail && bcrypt.compareSync(this.mdp, response.data[i].mdp)){
                                // Enregistrement des données de session    
                                this.$store.commit("setId", response.data[i].id);
                                this.$store.commit("setFirstName", response.data[i].prenom);    
                                this.$store.commit("setLastName", response.data[i].nom);    
                                this.$store.commit("setProfile", response.data[i].profil);  
                                this.$store.commit("setMail", response.data[i].mail);
                                if (this.$store.state.profile === "enseignant") {
                                    this.$router.push('/');
                                }
                                else if (this.$store.state.profile === "administrateur") {
                                    this.$router.push('/admin-reservations');
                                }
                            }
                        }
                        this.alert = "L'adresse mail ou le mot de passe ne sont pas valides"

                    })
                    .catch((error) => { 
                        console.log(error);
                    });                        
            } else{
                this.error = 'Veuillez saisir votre mail et mot de passe.';
            }
        },       
    }
}
</script>

<style scoped>
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
    margin-top: 6%;
}

.row{
    background: white;
    border-radius: 30px;
    box-shadow: 12px 12px 22px grey;
}
.img-fluid{
    max-width: 100%;
    height: auto;
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
.logo{
    width: 150px;
}
</style>