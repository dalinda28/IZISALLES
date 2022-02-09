import { createApp } from 'vue'
import { store } from './store.js'
import App from './App.vue'
import router from './router'

import 'bootstrap'; 
import 'bootstrap/dist/css/bootstrap.min.css';

import axios from 'axios';
import VueAxios from 'vue-axios';

const app = createApp(App);

app.use(router);
app.use(VueAxios, axios);
app.use(store);
app.mount('#app');

export default store;
/*
Exemple d'insertion de données dans la table User

let formData = new FormData();
formData.append('nom', 'Laazary');
formData.append('prenom', 'Issam');
formData.append('profil', 'enseignant');
formData.append('mail', 'issam@gmail.com');
formData.append('mdp', 'yoyo');

app.axios.post("http://localhost:8888/reservations_salles/src/api/controllers/UsersResource.php", formData)
.then((response) => {
      console.log(response.data)
})
.catch(error => console.log(error));
*/

/*
Exemple de récupération de toutes les données de la table User

app.axios.get("http://localhost:8888/reservations_salles/src/api/controllers/UsersResource.php")
.then((response) => {
      console.log(response.data)
});
*/
/*
Exemple de récupération d'un user en fonction de son id
app.axios.get("http://localhost:8888/reservations_salles/src/api/controllers/UsersResource.php?id=2")
.then((response) => {
      console.log(response.data)
*/