<template>
    <div class="min-h-screen flex items-center justify-center bg-slate-950">

        <div class="w-full max-w-md bg-slate-900 p-8 rounded-xl">

            <h1 class="text-3xl font-bold text-center mb-6 text-white">
                Регистрация
            </h1>

            <form class="space-y-4" @submit.prevent="register">

                <input
                    v-model="form.name"
                    placeholder="Имя"
                    class="w-full bg-slate-800 p-3 rounded text-white"
                />

                <input
                    v-model="form.email"
                    placeholder="Email"
                    class="w-full bg-slate-800 p-3 rounded text-white"
                />

                <input
                    v-model="form.password"
                    type="password"
                    placeholder="Пароль"
                    class="w-full bg-slate-800 p-3 rounded text-white"
                />

                <input
                    v-model="form.password_confirmation"
                    type="password"
                    placeholder="Повторите пароль"
                    class="w-full bg-slate-800 p-3 rounded text-white"
                />

                <button
                    :disabled="loading"
                    class="w-full bg-blue-600 p-3 rounded text-white"
                >
                    {{ loading ? 'Регистрируемся...' : 'Регистрация' }}
                </button>

            </form>

        </div>

    </div>
</template>

<script setup>
import axios from 'axios'
import { ref, reactive } from 'vue'
import router from '../router/index'

const form = reactive({
    'name': '',
    'email': '',
    'password': '',
    'password_confirmation': '',
})

let loading = ref(false)

const register = async () => {

    loading.value = true

    try{

        const res = await axios.post('/api/register', form)

        localStorage.setItem('token', res.data.token)

        axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`

        router.push('/')

    }catch(error){

        alert(error.response?.data?.message ?? 'Ошибка регистрации')
    }finally{
        loading.value = false
    }

}

</script>