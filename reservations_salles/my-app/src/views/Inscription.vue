<template>
    <div>
        <section class="container">
            <div class="form">
                <div class="row no-gutters">
                    <div class="col-lg-5">
                        <img src="../assets/room2.jpg" class="img-fluid" alt="salle de réunion">
                    </div>
                    <div class="col-lg-7 pl-5" >
                        <img src="../assets/logo.png" class="logo" alt="salle de réunion">
                        <div>
                            <span id="error_msg"></span>
                            <div class="form-row">
                                <div class="col-lg-7">
                                    <input type="Nom" @keyup.enter="addUser()" v-model="userData.nom" placeholder="Nom" class="form-control my-3 p-4" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-7">
                                    <input type="Prenom" @keyup.enter="addUser()" v-model="userData.prenom" placeholder="Prénom" class="form-control my-3 p-4" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-7">
                                    <input type="mail" @keyup.enter="addUser()" v-model="userData.mail" placeholder="test@gmail.com" class="form-control my-3 p-4" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-7">
                                    <input type="password" @keyup.enter="addUser()" v-model="userData.mdp" placeholder="*********" class="form-control my-3 p-4" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-7">
                                    <button type="submit" @click="addUser()" class="btn1 mt-3 mb-5" >S'inscrire</button>
                                </div>
                            </div>
                            
                            <p>Vous avez déjà un compte ?</p>
                            <router-link :to="{name:'connexion'}" class="nav-link" href="/connexion">Connexion</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';
var bcrypt = require('bcryptjs');

export default {
    name: 'app',
    data(){
        return {
            // Les données saisies par l'utilisateur
            userData:{
                nom: null,
                prenom: null,
                mail: null,
                mdp: null,
            }
        }
    },
    methods:{
        canAddUser(){
            if (this.userData.nom != null && this.userData.prenom != null && this.userData.mail != null && this.userData.mdp != null 
            && this.userData.nom != "" && this.userData.prenom != "" && this.userData.mail != "" && this.userData.mdp != ""){
                return true;
            }
            else {
                return false;
            }
        },

        //Ajouter un utilisateur dans la bdd
        addUser(){
            if (this.canAddUser()) {
                var hashedPassword = bcrypt.hashSync(this.userData.mdp, 10);     

                let formData = new FormData();
                formData.append('nom', this.userData.nom);
                formData.append('prenom', this.userData.prenom);
                formData.append('mail', this.userData.mail);
                formData.append('profil', 'enseignant');
                formData.append('mdp', hashedPassword);
                
                axios.post("http://localhost:3000/users", {
                    nom: this.userData.nom,
                    prenom: this.userData.prenom,
                    profil: 'enseignant',
                    mail: this.userData.mail,
                    mdp: hashedPassword
                    }) 
                .then((response) => {
                    var msg = "";
                    if (response.data === "inserted"){
                        document.getElementById("error_msg").textContent = "Votre compte a été créé";
                        document.getElementById("error_msg").style.color = "green";
                        this.userData = [];
                    }
                    else if (response.data === "exists_user_same_mail"){
                        msg = "Ce mail est déjà utilisé par un autre utilisateur";
                        document.getElementById("error_msg").textContent = msg;
                        document.getElementById("error_msg").style.color = "red";
                    }
                    else {
                        msg = "Les données saisies ne peuvent pas être insérées";
                        document.getElementById("error_msg").textContent = msg;
                        document.getElementById("error_msg").style.color = "red";
                        console.log(response.data);
                    }
                })
            } 
            else{
                document.getElementById("error_msg").textContent = "Veuillez remplir correctement tous les champs";
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
    background: rgb(245,245,245);
}
.container{
    margin-top: 6%;
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
.img-fluid{
    max-width: 100%;
    height: auto;
}
.logo{
    width: 150px
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
.formulaire{
    padding-left: 20%; 
    padding-top: 5%;
}

#error_msg{
    color:red;
}
</style>