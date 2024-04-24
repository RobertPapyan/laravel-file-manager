<script setup>
import {PhotoIcon} from '@heroicons/vue/24/solid';
import {DocumentIcon} from '@heroicons/vue/24/solid';
import {DocumentTextIcon} from '@heroicons/vue/24/solid';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {faFileZipper} from '@fortawesome/free-solid-svg-icons'

const props = defineProps({
    extension:String,
    cardView:Boolean
})


</script>


<template>
    <PhotoIcon v-if="extension =='png' || extension =='jpg'" :class="cardView? 'w-12 self-center text-custom-gray-icons-light mb-4': 'w-[1.375rem] text-custom-gray-icons-light'" />
    <DocumentTextIcon v-else-if="extension == 'txt'" :class="cardView? 'w-12 self-center text-custom-gray-icons-light mb-4': 'w-[1.375rem] text-custom-gray-icons-light'"/>
    <FontAwesomeIcon v-else-if="extension == 'zip'" :icon="faFileZipper" :class="cardView?'text-5xl mb-4 text-custom-gray-icons-light':'text-[1.375rem] ml-1 text-custom-gray-icons-light'" />
    <DocumentIcon v-else :class="cardView? 'w-12 self-center text-custom-gray-icons-light mb-4': 'w-[1.375rem] text-custom-gray-icons-light'"/>
</template>
