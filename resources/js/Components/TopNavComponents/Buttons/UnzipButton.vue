<script setup>
import { emitter } from '@/EventBus';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {faFileZipper} from '@fortawesome/free-regular-svg-icons'

import { inject } from 'vue';
import { watch } from 'vue';
const selectedItems = inject('selectedItems')

function includesZip (items){
    for(let i = 0 ; i<items.length; i++){
        if(items[i].path.split('/').pop().split('.').pop() === 'zip') return true
    }
    return false
}
</script>


<template>

    <button v-if="includesZip(selectedItems)" @click.stop="emitter.emit('unzipFiles')" class="flex gap-2 cursor-pointer items-center text-custom-black-text hover:text-custom-gray-text transition-colors">
        <FontAwesomeIcon :icon="faFileZipper"  class="text-[1.125rem] text-custom-gray-text"/>
        <span class="text-sm">Unzip</span>
    </button>
    <button v-else class="flex gap-2 cursor-default items-center text-custom-black-text hover:text-custom-gray-text transition-colors">
        <FontAwesomeIcon :icon="faFileZipper"  class="text-[1.125rem] text-custom-gray-icons-light"/>
        <span class="text-sm text-custom-gray-icons-light">Unzip</span>
    </button>


</template>
