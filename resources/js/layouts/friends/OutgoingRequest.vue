<template>
    <div class="flex items-center gap-3 mb-6">

        <div class="w-2 h-8 rounded-full bg-purple-500" />

        <h1 class="text-3xl font-bold">
            Ваши заявки
        </h1>

        <span
            class="
            px-3 py-1
            bg-slate-800
            rounded-full
            text-sm text-slate-400"
        >
            {{ outgoingRequests?.length || 0 }}
        </span>

    </div>

    <div class="grid md:grid-cols-3 gap-4">

        <div
            v-for="outgoingRequest in outgoingRequests"
            :key="outgoingRequest.id"
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
                        class="absolute bottom-0 right-0
                        w-4 h-4 rounded-full border-2 border-slate-900"
                        :class="
                            outgoingRequest.receiver.is_online
                            ? 'bg-emerald-500'
                            : 'bg-slate-500'
                        "
                    />

                </div>

                <div class="flex-1">

                    <h3 class="font-bold text-lg">
                        {{ outgoingRequest.receiver.name }}
                    </h3>

                    <p
                        class="text-sm"
                        :class="
                            outgoingRequest.is_online
                            ? 'text-emerald-400'
                            : 'text-slate-500'
                        "
                    >
                        {{ outgoingRequest.receiver.is_online ? 'В сети' : 'Не в сети' }}
                    </p>

                </div>

            </div>

            <div class="mt-5 grid grid-cols-2 gap-2">

                <button
                    @click="$emit('delete', outgoingRequest.id)"
                    class="
                    py-2 rounded-xl
                    bg-red-600 hover:bg-red-700
                    transition cursor-pointer"
                >
                    Отменить
                </button>

                <RouterLink
                    :to="'/profile?id='+outgoingRequest.receiver.id"
                    class="
                    py-2 rounded-xl
                    bg-slate-800 hover:bg-slate-700
                    text-center transition"
                >
                    👤 Профиль
                </RouterLink>

            </div>
        </div>
    </div>
</template>

<script setup>

defineProps({
    outgoingRequests: Array
})

const emit = defineEmits([
    'delete'
])

</script>