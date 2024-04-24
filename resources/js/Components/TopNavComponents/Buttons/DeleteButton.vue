<script setup>
import { TrashIcon } from '@heroicons/vue/24/outline';
import { emitter } from '@/EventBus';



</script>


<template>
    <button @click="emitter.emit('openDeleteFilesModal')" class="flex gap-1.5 cursor-pointer items-center text-custom-black-text hover:text-custom-gray-text transition-colors">
        <TrashIcon class="w-[1.125rem] text-custom-gray-icons"/>
        <span class="text-sm">Delete</span>
    </button>


</template>
