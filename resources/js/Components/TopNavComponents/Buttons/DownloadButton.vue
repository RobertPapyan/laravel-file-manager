<script setup>
import { ArrowDownTrayIcon } from '@heroicons/vue/24/outline';
import { emitter } from '@/EventBus';



</script>


<template>
    <button @click="emitter.emit('downloadFiles')" class="flex gap-1.5 cursor-pointer items-center text-custom-black-text hover:text-custom-gray-text transition-colors">
        <ArrowDownTrayIcon class="w-[1.125rem] text-custom-gray-icons"/>
        <span class="text-sm">Download</span>
    </button>


</template>
