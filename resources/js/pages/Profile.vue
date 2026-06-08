<template>
    <MainLayout>

        <div class="bg-slate-900 rounded-xl p-8" v-if="user">

            <img
                class="w-32 h-32 rounded-full object-cover"
                src="/storage/app/public/afam.jpg"
            >

            <h1 class="text-3xl mt-4 font-bold">
                {{ user.name }}
            </h1>

            <div v-if="!isEditing">
                <p class="text-slate-400">
                    <strong>О себе:</strong> {{ user.profile?.bio || 'Не указано' }}
                </p>
                <p class="text-slate-400">
                    <strong>Дата рождения:</strong> {{ user.profile?.birth_date || 'Не указана' }}
                </p>
                <p class="text-slate-400">
                    <strong>Город:</strong> {{ user.profile?.city || 'Не указан' }}
                </p>

                <button
                    @click="startEditing"
                    class="mt-4 px-6 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700
                    hover:scale-105 transition cursor-pointer"
                >
                    Изменить
                </button>
            </div>

            <div v-else class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">О себе</label>
                    <textarea
                        v-model="editForm.bio"
                        class="w-full px-4 py-2 rounded-xl bg-slate-800 border border-slate-700
                        text-white focus:outline-none focus:border-blue-500"
                        rows="3"
                        placeholder="Расскажите о себе"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Дата рождения</label>
                    <input
                        type="date"
                        v-model="editForm.birth_date"
                        class="w-full px-4 py-2 rounded-xl bg-slate-800 border border-slate-700
                        text-white focus:outline-none focus:border-blue-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Город</label>
                    <input
                        type="text"
                        v-model="editForm.city"
                        class="w-full px-4 py-2 rounded-xl bg-slate-800 border border-slate-700
                        text-white focus:outline-none focus:border-blue-500"
                        placeholder="Ваш город"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Аватар (URL)</label>
                    <input
                        type="text"
                        v-model="editForm.avatar"
                        class="w-full px-4 py-2 rounded-xl bg-slate-800 border border-slate-700
                        text-white focus:outline-none focus:border-blue-500"
                        placeholder="Ссылка на аватар"
                    >
                </div>

                <div class="flex gap-3">
                    <button
                        @click="updateProfile"
                        :disabled="loading"
                        class="px-6 py-2 rounded-xl bg-gradient-to-r from-green-600 to-green-700
                        hover:scale-105 transition cursor-pointer disabled:opacity-50"
                    >
                        {{ loading ? 'Сохранение...' : 'Сохранить' }}
                    </button>
                    <button
                        @click="cancelEditing"
                        class="px-6 py-2 rounded-xl bg-gradient-to-r from-gray-600 to-gray-700
                        hover:scale-105 transition cursor-pointer"
                    >
                        Отмена
                    </button>
                </div>
            </div>

        </div>

    </MainLayout>
</template>

<script setup>
import MainLayout from '../layouts/MainLayout.vue'
import axios from 'axios';
import { ref, onMounted, reactive } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute()
const user = ref(null)
const isEditing = ref(false)
const loading = ref(false)

const editForm = reactive({
    bio: '',
    birth_date: '',
    city: '',
    avatar: ''
})

const getUser = async () => {
    let userId = route.query.id

    try{
        const res = await axios.get(`/api/users/show/${userId}`)
        user.value = res.data;

    }catch(error){

        console.log(error)
    }
}

const startEditing = () => {
    editForm.bio = user.value.profile?.bio || ''
    editForm.birth_date = user.value.profile?.birth_date || ''
    editForm.city = user.value.profile?.city || ''
    editForm.avatar = user.value.profile?.avatar || ''
    isEditing.value = true
}

const cancelEditing = () => {
    isEditing.value = false
}

const updateProfile = async () => {
    loading.value = true
    
    try{
        await axios.put('/api/profiles/update', {
            bio: editForm.bio,
            birth_date: editForm.birth_date,
            city: editForm.city,
            avatar: editForm.avatar
        })

        await getUser()
        
        isEditing.value = false
        
    }catch(error){

        console.log(error)

    }finally{
        loading.value = false
    }
}

onMounted(() => {
    getUser()
})

</script>