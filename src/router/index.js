import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'accueil',
    component: () => import('../views/Accueil.vue'),
  },
  {
    path: '/reservation',
    name: 'reservation',
    component: () => import('../views/Reservation.vue'),
  },
  {
    path: '/salles',
    name: 'salles',
    component: () => import('../views/Salles.vue')
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import('../views/Contact.vue')
  },
  {
    path: '/connexion',
    name: 'connexion',
    component: () => import('../views/Connexion.vue')
  },
  {
    path: '/inscription',
    name: 'inscription',
    component: () => import('../views/Inscription.vue')
  },
  {
    path: '*',
    redirect: '/',
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
