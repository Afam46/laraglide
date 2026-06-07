<template>
    <MainLayout>

        <h1 class="text-3xl font-bold mb-6">
            Друзья
        </h1>

        <div class="grid md:grid-cols-3 gap-4">

            <div
                v-for="friend in friends" :key="friend.id"
                class="bg-slate-900 rounded-xl p-4"
            >
                <div class="font-semibold">
                    {{ friend.name }}
                </div>
                <p>
                    {{ friend.is_online ? 'online' : 'offline' }}
                </p>

                <button
                    class="mt-3 bg-blue-600 px-3 py-2 rounded cursor-pointer"
                >
                    Написать
                </button>
                <button
                    @click.prevent="deleteFriend(friend.id)"
                    class="mt-3 bg-red-600 px-3 py-2 rounded cursor-pointer"
                >
                    Удалить
                </button>
            </div>

        </div>

        <h1 class="text-3xl font-bold mb-6">
            Заявки
        </h1>

        <div class="grid md:grid-cols-3 gap-4">

            <div
                v-for="pendingFriend in pendingFriends" :key="pendingFriend.id"
                class="bg-slate-900 rounded-xl p-4"
            >
                <div class="font-semibold">
                    {{ pendingFriend.sender.name }}
                </div>
                <p>
                    {{ pendingFriend.sender.is_online ? 'online' : 'offline' }}
                </p>

                <button
                    @click.prevent="accept(pendingFriend.id)"
                    class="mt-3 bg-blue-600 px-3 py-2 rounded cursor-pointer"
                >
                    Принять
                </button>
                <button
                    @click.prevent="deleteFriend(pendingFriend.id)"
                    class="mt-3 bg-red-600 px-3 py-2 rounded cursor-pointer"
                >
                    Отклонить
                </button>
            </div>

        </div>

        <h1 class="text-3xl font-bold mb-6">
            Ваши заявки
        </h1>

        <div class="grid md:grid-cols-3 gap-4">

            <div
                v-for="outgoingRequest in outgoingRequests" :key="outgoingRequest.id"
                class="bg-slate-900 rounded-xl p-4"
            >
                <div class="font-semibold">
                    {{ outgoingRequest.receiver.name }}
                </div>
                <p>
                    {{ outgoingRequest.receiver.is_online ? 'online' : 'offline' }}
                </p>

                <button
                    @click.prevent="deleteFriend(outgoingRequest.id)"
                    class="mt-3 bg-red-600 px-3 py-2 rounded cursor-pointer"
                >
                    Отменить
                </button>
            </div>

        </div>

    </MainLayout>
</template>

<script setup>
import MainLayout from '../layouts/MainLayout.vue'
import axios from 'axios';
import { ref, onMounted } from 'vue';

const friends = ref(null)
const pendingFriends = ref(null)
const outgoingRequests = ref(null)

const getFriends = async () => {

    try{
        const res = await axios.get('/api/friends')

        friends.value = res.data;

    }catch(error){

        console.log(error)
    }
}

const getPendingFriends = async () => {

    try{
        const res = await axios.get('/api/friends/pending')

        pendingFriends.value = res.data;

    }catch(error){

        console.log(error)
    }
}

const getOutgoingRequests = async () => {
    try{
        const res = await axios.get('/api/friends/outgoing')

        outgoingRequests.value = res.data;

    }catch(error){

        console.log(error)
    }
}

const accept = async (id) => {
    try{
        await axios.post(`/api/friends/${id}/accept`)

        getFriends()
        getPendingFriends()
        getOutgoingRequests()

    }catch(error){

        console.log(error)
    }
}

const deleteFriend = async (id) => {
    try{
        await axios.delete(`/api/friends/${id}`)

        getFriends()
        getPendingFriends()
        getOutgoingRequests()

    }catch(error){

        console.log(error)
    }
}

onMounted(() => {
    getFriends()
    getPendingFriends()
    getOutgoingRequests()
})

</script>