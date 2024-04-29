<script setup>

import { onMounted } from 'vue';
import { ref } from 'vue';
import FileManagerLayout from '@/Layouts/FileManagerLayout.vue'
import Content from '@/Components/Structure/Content.vue'
import {getContent,getTree,getInit,getSearch} from '@/Helper/getHelpers'
import { provide } from 'vue';
import {emitter} from '@/EventBus'
import NewFileModal from '@/Components/ModalComponents/NewFileModal.vue'
import NewFolderModal from '@/Components/ModalComponents/NewFolderModal.vue'
import UploadFilesModal from '@/Components/ModalComponents/UploadFilesModal.vue'
import RenameFilesModal from '@/Components/ModalComponents/RenameFilesModal.vue'
import DeleteFilesModal from '@/Components/ModalComponents/DeleteFilesModal.vue'
import ZipFilesModal from '@/Components/ModalComponents/ZipFilesModal.vue'
import SuccessModal from '@/Components/ModalComponents/SuccessModal.vue'
import ErrorModal from '@/Components/ModalComponents/ErrorModal.vue'
import axios from 'laravel-file-manager/src/http/axios';
import { watch } from 'vue';


const content = ref(Object);
const tree = ref(Object);
const init = ref(Object);
const disk = ref('');
const diskList = ref(Array);
const currentFolder = ref('');
const currentChunk = ref(0);
const showNewFileModal = ref(false);
const showNewFolderModal = ref(false);
const showUploadFilesModal = ref(false);
const showRenameFilesModal = ref(false);
const showDeleteFilesModal = ref(false);
const showZipFilesModal = ref(false);
const showSuccessModal = ref(false);
const showErrorModal = ref(false);
const showItemsPath = ref(false);
const successMessage = ref('');
const errorMessage = ref('');
const selectedItems = ref([]);
const searchValue = ref('');
const clipBoard = {
    directories:[],
    files:[],
    disk:'',
    type:''
}
let loadSearch = false;

const showArray = [showNewFileModal,showNewFolderModal,showUploadFilesModal,showRenameFilesModal,showDeleteFilesModal,showZipFilesModal]

onMounted(()=>{
    getInit().then((res)=>{init.value = res; disk.value = Object.keys(res.config.disks)[0];diskList.value = res.config.disks }).then(()=>{
    getContent(disk.value).then((res)=>{content.value = res; currentChunk.value = content.value.chunk})
    getTree(disk.value).then(res=>tree.value = res)
})
})
emitter.on('*', (type, e) => eventsHandler(type,e))
function eventsHandler(event,data){
    switch (event){
        case 'openNewFileModal':{
            showArray.map((item,index)=>{
            item.value = false;
            if(index == 0 ) item.value = true;
             })
             break;
            }
        case 'openFolder' :{
            emitter.emit('scrollContentToTop')
            getContent(disk.value, data.path,0).then((res)=>{content.value = res; currentChunk.value = res.chunk})
            currentFolder.value = data.path;
            selectedItems.value = [];
            showItemsPath.value = false;
            loadSearch = false;
            break;
        }
        case 'openNewFolderModal':{
            showArray.map((item,index)=>{
            item.value = false;
            if(index == 1 ) item.value = true;
             })
             break;
        }
        case 'openUploadFilesModal':{
            showArray.map((item,index)=>{
            item.value = false;
            if(index == 2 ) item.value = true;
            })
            break;
        }
        case 'openRenameFilesModal' :{
            if (!selectedItems.value.length) {
                showError('Select file to rename')
                return
            }
            showArray.map((item, index) => {
                item.value = false;
                if (index == 3) item.value = true;
            })
            break;
        }
        case 'openDeleteFilesModal': {
            if (!selectedItems.value.length) {
                showError('No files selected')
                return
            }
            showArray.map((item, index) => {
                item.value = false;
                if (index == 4) item.value = true;
            })
            break;
        }
        case 'openZipFilesModal' : {
            if (!selectedItems.value.length) {
                showError('No files selected')
                return
            }
            showArray.map((item, index) => {
                item.value = false;
                if (index == 5) item.value = true;
            })
            break;
        }
        case 'unzipFiles' : {
            let path
            selectedItems.value.some((item) => {
                if (item.path.split('/').pop().split('.').pop() === 'zip') {
                    path = item.path;
                    return true;
                }
            })
            axios.post(route('fm.unzip'), {
                disk: disk.value,
                path: path,
                folder: null
            }).then((res) => {
                if (res.data.result.status === 'success') {
                    showSuccess('Folder unzipped successfully');
                    refreshContent();
                    refreshTree();
                    emitter.emit('newFolderCreated')
                    selectedItems.value = []
                } else {
                    console.log(res.data.result)
                    showError.value = true;
                    errorMessage.value = 'Something went wrong!'
                }

            })
            break;
        }
        case 'copyFiles':{
            if (!selectedItems.value.length) {
                showError('No files selected')
                return
            }
            clipBoard.directories = []
            clipBoard.files = []
            selectedItems.value.map((item) => {
                item.type === 'dir' ? clipBoard.directories.push(item.path) : clipBoard.files.push(item.path)
            })
            clipBoard.disk = disk.value;
            clipBoard.type = 'copy'
            showSuccess(`${selectedItems.value.length} items copied to clipboard`)
            selectedItems.value = []
            break;
        }
        case 'cutFiles':{
            if (!selectedItems.value.length) {
                showError('No files selected')
                return
            }
            clipBoard.directories = []
            clipBoard.files = []
            selectedItems.value.map((item) => {
                item.type === 'dir' ? clipBoard.directories.push(item.path) : clipBoard.files.push(item.path)
            })
            clipBoard.disk = disk.value;
            clipBoard.type = 'cut'
            showSuccess(`${selectedItems.value.length} items copied to clipboard`)
            selectedItems.value = []
            break;
        }
        case 'pasteFiles':{

            if(!clipBoard.directories.length && !clipBoard.files.length){
                    showError('Clipboard is empty!')
                    return;
            }
            axios.post(route('fm.paste'), {
                clipboard: clipBoard,
                disk: disk.value,
                path: currentFolder.value,
            }).then((res) => {
                if (res.data.result.status === 'success') {
                    showSuccess('Files pasted successfully');
                    refreshContent();
                } else {
                    showError('Something went wrong ... ')
                }

            })

            break;
        }
        case 'downloadFiles':{
            if (!selectedItems.value.length) {
                showError('No files selected')
                return
            }

            selectedItems.value.forEach((item) => {
                if (item.type != 'dir') {
                    const a = document.createElement('a');
                    a.download = item.path.split('/').pop();
                    a.href = route('fm.download') + `?disk=${disk.value}` + `&path=${item.path}`;
                    a.click();
                }
            })
            break;
        }
        case 'changeDisk':{
            emitter.emit('scrollContentToTop')
            axios.get(route('fm.select-disk')+`?disk=${data}`).then((res)=>{
                if (res.data.result.status === 'success') {
                    showSuccess('Disk changed successfully');
                    disk.value = data;
                    currentFolder.value = '';
                    selectedItems.value = [];
                    showItemsPath.value = false;
                    loadSearch = false;
                    refreshContent();
                    refreshTree();
                } else {
                    showError.value = true;
                    errorMessage.value = 'Something went wrong...'
                }
            })
        }
        case 'goHome':{
            emitter.emit('scrollContentToTop')
            currentFolder.value = '';
            selectedItems.value = [];
            showItemsPath.value = false;
            loadSearch = false;
            refreshContent();
            break;
        }
        case 'refreshFolder':{
            emitter.emit('scrollContentToTop')
            refreshContent();
            selectedItems.value = [];
            showItemsPath.value = false;
            loadSearch = false;
            break;
        }
        case 'makeSearch':{
            emitter.emit('scrollContentToTop')
            if(!searchValue.value){emitter.emit('refreshFolder');return;}

        getSearch(searchValue.value,disk.value,0)
        .then((res)=>{
            content.value = res;
            showItemsPath.value = true;
            loadSearch = true;
            currentChunk.value = res.chunk;
        })
            break;
        }
        case 'resetSelection':{
            selectedItems.value = []
        }
    }
}



function refreshContent(){
    getContent(disk.value,currentFolder.value,0).then((res)=>{content.value = res; currentChunk.value = content.value.chunk});
}
function getMoreContent(){
    if(currentChunk.value === -1) return;
    if(!loadSearch){
        getContent(disk.value,currentFolder.value,++currentChunk.value).then((res)=>{
            content.value.directories = content.value.directories.concat(res.directories);
            content.value.files = content.value.files.concat(res.files);
            content.value.chunk = res.chunk;
            currentChunk.value = res.chunk;
        })
    }else{
        getSearch(searchValue.value,disk.value,++currentChunk.value)
        .then((res)=>{
            content.value.directories = content.value.directories.concat(res.directories);
            content.value.files = content.value.files.concat(res.files);
            showItemsPath.value = true;
            loadSearch = true;
            content.value.chunk = res.chunk;
            currentChunk.value = res.chunk;
        })
    }
}
function refreshTree(){
    getTree(disk.value).then(res=>tree.value = res)
}
let successTimeout = setTimeout(()=>{showSuccessModal.value = false},3000)
function showSuccess(msg){
    successMessage.value = msg
    showSuccessModal.value = true
    clearTimeout(successTimeout)
    successTimeout = setTimeout(()=>{showSuccessModal.value = false},3000)
}
let errorTimeout = setTimeout(()=>{showErrorModal.value = false},3000)
function showError(msg){
    errorMessage.value = msg
    showErrorModal.value = true
    clearTimeout(errorTimeout)
    errorTimeout = setTimeout(()=>{showErrorModal.value = false},3000)
}

provide('disk',disk)
provide('currentFolder',currentFolder)
provide('selectedItems',selectedItems)
provide('diskList',diskList)
provide('searchValue',searchValue)
</script>



<template>
    <FileManagerLayout :directories="tree.directories" :disk="disk" :selectedItems="selectedItems">
        <Content :files="content.files" :folders="content.directories" :disks="init.config?.disks?? {}"
        v-model="selectedItems" v-model:showItemsPath = "showItemsPath" @load-more="getMoreContent"
        />
    </FileManagerLayout>

    <NewFileModal v-model="showNewFileModal" :files="content.files" @file-created="refreshContent();showSuccess('File created successfully')"/>
    <NewFolderModal v-model="showNewFolderModal" :folders="content.directories" @folder-created="refreshContent();refreshTree();showSuccess('Folder created successfully');emitter.emit('newFolderCreated')"/>
    <UploadFilesModal v-model="showUploadFilesModal" @files-uploaded="(num)=>{refreshContent();showSuccess(`${num} Files uploaded successfully`)}"/>

        <RenameFilesModal v-model="showRenameFilesModal" :item = "selectedItems[0]" :files="content.files" :folders="content.directories"
    @item-renamed="(type)=>{refreshContent();refreshTree();showSuccess(`${type} renamed successfully`);if(type === 'Folder'){emitter.emit('newFolderCreated')}}"/>

    <DeleteFilesModal v-model="showDeleteFilesModal" :items="selectedItems" @files-deleted="refreshContent();refreshTree();emitter.emit('newFolderCreated');showSuccess('Files deleted successfully')" />
    <ZipFilesModal v-model="showZipFilesModal" :items="selectedItems" @files-zipped="refreshContent();showSuccess('Zip created successfully')" />

    <SuccessModal v-show="showSuccessModal" :successMessage="successMessage" @close-modal="showSuccessModal = false"/>
    <ErrorModal v-show="showErrorModal" :errorMessage="errorMessage" @close-modal="showErrorModal = false"/>

</template>
