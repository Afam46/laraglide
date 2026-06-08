<template>
    <MainLayout>

        <div class="flex items-center justify-between mb-8">

            <div class="flex items-center gap-3">

                <div class="w-2 h-8 rounded-full bg-blue-500" />

                <h1 class="text-3xl font-bold">
                    Все пользователи
                </h1>

                <span
                    class="px-3 py-1 bg-slate-800 rounded-full text-sm text-slate-400"
                >
                    {{ users?.length || 0 }}
                </span>

            </div>

        </div>

        <div class="mb-8">

            <input
                v-model="search"
                type="text"
                placeholder="Поиск пользователей..."
                class="
                    w-full
                    bg-slate-900
                    border border-slate-800
                    rounded-2xl
                    px-5 py-4
                    outline-none
                    focus:border-blue-500
                "
            >

        </div>

        <div class="grid md:grid-cols-3 xl:grid-cols-4 gap-5">

            <div
                v-for="user in filteredUsers"
                :key="user.id"
                class="
                    bg-slate-900
                    border border-slate-800
                    rounded-2xl
                    p-5
                    hover:border-blue-500/40
                    hover:scale-[1.02]
                    transition
                "
            >

                <div class="flex items-center gap-4">

                    <div class="relative">

                        <div
                            class="
                                w-16 h-16
                                rounded-full
                                bg-gradient-to-br
                                from-blue-500
                                to-blue-700
                            "
                        />

                        <div
                            class="
                                absolute bottom-0 right-0
                                w-4 h-4 rounded-full
                                border-2 border-slate-900
                            "
                            :class="
                                user.is_online
                                ? 'bg-emerald-500'
                                : 'bg-slate-500'
                            "
                        />

                    </div>

                    <div class="flex-1">

                        <h3 class="font-bold text-lg">
                            {{ user.name }}
                        </h3>

                        <p
                            class="text-sm"
                            :class="
                                user.is_online
                                ? 'text-emerald-400'
                                : 'text-slate-500'
                            "
                        >
                            {{ user.is_online ? 'В сети' : 'Не в сети' }}
                        </p>

                    </div>

                </div>

                <div class="mt-4 text-sm text-slate-400 line-clamp-2">
                    {{ user.profile?.bio || 'Пользователь пока ничего о себе не рассказал' }}
                </div>

                <div class="mt-5 grid grid-cols-2 gap-2">

                    <button
                        @click.prevent="sendRequest(user.id)"
                        class="
                            py-2 rounded-xl
                            bg-blue-600 hover:bg-blue-700
                            transition cursor-pointer
                        "
                    >
                        ➕ В друзья
                    </button>

                    <RouterLink
                        :to="'/profile?id=' + user.id"
                        class="
                            py-2 rounded-xl
                            bg-slate-800 hover:bg-slate-700
                            text-center transition
                        "
                    >
                        👤 Профиль
                    </RouterLink>

                </div>

            </div>

        </div>

    </MainLayout>
</template>

<script setup>
import MainLayout from '../layouts/MainLayout.vue'
import axios from 'axios';
import { computed, ref, onMounted } from 'vue';

const users = ref(null)
const search = ref('')

const getUsers = async () => {

    try{
        const res = await axios.get('/api/users')

        users.value = res.data;

    }catch(error){

        console.log(error)
    }
}

const filteredUsers = computed(() => {

    if (!search.value) {
        return users.value || []
    }

    return users.value.filter(user =>
        user.name.toLowerCase()
            .includes(search.value.toLowerCase())
    )
})

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