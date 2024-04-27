<script setup>
import { ref } from 'vue';
import { XMarkIcon } from '@heroicons/vue/24/solid';
import { watch } from 'vue';
import { inject } from 'vue';
import InputErrorMessage from '@/Components/ModalComponents/InputErrorMessage.vue'
import axios from 'laravel-file-manager/src/http/axios';
const props = defineProps({
    files:Array
})
const showNewFileModal = defineModel();
const fileName = ref('');
const errorMesage = ref('');
const showError = ref(false);
const disk = inject('disk');
const currentFolder = inject('currentFolder');
const emit = defineEmits(['fileCreated'])

watch(showNewFileModal, (newValue)=>{
   if(!newValue){
        fileName.value = ''
   }
})
watch(fileName,(newValue)=>{
    let hasMatch = false;
    props.files.map((file)=>{
        if(file.filename === newValue){
            hasMatch = true;
        }
    })
    if(hasMatch && !showError.value){
        showError.value = true;
        errorMesage.value = "File exists!"
    }else if(!hasMatch){
        showError.value = false
    }
})

function submitForm(){

    axios.post(route('fm.create-file'),{
         name:fileName.value,
         disk:disk.value,
         path:currentFolder.value,
    }).then((res)=>{
        if(res.data.result.status === 'success'){
            emit('fileCreated')
            showNewFileModal.value = false;
        }else{
            console.log(res.data.result)
            showError.value = true;
            errorMesage.value = 'File exists!'
        }

    })

}

</script>

<template>
    <div v-show="showNewFileModal" @keyup.enter="submitForm" class="fixed border border-custom-gray-light md:w-[32.5rem] top-14 left-[50%] bg-white rounded-xl translate-x-[-50%] shadow-[0_8px_24px_0px_#0000001A]">
        <div class="flex justify-between py-4 px-6 border-b">
            <span class="text-lg font-medium">Create new file</span>
            <XMarkIcon @click.stop="showNewFileModal = false" class="w-6 text-custom-gray-icons cursor-pointer hover:text-custom-gray-text transition-colors"/>
        </div>
        <div class="mx-5 my-6">
            <label for="fileName" class="block mb-2 text-base">File name</label>
            <input v-model="fileName" type="text" name="fileName" placeholder="Type here" id=""
            class="w-full border border-custom-blue-light rounded-xl py-2 px-3 focus:border-custom-blue-light focus:ring-0 placeholder:text-custom-gray-light"
            :class="showError?'border-red-600 focus:border-red-600':''"
            >
            <InputErrorMessage :error-message="errorMesage" v-show="showError"/>
        </div>
        <div class="flex justify-end gap-2  border-t py-4 px-6">

            <button
                @click.stop="showNewFileModal = false"
                class="py-2 px-3 border-custom-gray-borders border rounded-xl font-medium cursor-pointer hover:border-custom-gray-text transition-colors"
                >
                Cancel
            </button>
            <button
                @click.stop="submitForm"
                class="py-2 px-3 border rounded-xl font-medium text-white bg-custom-blue-main cursor-pointer hover:bg-custom-blue-dark transition-colors"
                >
                Submit
            </button>

        </div>
    </div>

</template>
