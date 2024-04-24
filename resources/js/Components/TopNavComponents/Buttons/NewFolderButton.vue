<script setup>
import { FolderPlusIcon } from '@heroicons/vue/24/outline';
import { emitter } from '@/EventBus';



</script>


<template>
    <button @click="emitter.emit('openNewFolderModal')" class="flex gap-1.5 cursor-pointer items-center text-custom-black-text hover:text-custom-gray-text transition-colors">
        <FolderPlusIcon class="w-5 text-custom-gray-icons"/>
        <span class="text-sm">Add Folder</span>
    </button>


</template>
