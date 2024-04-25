<script setup>
import {getFileDate} from '@/Helper/getFileDate'
import {getFileSize} from '@/Helper/getFileSize'
import {getFileType} from '@/Helper/getFileType'
import FileIcon from '@/Components/TableComponents/FileIcon.vue'
const props = defineProps({
    file:Object,
    selected:Boolean,
    showPath:Boolean,
    cardView:Boolean
})

const model = defineModel()
defineEmits(['openParentFolder'])
</script>


<template>
    <tr v-if="!cardView" ref="model" class="border-t border-t-1 border-custom-blue-light hover:bg-custom-gray-bg cursor-pointer select-none" :class="selected? 'bg-custom-gray-bg':''">
        <td class="flex gap-3 px-[0.625rem] py-2 text-custom-black-text"><FileIcon :extension="file.extension" :cardView="cardView"/>{{ file.basename }}</td>
        <td class="px-[0.625rem] py-2 text-custom-gray-text"  v-show="showPath"><span @click="$emit('openParentFolder')">{{file.dirname}}</span></td>
        <td class="px-[0.625rem] py-2 text-custom-gray-text">{{getFileDate(file.timestamp)}}</td>
        <td class="px-[0.625rem] py-2 text-custom-gray-text">{{ getFileType(file.extension) }}</td>
        <td class="pr-4 py-2 text-custom-gray-text text-end">{{ getFileSize(file.size)}}</td>
    </tr>
    <div v-else ref="model" class="flex flex-col p-4 cursor-pointer hover:bg-custom-gray-bg rounded-2xl select-none transition-colors" :class="selected?' bg-custom-gray-bg':''">
        <FileIcon :extension="file.extension" :cardView="cardView"/>
        <span class="font-normal text-custom-gray-text">Folder Name: {{ file.basename }}</span>
        <span class="font-normal text-custom-gray-text">{{ getFileType(file.extension) }} : {{file.extension}}</span>
        <span class="font-normal text-custom-gray-text">{{getFileDate(file.timestamp)}}</span>
    </div>

</template>
