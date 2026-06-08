<template>
    <MainLayout>

        <div class="h-[80vh] grid grid-cols-12 gap-4">

            <div class="col-span-4 bg-slate-900 rounded-2xl overflow-hidden">

                <div class="p-4 border-b border-slate-800">
                    <h2 class="font-bold text-xl">
                        Диалоги
                    </h2>
                </div>

                <div
                    v-for="chat in chats"
                    :key="chat.id"
                    @click="selectChat(chat)"
                    class="
                        p-4
                        border-b border-slate-800
                        hover:bg-slate-800
                        cursor-pointer
                    "
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="
                                w-12 h-12
                                rounded-full
                                bg-gradient-to-br
                                from-blue-500
                                to-blue-700
                            "
                        />

                        <div>

                            <div class="font-semibold">
                                {{ getCompanion(chat).name }}
                            </div>

                            <div class="text-sm text-slate-400">
                                {{ chat.last_message?.user?.id === user.id ? 
                                'Вы: ' : chat.last_message?.user?.name + ': ' }}

                                {{ chat.last_message?.body }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div
                class="col-span-8 bg-slate-900 rounded-2xl overflow-hidden flex flex-col"
            >

                <template v-if="selectedChat">

                    <FriendChat
                        :messages="messages"
                        :chat="selectedChat"
                        @message-sent="reloadMessages"
                    />

                </template>

                <template v-else>

                    <div
                        class="
                            flex-1
                            flex
                            items-center
                            justify-center
                            text-slate-500
                        "
                    >
                        Выберите диалог
                    </div>

                </template>

            </div>

        </div>

    </MainLayout>
</template>

<script setup>

import MainLayout from '../layouts/MainLayout.vue'
import FriendChat from '../layouts/messages/FriendChat.vue';
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useAuth } from '../composables/useAuth';

const { user } = useAuth()

const chats = ref([])
const selectedChat = ref(null)

const messages = ref([])

const getChats = async () => {

    try{
        const res = await axios.get('/api/chats')

        chats.value = res.data;

    }catch(error){

        console.log(error)
    }
}

const selectChat = async (chat) => {
    selectedChat.value = chat
    try{
        const res = await axios.get(`/api/chats/${chat.id}/messages`)

        messages.value = res.data
    }catch(error){

        console.log(error)
    }
}

const getCompanion = (chat) => {
    return chat.users.find(
        u => u.id !== user.value.id
    )
}

const reloadMessages = async () => {
    if (!selectedChat.value) return

    const res = await axios.get(
        `/api/chats/${selectedChat.value.id}/messages`
    )

    messages.value = res.data
}

onMounted(() => {
    getChats()
})

</script>