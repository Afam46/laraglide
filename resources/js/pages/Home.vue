<template>
    <MainLayout>

        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white">
                Глобальный чат
            </h1>

            <p class="text-slate-400 mt-2">
                Общайся со всеми пользователями LaraGlide
            </p>
        </div>

        <div class="grid grid-cols-12 gap-6">

            <!-- чат -->

            <div class="col-span-9">

                <div
                    class="h-175
                    rounded-3xl
                    bg-slate-900/80
                    border border-slate-800
                    backdrop-blur-xl
                    flex flex-col overflow-hidden"
                >

                    <div
                        class="px-6 py-5
                        border-b border-slate-800
                        flex items-center justify-between"
                    >
                        <div>
                            <h2 class="font-semibold text-lg">
                                Общий чат
                            </h2>

                            <span class="text-slate-400 text-sm">
                                348 пользователей онлайн
                            </span>
                        </div>

                        <div
                            class="w-3 h-3 rounded-full bg-emerald-500"
                        />
                    </div>

                    <div
                        class="flex-1 overflow-y-auto p-6 space-y-4"
                    >

                        <div
                            v-for="i in 15"
                            :key="i"
                            class="
                            bg-slate-800/70
                            border border-slate-700
                            rounded-2xl
                            p-4"
                        >
                            <div
                                class="flex items-center gap-3 mb-2"
                            >

                                <div
                                    class="
                                    w-10 h-10
                                    rounded-full
                                    bg-gradient-to-br
                                    from-blue-500
                                    to-blue-700"
                                />

                                <div>

                                    <div
                                        class="font-semibold text-white"
                                    >
                                        User{{ i }}
                                    </div>

                                    <div
                                        class="text-xs text-slate-400"
                                    >
                                        только что
                                    </div>

                                </div>

                            </div>

                            <div class="text-slate-200">
                                Сообщение пользователя в глобальном чате.
                            </div>

                        </div>

                    </div>

                    <div
                        class="p-5 border-t border-slate-800"
                    >

                        <div class="flex gap-3">

                            <input
                                type="text"
                                placeholder="Напишите сообщение..."
                                class="
                                flex-1
                                bg-slate-800
                                border border-slate-700
                                rounded-2xl
                                px-5 py-4
                                outline-none
                                focus:border-blue-500"
                            >

                            <button
                                class="
                                px-6
                                rounded-2xl
                                bg-gradient-to-r
                                from-blue-600
                                to-blue-700
                                hover:scale-105
                                transition"
                            >
                                →
                            </button>

                        </div>

                    </div>

                </div>

            </div>

            <!-- онлайн -->

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
                            v-for="i in 12"
                            :key="i"
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
                                    User{{ i }}
                                </div>

                                <div
                                    class="
                                    text-xs
                                    text-emerald-400"
                                >
                                    online
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </MainLayout>
</template>

<script setup>
import MainLayout from '../layouts/MainLayout.vue'
</script>