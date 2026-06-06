<template>
    <MainLayout>

        <h1 class="text-3xl font-bold mb-6">
            Друзья
        </h1>

        <div class="grid md:grid-cols-3 gap-4">

            <div
                v-for="i in 12"
                :key="i"
                class="bg-slate-900 rounded-xl p-4"
            >
                <div class="font-semibold">
                    User{{ i }}
                </div>

                <button
                    class="mt-3 bg-blue-600 px-3 py-2 rounded"
                >
                    Написать
                </button>
            </div>

        </div>

    </MainLayout>
</template>

<script setup>
import MainLayout from '../layouts/MainLayout.vue'
</script>