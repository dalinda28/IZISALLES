import { createWebHistory, createRouter } from "vue-router"
import { store } from "../store.js"
import Accueil from '../views/Accueil.vue'
import Reservations from '../views/Reservations.vue'
import Salles from '../views/Salles.vue'
import Contact from '../views/Contact.vue'
import Connexion from '../views/Connexion.vue'
import Inscription from '../views/Inscription.vue'
import AdminUsers from '../views/AdminUsers.vue'
import AdminReservations from '../views/AdminReservations.vue'
import AdminSalles from '../views/AdminSalles.vue'

const routes = [
  
  {
    path: '/',
    name: 'accueil',
    component: Accueil
  },
  {
    path: '/reservations',
    name: 'reservations',
    component: Reservations,
    beforeEnter: isUser
  },
  {
    path: '/salles',
    name: 'salles',
    component: Salles,
    beforeEnter: isUser
  },
  {
    path: '/contact',
    name: 'contact',
    component: Contact,
    beforeEnter: isUser
  },
  {
    path: '/connexion',
    name: 'connexion',
    component: Connexion
  },
  {
    path: '/inscription',
    name: 'inscription',
    component: Inscription,
  },
  {
    path: '/admin-users',
    name: 'adminUsers',
    component: AdminUsers,
    beforeEnter: isAdmin
  }, 
  {
    path: '/admin-reservations',
    name: 'adminReservations',
    component: AdminReservations,
    beforeEnter: isAdmin
  },
  {
    path: '/admin-salles',
    name: 'adminSalles',
    component: AdminSalles,
    beforeEnter: isAdmin
  }
];

const router = createRouter({
  history: createWebHistory('/base-directory/'),
  routes
});

function isUser(to, from, next){
  if(store.state.profile == "enseignant" ) {
    next();
  } else {
      next(false);
  }
}

function isAdmin(to, from, next){
  if(store.state.profile == "administrateur" ) {
    next();
  } else {
      next(false);
  }
}

export default router
