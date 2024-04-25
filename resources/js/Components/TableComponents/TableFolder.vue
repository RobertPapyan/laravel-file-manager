<script setup>
import {getFileDate} from '@/Helper/getFileDate'
import {FolderIcon} from '@heroicons/vue/24/solid'
import { emitter } from '@/EventBus';
const props = defineProps({
    folder:Object,
    selected:Boolean,
    showPath:Boolean,
    cardView:Boolean
})
defineEmits(['openParentFolder'])
const model = defineModel();
</script>


<template>
    <tr v-if="!cardView" ref="model"class="border-t border-t-1 border-custom-blue-light hover:bg-custom-gray-bg cursor-pointer select-none"  :class="selected?'bg-custom-gray-bg':''">
        <td class="flex gap-3 font-normal px-[0.625rem] py-2 text-custom-black-text"><FolderIcon class="w-[1.375rem] text-custom-blue-main"/>{{ folder.basename }}</td>
        <td class="font-normal px-[0.625rem] py-2 text-custom-gray-text hover:underline" v-show="showPath"><span @click="$emit('openParentFolder')">{{folder.dirname}}</span></td>
        <td class="font-normal px-[0.625rem] py-2 text-custom-gray-text" >{{getFileDate(folder.timestamp)}}</td>
        <td class="font-normal px-[0.625rem] py-2 text-custom-gray-text">Folder</td>
        <td class="font-normal px-[0.625rem] py-2 text-custom-gray-text"></td>
    </tr>
    <div v-else ref="model" class="flex flex-col p-4 cursor-pointer hover:bg-custom-gray-bg rounded-2xl select-none transition-colors" :class="selected?' bg-custom-gray-bg':''">
        <FolderIcon class="w-12 text-custom-blue-main self-center mb-4"/>
        <span class="font-normal text-custom-gray-text">Folder Name: {{ folder.basename }}</span>
        <span class="font-normal text-custom-gray-text">Folder</span>
        <span class="font-normal text-custom-gray-text">{{getFileDate(folder.timestamp)}}</span>
    </div>


</template>
