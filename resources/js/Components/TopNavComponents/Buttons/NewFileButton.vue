<script setup>
import { DocumentPlusIcon } from '@heroicons/vue/24/outline';
import { emitter } from '@/EventBus';

</script>


<template>
    <button @click="emitter.emit('openNewFileModal')" class="flex gap-1.5 cursor-pointer items-center text-custom-black-text hover:text-custom-gray-text transition-colors">
        <DocumentPlusIcon class="w-5 text-custom-gray-icons"/>
        <span class="text-sm">Add File</span>
    </button>


</template>
