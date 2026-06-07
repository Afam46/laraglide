import axios from 'axios'
import { ref } from 'vue'
import router from '../router/index'

const user = ref(null)

export function useAuth() {

    const getUser = async () => {

        const token = localStorage.getItem('token')

        if (!token) {
            return null
        }

        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

        try {

            const res = await axios.get('/api/me')

            user.value = res.data

            return user.value

        } catch {

            logout()

            return null

        }

    }

    const logout = () => {

        localStorage.removeItem('token')

        delete axios.defaults.headers.common['Authorization']

        user.value = null

        router.push('/login')

    }

    return {
        user,
        getUser,
        logout
    }

}