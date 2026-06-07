<template>
    <router-view />
</template>

<script setup>
import { onMounted } from 'vue'
import { useAuth } from './composables/useAuth'

const { getUser } = useAuth()

onMounted(() => {

    getUser()

})
</script>