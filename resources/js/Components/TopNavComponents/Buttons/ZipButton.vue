<script setup>
import { emitter } from '@/EventBus';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {faFileZipper} from '@fortawesome/free-regular-svg-icons'


</script>


<template>
    <button @click="emitter.emit('openZipFilesModal')" class="flex gap-2 cursor-pointer items-center text-custom-black-text hover:text-custom-gray-text transition-colors">
        <FontAwesomeIcon :icon="faFileZipper"  class="text-[1.125      rem] text-custom-gray-text"/>
        <span class="text-sm">Zip</span>
    </button>


</template>
