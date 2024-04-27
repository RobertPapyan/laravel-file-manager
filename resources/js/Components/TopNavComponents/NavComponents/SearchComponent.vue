<script setup>
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid';
import {emitter} from '@/EventBus';
import { inject } from 'vue';
import { ref } from 'vue';
import { onMounted } from 'vue';

const searchValue = inject('searchValue')
const input = ref(null);
onMounted(()=>{
    input.value.focus()
})
</script>


<template>
    <div class="border border-custom-blue-light px-2  rounded-md flex gap-2" @click="emitter.emit('resetSelection')">
        <MagnifyingGlassIcon class="w-[1.2rem] text-custom-gray-text"/>
    <input type="text" ref="input" v-model="searchValue" @keyup.enter="emitter.emit('makeSearch')" class="border-none p-0 placeholder:text-custom-gray-icons-light focus:border-none focus:outline-0 focus:ring-0 bg-none" placeholder="Search">
    </div>
</template>
