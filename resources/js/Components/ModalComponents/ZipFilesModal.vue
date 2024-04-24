<script setup>
import {  TrashIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {faFileZipper} from '@fortawesome/free-solid-svg-icons'
import { inject } from 'vue';
import axios from 'laravel-file-manager/src/http/axios';
import FileIcon from '@/Components/TableComponents/FileIcon.vue';
import { FolderIcon } from '@heroicons/vue/24/solid';
import InputErrorMessage from '@/Components/ModalComponents/InputErrorMessage.vue'
import { ref } from 'vue';
import { watch } from 'vue';

const props = defineProps({
    items:Array
})

const showZipFilesModal = defineModel();
const disk = inject('disk');
const currentFolder = inject('currentFolder');
const emit = defineEmits(['filesDeleted'])
const archiveName = ref('')
const errorMesage = ref('');
const showError = ref(false);

watch(archiveName,(newValue)=>{
    showError.value = false
})

function submitForm(){
    if(!archiveName.value){
        errorMesage.value = 'Archive name is empty'
        showError.value = true;
        return
    }
    let elements = {
        directories:[],
        files:[]
    }
    props.items.map((item)=>{
        if(item.type == 'file'){
            elements.files.push(item.path)
        }else{
            elements.directories.push(item.path)
        }
    })
    console.log(elements)
    axios.post(route('fm.zip'),{
        disk:disk.value,
        path:currentFolder.value,
        elements:elements,
        name:archiveName.value + '.zip'
    }).then((res)=>{
        if(res.data.result.status === 'success'){
            emit('filesZipped')
            showZipFilesModal.value = false;
        }
    })


}


</script>

<template>
    <div v-show="showZipFilesModal"
        class="fixed border border-custom-gray-light md:w-[32.5rem] top-14 left-[50%] bg-white rounded-xl translate-x-[-50%] shadow-[0_8px_24px_0px_#0000001A]">
        <div class="flex justify-between py-4 px-6 border-b">
            <span class="text-lg font-medium">Upload files</span>
            <XMarkIcon @click.stop="showZipFilesModal = false"
                class="w-6 text-custom-gray-icons cursor-pointer hover:text-custom-gray-text transition-colors" />
        </div>

        <div class="mx-5 my-6 flex flex-col justify-center items-center gap-4">

            <FontAwesomeIcon :icon="faFileZipper" class="text-[3rem] text-custom-gray-text" />
            {{ items }}
            <div class="mx-5 my-6 w-full">
                <label for="fileName" class="block mb-2 text-base">Archive name</label>
                <input v-model="archiveName" type="text" name="fileName" placeholder="Type here" id=""
                    class="w-full border border-custom-blue-light rounded-xl py-2 px-3 focus:border-custom-blue-light focus:ring-0 placeholder:text-custom-gray-light"
                    :class="showError?'border-red-600 focus:border-red-600':''"
            >
            <InputErrorMessage :error-message="errorMesage" v-show="showError"/>
            </div>
            <ul class="my-4 flex flex-col gap-2 w-full">
                <li v-for="item in items" class="flex justify-between">
                    <span class="flex gap-2">
                        <FileIcon v-if="item.type ==='file'" :extension="item.path.split('/').pop().split('.').pop()" />
                        <FolderIcon v-if="item.type === 'dir'" class="w-[1.375rem] text-custom-gray-icons-light" />
                        {{item.path.split('/').pop() }}
                    </span>
                </li>
            </ul>
        </div>


        <div class="flex justify-end gap-2  border-t py-4 px-6">
            <button @click.stop="showZipFilesModal = false"
                class="py-2 px-3 border-custom-gray-borders border rounded-xl font-medium cursor-pointer hover:border-custom-gray-text transition-colors">
                Cancel
            </button>
            <button @click.stop="submitForm"
                class="py-2 px-3 border rounded-xl font-medium text-white bg-custom-blue-main cursor-pointer hover:bg-custom-blue-dark transition-colors">
                Submit
            </button>
        </div>

    </div>

</template>
