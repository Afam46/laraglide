<template>
     <div class="col-span-9">

        <div
            class="h-175
            rounded-3xl
            bg-slate-900/80
            border border-slate-800
            backdrop-blur-xl
            flex flex-col overflow-hidden"
        >

            <div
                class="px-6 py-5
                border-b border-slate-800
                flex items-center justify-between"
            >
                <div>
                    <h2 class="font-semibold text-lg">
                        Общий чат
                    </h2>

                    <span class="text-slate-400 text-sm">
                        348 пользователей онлайн
                    </span>
                </div>

                <div
                    class="w-3 h-3 rounded-full bg-emerald-500"
                />
            </div>

            <div class="flex-1 overflow-y-auto p-6 space-y-4">

                <div
                    v-for="message in messages" :key="message.id"
                    class="
                    bg-slate-800/70
                    border border-slate-700
                    rounded-2xl
                    p-4"
                >
                    <div
                        class="flex items-center gap-3 mb-2"
                    >

                        <div
                            class="
                            w-10 h-10
                            rounded-full
                            bg-gradient-to-br
                            from-blue-500
                            to-blue-700
                            "
                        />

                        <div>

                            <div
                                class="font-semibold text-white"
                            >
                                {{ user.id == message.user.id ?  'Я' : message.user.name }}
                            </div>

                            <div
                                class="text-xs text-slate-400"
                            >
                                {{ formatTime(message.created_at) }}
                            </div>

                        </div>

                    </div>

                    <div class="text-slate-200">
                        {{ message.body }}
                    </div>

                    <button
                        v-if="user.id == message.user.id"
                        @click="deleteMessage(message.id)"
                        class="
                        px-6 rounded-2xl bg-gradient-to-r from-red-600 to-red-700
                        hover:scale-105 transition float-end cursor-pointer"
                        >
                        Удалить
                    </button>
                </div>
            </div>

            <div
                class="p-5 border-t border-slate-800"
            >

                <div class="flex gap-3">
                    <form @submit.prevent="sendMessage" class="w-full flex justify-between">
                        <input
                            v-model="content"
                            type="text"
                            placeholder="Напишите сообщение..."
                            class="
                            flex-1
                            bg-slate-800
                            border border-slate-700
                            rounded-2xl
                            px-5 py-4
                            outline-none
                            focus:border-blue-500"
                        >

                        <button
                            class="
                            px-6
                            rounded-2xl
                            bg-gradient-to-r
                            from-blue-600
                            to-blue-700
                            hover:scale-105
                            transition"
                        >
                            →
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>
</template>

<script setup>

import axios from 'axios';
import { ref, onMounted } from 'vue';
import Messages from '../pages/Messages.vue';
import { useAuth } from '../composables/useAuth.js';

const { user } = useAuth()

const content = ref('')
const messages = ref(null)

const sendMessage = async () => {
    try{
        const res = await axios.post('/api/global-chat/messages', {
            body: content.value
        })

        content.value = ''

        getGlobalChatMessages()

    }catch(error){
        
        alert(error)
    }
}

const getGlobalChatMessages = async () =>{
    try{

        const res = await axios.get('/api/global-chat/messages')

        messages.value = res.data

    }catch(error){

        console.log(error)
    }
}

const formatTime = (dateString) => {

    const date = new Date(dateString)
    return date.toLocaleTimeString('ru-RU', {
        hour: '2-digit',
        minute: '2-digit'
    })
}

const deleteMessage = async (id) => {
    try{

        await axios.delete(`/api/global-chat/messages/${id}`)

        getGlobalChatMessages()
        
    }catch(error){
        alert(error)
    }
}

onMounted(() => {
    getGlobalChatMessages()
})

</script>