<script setup>
import NavFolder from '@/Components/LeftNavComponents/NavFolder.vue'
import SelectDisk from '@/Components/TopNavComponents/SelectDisk.vue'
import { emitter } from '@/EventBus';
import { inject } from 'vue';
const props = defineProps({
    directories:Array,
})


</script>


<template>
    <div class="basis-1/5 p-2 border-solid border-r border-custom-blue-light" @click="emitter.emit('resetSelection')">
    <SelectDisk/>
    <ul class="overflow-auto pb-4">
        <NavFolder v-for="dir in directories" :key="dir.basename" :dir="dir"/>
    </ul>
</div>
</template>
