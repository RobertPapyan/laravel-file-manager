<script setup>
import {  TrashIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { inject } from 'vue';
import axios from 'laravel-file-manager/src/http/axios';
import FileIcon from '@/Components/TableComponents/FileIcon.vue';
import { FolderIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    items:Array
})

const showDeleteFilesModal = defineModel();
const disk = inject('disk');
const currentFolder = inject('currentFolder');
const emit = defineEmits(['filesDeleted'])


function submitForm(){
    axios.post(route('fm.delete'),{
        disk:disk.value,
        items:props.items
    }).then((res)=>{
        if(res.data.result.status === 'success'){
            emit('filesDeleted')
            showDeleteFilesModal.value = false;
        }

    })

}


</script>

<template>
    <div v-show="showDeleteFilesModal" @keyup.enter="submitForm" class="fixed border border-custom-gray-light md:w-[32.5rem] top-14 left-[50%] bg-white rounded-xl translate-x-[-50%] shadow-[0_8px_24px_0px_#0000001A]">
        <div class="flex justify-between py-4 px-6 border-b">
            <span class="text-lg font-medium">Upload files</span>
            <XMarkIcon @click="showDeleteFilesModal = false" class="w-6 text-custom-gray-icons cursor-pointer hover:text-custom-gray-text transition-colors"/>
        </div>

        <div class="mx-5 my-6 flex flex-col justify-center items-center gap-4">
            <div class=" w-20 h-20 rounded-full bg-[#FFD8E1] flex items-center justify-center">
                <TrashIcon class="w-12 text-[#F32051]"/>
            </div>
            <span class="text-custom-black-text text-lg font-bold">Remove {{items.length}} {{items.length == 1? 'item': 'items'}}? </span>
            <ul  class="my-4 flex flex-col gap-2">
                <li v-for="item in items" class="flex justify-between">

                     <span class="flex gap-2">
                        <FileIcon v-if="item.type ==='file'" :extension="item.path.split('/').pop().split('.').pop()"/>
                        <FolderIcon v-if="item.type === 'dir'" class="w-[1.375rem] text-custom-gray-icons-light"/>
                        {{item.path.split('/').pop() }}
                    </span>
                </li>
            </ul>
        </div>


        <div class="flex justify-end gap-2  border-t py-4 px-6">
            <button
                @click="showDeleteFilesModal = false"
                class="py-2 px-3 border-custom-gray-borders border rounded-xl font-medium cursor-pointer hover:border-custom-gray-text transition-colors">
                Cancel
            </button>
            <button
                @click="submitForm"
                class="py-2 px-3 border rounded-xl font-medium text-white bg-[#F32051] cursor-pointer hover:bg-[#FF2457] transition-colors">
                Delete
            </button>
        </div>

    </div>

</template>
