<template>
    <MainLayout>

        <h1 class="text-3xl font-bold mb-6">
            Все пользователи на
        </h1>

        <div class="grid md:grid-cols-3 gap-4">

            <div
                v-for="user in users" :key="user.id"
                class="bg-slate-900 rounded-xl p-4"
            >
                <div class="font-semibold">
                    {{ user.name }}
                </div>
                <p>
                    {{ user.is_online ? 'online' : 'offline' }}
                </p>

                <button
                    @click.prevent="sendRequest(user.id)"
                    class="mt-3 bg-blue-600 px-3 py-2 rounded cursor-pointer"
                >
                    Отправить заявку
                </button>
            </div>

        </div>

    </MainLayout>
</template>

<script setup>
import MainLayout from '../layouts/MainLayout.vue'
import axios from 'axios';
import { ref, onMounted } from 'vue';

const users = ref(null)

const getUsers = async () => {

    try{
        const res = await axios.get('/api/users')

        users.value = res.data;

    }catch(error){

        console.log(error)
    }
}

const sendRequest = async (id) => {
    
    try{
        await axios.post(`/api/friends/request/${id}`)

        getUsers()
        
    }catch(error){

        console.log(error)
    }
}

onMounted(() => {
    getUsers()
})

</script>