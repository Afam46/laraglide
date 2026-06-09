<template>
    <div class="flex items-center gap-3 mb-6">

        <div class="w-2 h-8 rounded-full bg-blue-500" />

        <h1 class="text-3xl font-bold">
            Друзья
        </h1>

        <span
            class="
            px-3 py-1
            bg-slate-800
            rounded-full
            text-sm text-slate-400"
        >
            {{ friends?.length || 0 }}
        </span>

    </div>

    <div class="grid md:grid-cols-3 gap-4">

        <div
            v-for="friend in friends"
            :key="friend.id"
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
                        :src="friend.profile.avatar"
                    />

                    <div
                        class="absolute bottom-0 right-0
                        w-4 h-4 rounded-full border-2 border-slate-900"
                        :class="
                            friend.is_online
                            ? 'bg-emerald-500'
                            : 'bg-slate-500'
                        "
                    />

                </div>

                <div class="flex-1">

                    <h3 class="font-bold text-lg">
                        {{ friend.name }}
                    </h3>

                    <p
                        class="text-sm"
                        :class="
                            friend.is_online
                            ? 'text-emerald-400'
                            : 'text-slate-500'
                        "
                    >
                        {{ friend.is_online ? 'В сети' : 'Не в сети' }}
                    </p>

                </div>

            </div>

            <div class="mt-5 grid grid-cols-2 gap-2">

                <button
                    @click="$emit('start-chat', friend.id)"
                    class="
                    py-2 rounded-xl
                    bg-blue-600 hover:bg-blue-700
                    transition cursor-pointer"
                >
                    💬 Написать
                </button>

                <RouterLink
                    :to="'/profile?id='+friend.id"
                    class="
                    py-2 rounded-xl
                    bg-slate-800 hover:bg-slate-700
                    text-center transition"
                >
                    👤 Профиль
                </RouterLink>

            </div>

            <button
                @click="$emit('delete', friend.friendship_id)"
                class="
                mt-2
                w-full
                py-2
                rounded-xl
                bg-red-600 hover:bg-red-700
                transition cursor-pointer"
            >
                Удалить
            </button>

        </div>

    </div>
</template>

<script setup>

defineProps({
    friends: Array
})

const emit = defineEmits([
    'delete',
    'start-chat'
])

</script>