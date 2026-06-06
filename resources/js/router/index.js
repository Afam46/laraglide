import { createRouter, createWebHistory } from 'vue-router'

import Home from '../pages/Home.vue'
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import Profile from '../pages/Profile.vue'
import Friends from '../pages/Friends.vue'
import Messages from '../pages/Messages.vue'

const routes = [
    { path: '/', component: Home },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/profile', component: Profile },
    { path: '/friends', component: Friends },
    { path: '/messages', component: Messages },
]

export default createRouter({
    history: createWebHistory(),
    routes,
})