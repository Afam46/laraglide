<template>
    <div
        class="
            p-4
            border-b border-slate-800
            flex items-center gap-3
        "
    >

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
                {{ companion?.name }}
            </div>

            <div class="text-sm" :class="companion?.is_online ? 'text-emerald-400' : 'text-gray-400'">
                {{ companion?.is_online ? 'online' : 'offline' }}
            </div>

        </div>

    </div>

    <div
        class="flex-1 overflow-y-auto p-6 space-y-4"
    >

        <div
            v-for="message in messages"
            :key="message.id"
            class="flex"
            :class="{
                'justify-end': message.user_id === user.id
            }"
        >

            <div
                class="
                    max-w-md
                    px-4 py-3
                    rounded-2xl
                "
                :class="message.user_id === user.id
                    ? 'bg-blue-600'
                    : 'bg-slate-800'
                "
            >

                {{ message.body }}

            </div>

        </div>

    </div>

    <form
        @submit.prevent="sendMessage"
        class="
            p-4
            border-t border-slate-800
            flex gap-3
        "
    >

        <input
            v-model="body"
            placeholder="Сообщение..."
            class="
                flex-1
                bg-slate-800
                rounded-xl
                px-4 py-3
            "
        >

        <button
            class="
                px-6
                rounded-xl
                bg-blue-600
            "
        >
            →
        </button>

    </form>
</template>

<script setup>

import axios from 'axios';
import { ref, onMounted } from 'vue';
import { computed } from 'vue'
import { useAuth } from '../../composables/useAuth'

const props = defineProps({
    messages: Array,
    chat: Object,
})

const { user } = useAuth()

const companion = computed(() => {
    return props.chat?.users.find(
        u => u.id !== user.value.id
    )
})

const emit = defineEmits(['message-sent'])

const body = ref('')

const sendMessage = async () => {

    if (body.value.trim() == ''){
        return
    }

    try{

        await axios.post(`/api/chats/${props.chat.id}/send`,{ body: body.value })

        body.value = ''

        emit('message-sent')

    }catch(error){
        console.log(error)
    }
}

</script>