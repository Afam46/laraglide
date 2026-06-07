<template>
    <div class="min-h-screen flex items-center justify-center bg-slate-950">

        <div class="w-full max-w-md bg-slate-900 p-8 rounded-xl">

            <h1 class="text-3xl font-bold text-center mb-6 text-white">
                Вход
            </h1>

            <form class="space-y-4" @submit.prevent="login">

                <input
                    v-model="form.email"
                    type="email"
                    placeholder="Email"
                    class="w-full bg-slate-800 p-3 rounded text-white"
                />

                <input
                    v-model="form.password"
                    type="password"
                    placeholder="Пароль"
                    class="w-full bg-slate-800 p-3 rounded text-white"
                />

                <button
                    :disabled="loading"
                    class="w-full bg-blue-600 p-3 rounded text-white"
                >
                    {{ loading ? 'Входим...' : 'Войти' }}
                </button>

            </form>

        </div>

    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, reactive } from 'vue';
import router from '../router/index.js';

const form = reactive({
    'email': '',
    'password': ''
})

let loading = ref(false)

const login = async () => {

    loading.value = true

    try {

        const res = await axios.post('/api/login', form)

        localStorage.setItem('token', res.data.token)

        axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.token}`

        router.push('/')

    }catch(error){

        alert(error.response?.data?.message ?? 'Ошибка авторизации')

    }finally{
        loading.value = false
    }

}

</script>