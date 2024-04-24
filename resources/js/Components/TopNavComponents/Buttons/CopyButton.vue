<script setup>
import { DocumentDuplicateIcon } from '@heroicons/vue/24/outline';
import { emitter } from '@/EventBus';
import { inject } from 'vue';

const selectedItems = inject('selectedItems')


</script>


<template>
    <button v-if="selectedItems.length" @click.stop="emitter.emit('copyFiles')" class="flex gap-1.5 cursor-pointer items-center text-custom-black-text hover:text-custom-gray-text transition-colors">
        <DocumentDuplicateIcon class="w-[1.125rem] text-custom-gray-icons"/>
        <span class="text-sm">Copy</span>
    </button>
    <button v-else class="flex gap-1.5 cursor-default items-center text-custom-gray-icons-light transition-colors">
        <DocumentDuplicateIcon class="w-[1.125rem] text-custom-gray-icons-light"/>
        <span class="text-sm">Copy</span>
    </button>
</template>
