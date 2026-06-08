<template>
    <div class="col-span-3">

        <div
            class="
            rounded-3xl
            bg-slate-900/80
            border border-slate-800
            backdrop-blur-xl
            p-5"
        >

            <h2
                class="font-semibold text-lg mb-5"
            >
                Онлайн
            </h2>

            <div class="space-y-3">

                <div
                    v-for="friend in friends" :key="friend.id"
                    class="
                    flex items-center gap-3
                    bg-slate-800
                    rounded-xl
                    p-3"
                >

                    <div
                        class="
                        w-10 h-10 rounded-full
                        bg-gradient-to-br
                        from-cyan-500
                        to-blue-600"
                    />

                    <div>

                        <div
                            class="font-medium"
                        >
                            {{ friend.name }}
                        </div>

                        <div
                            class="text-xs text-emerald-400" 
                        >
                            online
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</template>

<script setup>

import axios from 'axios';
import { ref, onMounted } from 'vue';

const friends = ref(null)

const getOnlineFriends = async () => {

    try{

        const res = await axios.get('/api/users/online')

        friends.value = res.data

    }catch(error){

        console.log(error)
    }
}

onMounted(() => {
    getOnlineFriends()
})

</script>