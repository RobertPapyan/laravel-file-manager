<script setup>
import { ref } from 'vue';
import { XMarkIcon } from '@heroicons/vue/24/solid';
import { watch } from 'vue';
import { inject } from 'vue';
import InputErrorMessage from '@/Components/ModalComponents/InputErrorMessage.vue'
import axios from 'laravel-file-manager/src/http/axios';
import { onMounted } from 'vue';
import { onUpdated } from 'vue';
const props = defineProps({
    item:Object,
    files:Array,
    folders:Array
})
const showRenameFilesModal = defineModel();
const fileName = ref('');
const input = ref(null);
const errorMesage = ref('');
const showError = ref(false);
const disk = inject('disk');
const currentFolder = inject('currentFolder');
const emit = defineEmits(['itemRenamed'])
let oldName;
watch(showRenameFilesModal, (newValue)=>{
   if(!newValue){
        fileName.value = ''
   }else{
     if(props.item.type === 'dir'){
        oldName = props.item.path.split('/').pop()
     }else{
        let arr = props.item.path.split('/');
        oldName = arr[arr.length-1].split('.')[0]
     }
    fileName.value = oldName;
    input.value.focus()
   }

})
watch(fileName,(newValue)=>{
    let hasMatch = false;
    props.files.map((file)=>{
        if(file.filename === newValue && props.item.type === 'file' && oldName!=newValue){
            hasMatch = true;
        }
    })
    props.folders.map((folder)=>{
        if(folder.basename === newValue && props.item.type === 'dir' && oldName!=newValue){
            hasMatch = true
        }
    })

    if(hasMatch && !showError.value){
        showError.value = true;
        errorMesage.value = props.item.type ==='file'?"File exists!":"Folder exists!"
    }else if(!hasMatch){
        showError.value = false
    }
})

function submitForm(){

    axios.post(route('fm.rename'),{
         newName:currentFolder.value + '/' +fileName.value,
         oldName:currentFolder.value + '/' + oldName,
         disk:disk.value,
         type:props.item.type,
    }).then((res)=>{
        if(res.data.result.status === 'success'){
            emit('itemRenamed',props.item.type === 'dir'? "Folder":"File")
            showRenameFilesModal.value = false;
        }else{
            console.log(res.data.result)
            showError.value = true;
            errorMesage.value = 'File exists!'
        }

    })

}
onUpdated(()=>{
    input.value.focus()
})

</script>

<template>
    <div v-show="showRenameFilesModal" @keyup.enter="submitForm" class="fixed border border-custom-gray-light md:w-[32.5rem] top-14 left-[50%] bg-white rounded-xl translate-x-[-50%] shadow-[0_8px_24px_0px_#0000001A]">
        <div class="flex justify-between py-4 px-6 border-b">
            <span class="text-lg font-medium">Rename</span>
            <XMarkIcon @click.stop="showRenameFilesModal = false" class="w-6 text-custom-gray-icons cursor-pointer hover:text-custom-gray-text transition-colors"/>
        </div>
        <div class="mx-5 my-6">
            <label for="fileName" class="block mb-2 text-base">New name</label>
            <input v-model="fileName" ref="input" type="text" name="fileName" placeholder="Type here" id=""
            class="w-full border border-custom-blue-light rounded-xl py-2 px-3 focus:border-custom-blue-light focus:ring-0 placeholder:text-custom-gray-light"
            :class="showError?'border-red-600 focus:border-red-600':''"
            >
            <InputErrorMessage :error-message="errorMesage" v-show="showError"/>
        </div>
        <div class="flex justify-end gap-2  border-t py-4 px-6">

            <button
                @click.stop="showRenameFilesModal = false"
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
