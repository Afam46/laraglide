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

            <GlobalChat/>
           
            <HomeRightCol/>

        </div>

    </MainLayout>
</template>

<script setup>

import MainLayout from '../layouts/MainLayout.vue'
import HomeRightCol from '../layouts/home/HomeRightCol.vue';
import GlobalChat from '../layouts/home/GlobalChat.vue';

</script>