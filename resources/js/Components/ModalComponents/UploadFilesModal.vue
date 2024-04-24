<script setup>
import { ref } from 'vue';
import { ArrowUpTrayIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import { watch } from 'vue';
import { inject } from 'vue';
import InputErrorMessage from '@/Components/ModalComponents/InputErrorMessage.vue'
import axios from 'laravel-file-manager/src/http/axios';
import FileIcon from '@/Components/TableComponents/FileIcon.vue';
import { getFileSize } from '@/Helper/getFileSize';


const showUploadFilesModal = defineModel();
const files = ref([]);
const errorMesage = ref('');
const showError = ref(false);
const disk = inject('disk');
const currentFolder = inject('currentFolder');
const emit = defineEmits(['filesUploaded'])
const overWrite = ref(false)


watch(showUploadFilesModal,(newValue)=>{
    if(!newValue)files.value = []
})
function submitForm(){
    if(!files.value.length)return
    let formData = new FormData();
    files.value.map((file)=>formData.append("files[]", file))
    formData.append('disk',disk.value)
    formData.append('path',currentFolder.value)
    formData.append('overwrite',overWrite.value)
    axios.post(route('fm.upload'),formData).then((res)=>{
        if(res.data.result.status === 'success'){
            emit('filesUploaded', files.value.length)
            showUploadFilesModal.value = false;
        }else{
            console.log(res.data.result)
            showError.value = true;
            errorMesage.value = 'Folder exists!'
        }

    })

}
function addFiles(event){
    for(let file in event.target.files){
       if(typeof event.target.files[file] === 'object' && !files.value.includes(event.target.files[file])){
        files.value.push(event.target.files[file])
       }
    }

}

</script>

<template>
    <div v-show="showUploadFilesModal" class="fixed border border-custom-gray-light md:w-[32.5rem] top-14 left-[50%] bg-white rounded-xl translate-x-[-50%] shadow-[0_8px_24px_0px_#0000001A]">
        <div class="flex justify-between py-4 px-6 border-b">
            <span class="text-lg font-medium">Upload files</span>
            <XMarkIcon @click.stop="showUploadFilesModal = false" class="w-6 text-custom-gray-icons cursor-pointer hover:text-custom-gray-text transition-colors"/>
        </div>


        <div class="mx-5 my-6 flex flex-col justify-center items-center gap-4">
            <ArrowUpTrayIcon class="w-12 text-custom-gray-text"/>
            <label for="fileInput">
                <div class="bg-gradient-to-b from-stone-50 to-gray-100 inline-block text-custom-black-text border  px-3 py-2 font-medium rounded-xl hover:bg-gradient-to-b hover:from-stone-50 hover:to-gray-200 transition-all cursor-pointer">Select Files</div>
            </label>
            <input @change="addFiles" type="file" name="fileInput"  id="fileInput" class="hidden" multiple>
            <InputErrorMessage :error-message="errorMesage" v-show="showError"/>
            <ul v-if="files.length" class="my-4 flex flex-col gap-2">
                <li v-for="file in files" class="flex justify-between">
                     <span class="flex gap-2"><FileIcon :extension="file.name.split('.').pop()"/>{{file.name }}</span>
                     <span>{{ getFileSize(file.size) }}</span>
                </li>
            </ul>
        </div>


        <div class="flex justify-between  border-t py-4 px-6">
            <div class="mt-2 flex gap-2 items-center">
                <label for="overWrite">Overwrite if match:</label>
                <input v-model="overWrite" type="checkbox" id="overWrite" name="overWrite" class="focus:ring-0 color- rounded-sm checked:bg-custom-black-text :checked:focus:col-custom-black-text checked:hover:bg-custom-black-text" style="color: black;">
            </div>
            <div class="flex gap-2">
            <button
                @click.stop="showUploadFilesModal = false"
                class="py-2 px-3 border-custom-gray-borders border rounded-xl font-medium cursor-pointer hover:border-custom-gray-text transition-colors">
                Cancel
            </button>
            <button
                @click.stop="submitForm"
                class="py-2 px-3 border rounded-xl font-medium text-white bg-custom-blue-main cursor-pointer hover:bg-custom-blue-dark transition-colors">
                Submit
            </button>
            </div>
        </div>

    </div>

</template>
