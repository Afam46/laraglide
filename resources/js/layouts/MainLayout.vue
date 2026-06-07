<template>
    <div class="min-h-screen bg-slate-950 text-white">

        <nav class="border-b border-slate-800 bg-slate-900">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex h-16 items-center gap-6">

                    <RouterLink to="/" class="font-bold text-xl text-blue-400">
                        LaraGlide
                    </RouterLink>

                    <RouterLink to="/" class="hover:text-blue-400">
                        Глобальный чат
                    </RouterLink>

                    <RouterLink to="/friends" class="hover:text-blue-400">
                        Друзья
                    </RouterLink>

                    <RouterLink to="/messages" class="hover:text-blue-400">
                        Личные чаты
                    </RouterLink>

                    <RouterLink to="/profile" class="hover:text-blue-400">
                        Профиль
                    </RouterLink>

                    <div class="ml-auto flex gap-4">
                        <RouterLink
                            v-if="!user"
                            to="/login"
                            class="px-4 py-2 rounded bg-slate-800 hover:bg-slate-700"
                        >
                            Вход
                        </RouterLink>

                        <RouterLink
                            v-if="!user"
                            to="/register"
                            class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-500"
                        >
                            Регистрация
                        </RouterLink>
                        <button
                            v-if="user"
                            class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-500"
                            @click="logout"
                        >
                            Выход
                        </button>
                    </div>

                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto p-6">
            <slot />
        </main>

    </div>
</template>

<script setup>
import { useAuth } from '../composables/useAuth'

const { user } = useAuth()
const { logout } = useAuth()
</script>