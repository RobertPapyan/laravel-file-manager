<script setup>
import { ArrowUpTrayIcon } from '@heroicons/vue/24/outline';
import { emitter } from '@/EventBus';



</script>


<template>
    <button @click="emitter.emit('openUploadFilesModal')" class="flex gap-1.5 cursor-pointer items-center text-custom-black-text hover:text-custom-gray-text transition-colors">
        <ArrowUpTrayIcon class="w-5 h-4 text-custom-gray-icons"/>
        <span class="text-sm">Upload</span>
    </button>


</template>
