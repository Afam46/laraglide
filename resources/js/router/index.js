import { createRouter, createWebHistory } from 'vue-router'

import Home from '../pages/Home.vue'
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import Profile from '../pages/Profile.vue'
import Friends from '../pages/Friends.vue'
import Messages from '../pages/Messages.vue'

const routes = [
    { path: '/', component: Home, meta: { auth: true } },
    { path: '/login', component: Login, meta: { guest: true }  },
    { path: '/register', component: Register, meta: { guest: true }  },
    { path: '/profile', component: Profile, meta: { auth: true }  },
    { path: '/friends', component: Friends, meta: { auth: true }  },
    { path: '/messages', component: Messages, meta: { auth: true }  },
]

export default createRouter({
    history: createWebHistory(),
    routes,
})

import { useAuth } from '../composables/useAuth'
import router from '.'

router.beforeEach(async (to, from, next) => {

    const token = localStorage.getItem('token')

    const { getUser } = useAuth()

    const user = await getUser()

    if (to.meta.auth && !user) {

        return next('/login')

    }

    if (to.meta.guest && user) {

        return next('/')

    }

    next()

})