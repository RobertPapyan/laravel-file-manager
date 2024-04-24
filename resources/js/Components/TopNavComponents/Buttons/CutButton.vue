<script setup>
import { ScissorsIcon } from '@heroicons/vue/24/outline';
import { emitter } from '@/EventBus';
import { inject } from 'vue';
const selectedItems = inject('selectedItems')

</script>


<template>
    <button v-if="selectedItems.length" @click.stop="emitter.emit('cutFiles')" class="flex gap-1.5 cursor-pointer items-center text-custom-black-text hover:text-custom-gray-text transition-colors">
        <ScissorsIcon class="w-[1.125rem] text-custom-gray-icons"/>
        <span class="text-sm">Cut</span>
    </button>
    <button v-else  class="flex gap-1.5 cursor-default items-center text-custom-gray-icons-light">
        <ScissorsIcon class="w-[1.125rem] text-custom-gray-icons-light"/>
        <span class="text-sm">Cut</span>
    </button>


</template>
