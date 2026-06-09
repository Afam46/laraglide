<template>
    <MainLayout>

    <div
        v-if="user"
        class="
            max-w-4xl mx-auto
            bg-slate-900
            border border-slate-800
            rounded-3xl
            overflow-hidden
        "
    >

        <div
            class="
                h-48
                bg-gradient-to-r
                from-blue-700
                via-indigo-700
                to-purple-700
            "
        />

        <div class="px-8 pb-8">

            <div class="-mt-16 flex items-end justify-between">

                <div class="flex items-center gap-6">

                    <img
                        class="
                            w-32 h-32
                            rounded-full
                            border-4 border-slate-900
                            object-cover
                            bg-slate-800
                        "
                        :src="user.profile.avatar"
                    >

                    <div>

                        <h1 class="text-4xl font-bold">
                            {{ user.name }}
                        </h1>

                        <p
                            class="mt-2"
                            :class="
                                user.is_online
                                ? 'text-emerald-400'
                                : 'text-slate-500'
                            "
                        >
                            ● {{ user.is_online ? 'В сети' : 'Не в сети' }}
                        </p>

                    </div>

                </div>

                <button
                    v-if="isOwnProfile && !isEditing"
                    @click="startEditing"
                    class="
                        px-5 py-2
                        rounded-xl
                        bg-blue-600
                        hover:bg-blue-700
                        transition
                        cursor-pointer
                    "
                >
                    ✏️ Изменить профиль
                </button>

            </div>

            <div
                v-if="!isEditing"
                class="grid md:grid-cols-2 gap-4 mt-10"
            >

                <div
                    class="
                        bg-slate-800
                        rounded-2xl
                        p-5
                    "
                >
                    <div class="text-slate-400 mb-2">
                        О себе
                    </div>

                    <div>
                        {{ user.profile?.bio || 'Пользователь пока ничего не рассказал о себе' }}
                    </div>
                </div>

                <div
                    class="
                        bg-slate-800
                        rounded-2xl
                        p-5
                    "
                >
                    <div class="text-slate-400 mb-2">
                        Город
                    </div>

                    <div>
                        {{ user.profile?.city || 'Не указан' }}
                    </div>
                </div>

                <div
                    class="
                        bg-slate-800
                        rounded-2xl
                        p-5
                    "
                >
                    <div class="text-slate-400 mb-2">
                        Дата рождения
                    </div>

                    <div>
                        {{ user.profile?.birth_date || 'Не указана' }}
                    </div>
                </div>

                <div
                    class="
                        bg-slate-800
                        rounded-2xl
                        p-5
                    "
                >
                    <div class="text-slate-400 mb-2">
                        Регистрация
                    </div>

                    <div>
                        {{ new Date(user.created_at).toLocaleDateString() }}
                    </div>
                </div>

            </div>

            <div
                v-else
                class="mt-10 space-y-6"
            >

                <div
                    class="
                        bg-slate-800
                        rounded-2xl
                        p-6
                    "
                >

                    <label
                        class="
                            block
                            text-slate-400
                            mb-3
                        "
                    >
                        О себе
                    </label>

                    <textarea
                        v-model="editForm.bio"
                        rows="5"
                        class="
                            w-full
                            bg-slate-900
                            border border-slate-700
                            rounded-xl
                            p-4
                            focus:border-blue-500
                            focus:outline-none
                        "
                        placeholder="Расскажите о себе"
                    />

                </div>

                <div class="grid md:grid-cols-2 gap-4">

                    <div
                        class="
                            bg-slate-800
                            rounded-2xl
                            p-6
                        "
                    >

                        <label
                            class="
                                block
                                text-slate-400
                                mb-3
                            "
                        >
                            Город
                        </label>

                        <input
                            v-model="editForm.city"
                            type="text"
                            class="
                                w-full
                                bg-slate-900
                                border border-slate-700
                                rounded-xl
                                p-3
                                focus:border-blue-500
                                focus:outline-none
                            "
                            placeholder="Ваш город"
                        >

                    </div>

                    <div
                        class="
                            bg-slate-800
                            rounded-2xl
                            p-6
                        "
                    >

                        <label
                            class="
                                block
                                text-slate-400
                                mb-3
                            "
                        >
                            Дата рождения
                        </label>

                        <input
                            v-model="editForm.birth_date"
                            type="date"
                            class="
                                w-full
                                bg-slate-900
                                border border-slate-700
                                rounded-xl
                                p-3
                                focus:border-blue-500
                                focus:outline-none
                            "
                        >

                    </div>

                </div>

                <div
                    class="
                        bg-slate-800
                        rounded-2xl
                        p-6
                    "
                >

                    <label
                        class="
                            block
                            text-slate-400
                            mb-3
                        "
                    >
                        Аватар
                    </label>

                    <input
                        type="file"
                        @change="handleAvatar"
                        accept="image/*"
                        class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3"
                    >
                    

                </div>

                <div class="flex gap-3">

                    <button
                        @click="updateProfile"
                        :disabled="loading"
                        class="
                            px-6 py-3
                            rounded-xl
                            bg-emerald-600
                            hover:bg-emerald-700
                            transition
                            disabled:opacity-50
                            cursor-pointer
                        "
                    >
                        {{ loading ? 'Сохранение...' : 'Сохранить' }}
                    </button>

                    <button
                        @click="cancelEditing"
                        class="
                            px-6 py-3
                            rounded-xl
                            bg-slate-700
                            hover:bg-slate-600
                            transition
                            cursor-pointer
                        "
                    >
                        Отмена
                    </button>

                </div>

            </div>

        </div>

    </div>
        
    </MainLayout>
</template>

<script setup>
import MainLayout from '../layouts/MainLayout.vue'
import axios from 'axios';
import { computed, ref, onMounted, reactive } from 'vue';
import { useRoute } from 'vue-router';
import { useAuth } from '../composables/useAuth'

const { user: authUser } = useAuth()

const isOwnProfile = computed(() => {
    return authUser.value?.id === user.value?.id
})

const avatarFile = ref(null)

const handleAvatar = (e) => {
    avatarFile.value = e.target.files[0]
}

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

    try {

        const formData = new FormData()

        formData.append('bio', editForm.bio)
        formData.append('city', editForm.city)
        formData.append('birth_date', editForm.birth_date)

        if (avatarFile.value) {
            formData.append('avatar', avatarFile.value)
        }

        await axios.post('/api/profiles/update', formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        )

        await getUser()

        isEditing.value = false

    } catch (error) {

        console.log(error)

    } finally {

        loading.value = false
    }
}

onMounted(() => {
    getUser()
})

</script>