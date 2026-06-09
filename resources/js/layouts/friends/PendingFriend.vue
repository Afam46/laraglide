<template>
    <div class="flex items-center gap-3 mb-6">

        <div class="w-2 h-8 rounded-full bg-yellow-500" />

        <h1 class="text-3xl font-bold">
            Заявки
        </h1>

        <span
            class="
            px-3 py-1
            bg-slate-800
            rounded-full
            text-sm text-slate-400"
        >
            {{ pendingFriends?.length || 0 }}
        </span>

    </div>

    <div class="grid md:grid-cols-3 gap-4">

        <div
            v-for="pendingFriend in pendingFriends"
            :key="pendingFriend.id"
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

                    <img
                        class="
                            w-16 h-16
                            rounded-full
                            bg-gradient-to-br
                            border-slate-900
                            bg-slate-800
                        "
                        :src="pendingFriend.sender.profile.avatar"
                    />

                    <div
                        class="absolute bottom-0 right-0
                        w-4 h-4 rounded-full border-2 border-slate-900"
                        :class="
                            pendingFriend.sender.is_online
                            ? 'bg-emerald-500'
                            : 'bg-slate-500'
                        "
                    />

                </div>

                <div class="flex-1">

                    <h3 class="font-bold text-lg">
                        {{ pendingFriend.sender.name }}
                    </h3>

                    <p
                        class="text-sm"
                        :class="
                            pendingFriend.sender.is_online
                            ? 'text-emerald-400'
                            : 'text-slate-500'
                        "
                    >
                        {{ pendingFriend.sender.is_online ? 'В сети' : 'Не в сети' }}
                    </p>

                </div>

            </div>

            <div class="mt-5 grid grid-cols-2 gap-2">

                <button
                    @click="$emit('accept', pendingFriend.id)"
                    class="
                    py-2 rounded-xl
                    bg-blue-600 hover:bg-blue-700
                    transition cursor-pointer"
                >
                    Принять
                </button>

                <RouterLink
                    :to="'/profile?id='+pendingFriend.sender.id"
                    class="
                    py-2 rounded-xl
                    bg-slate-800 hover:bg-slate-700
                    text-center transition"
                >
                    👤 Профиль
                </RouterLink>

            </div>

            <button
                @click="$emit('delete', pendingFriend.id)"
                class="
                mt-2
                w-full
                py-2
                rounded-xl
                bg-red-600 hover:bg-red-700
                transition cursor-pointer"
            >
                Отклонить
            </button>

        </div>

    </div>
</template>

<script setup>

defineProps({
    pendingFriends: Array
})

const emit = defineEmits([
    'accept',
    'delete'
])

</script>