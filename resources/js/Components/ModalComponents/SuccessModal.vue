<script setup>
import { XMarkIcon,CheckCircleIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    successMessage:String
})


</script>


<template>
    <div class="fixed bottom-2 right-2 flex justify-between w-80 bg-[#CEFDDE] px-3 py-2 rounded-xl">
        <span class="flex gap-2 align-center text-[#03A01C]"><CheckCircleIcon class="w-5"/>{{successMessage}}</span>
        <XMarkIcon class="w-5 text-custom-gray-text cursor-pointer" @click="$emit('closeModal')"/>
    </div>
</template>
