<script setup>
import { TrashIcon } from '@heroicons/vue/24/outline';
import { emitter } from '@/EventBus';
defineProps({
    red:Boolean
})


</script>


<template>
    <button @click.stop="emitter.emit('openDeleteFilesModal')"
    class="flex gap-1.5 cursor-pointer items-center   transition-colors"
    :class="red?'text-custom-red-main hover:text-[#FF557D]':'text-custom-black-text hover:text-custom-gray-text'"
    >
        <TrashIcon class="w-[1.125rem]" :class="red?'':'text-custom-gray-icons'" />
        <span class="text-sm">Delete</span>
    </button>


</template>
