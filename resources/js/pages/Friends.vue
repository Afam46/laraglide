<template>
    <MainLayout>

        <div class="space-y-12">

            <FriendsList
                :friends="friends"
                @delete="deleteFriend"
                @start-chat="startChat"
            />

            <PendingFriend
                :pending-friends="pendingFriends"
                @accept="accept"
                @delete="deleteFriend"
            />

            <OutgoingRequest
                :outgoing-requests="outgoingRequests"
                @delete="deleteFriend"
            />
        
        </div>

    </MainLayout>
</template>

<script setup>
import MainLayout from '../layouts/MainLayout.vue'

import FriendsList from '../layouts/friends/FriendsList.vue'
import PendingFriend from '../layouts/friends/PendingFriend.vue'
import OutgoingRequest from '../layouts/friends/OutgoingRequest.vue'

import axios from 'axios'
import { ref, onMounted } from 'vue'
import router from '../router'

const friends = ref([])
const pendingFriends = ref([])
const outgoingRequests = ref([])

const getFriends = async () => {
    const res = await axios.get('/api/friends')
    friends.value = res.data
}

const getPendingFriends = async () => {
    const res = await axios.get('/api/friends/pending')
    pendingFriends.value = res.data
}

const getOutgoingRequests = async () => {
    const res = await axios.get('/api/friends/outgoing')
    outgoingRequests.value = res.data
}

const loadData = async () => {

    await Promise.all([
        getFriends(),
        getPendingFriends(),
        getOutgoingRequests()
    ])
}

const accept = async (id) => {

    await axios.post(`/api/friends/${id}/accept`)

    await loadData()
}

const deleteFriend = async (id) => {

    await axios.delete(`/api/friends/${id}`)

    await loadData()
}

const startChat = async (friendId) => {

    await axios.post(`/api/chats/create/${friendId}`)

    router.push('/messages')
}

onMounted(loadData)
</script>