<template>
    <MainLayout>

        <h1 class="text-3xl font-bold mb-6">
            Личные чаты
        </h1>

        <div class="bg-slate-900 rounded-xl p-4">

            <div
                v-for="i in 8"
                :key="i"
                class="border-b border-slate-800 py-4"
            >
                Диалог с User{{ i }}
            </div>

        </div>

    </MainLayout>
</template>

<script setup>
import MainLayout from '../layouts/MainLayout.vue'
</script>