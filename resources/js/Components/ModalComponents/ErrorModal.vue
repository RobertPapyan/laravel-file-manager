<script setup>
import { XMarkIcon,CheckCircleIcon, ExclamationCircleIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    errorMessage:String
})


</script>


<template>
    <div class="fixed bottom-2 right-2 flex justify-between w-80 bg-[#F32051] px-3 py-2 rounded-xl">
        <span class="flex gap-2 align-center text-white"><ExclamationCircleIcon class="w-5"/>{{errorMessage}}</span>
        <XMarkIcon class="w-5 text-white cursor-pointer" @click="$emit('closeModal')"/>
    </div>
</template>
