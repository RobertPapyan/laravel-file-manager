<script setup>
import {FolderIcon} from '@heroicons/vue/24/solid'
import NavOpenArrow from '@/Components/LeftNavComponents/NavOpenArrow.vue'
import { ref } from 'vue';
import { watch } from 'vue';
import { inject } from 'vue';
import {getContent,getTree,getInit} from '@/Helper/getHelpers'
import {emitter} from '@/EventBus'


const props = defineProps({
    dir:Object
})
const isOpen = ref(false);
const tree = ref(Object);
const disk = inject('disk');
const currentFolder = inject('currentFolder')
emitter.on('newFolderCreated',()=>{
    if(props.dir.path == currentFolder.value || props.dir.path == cutLastPath(currentFolder.value)){
    getTree(disk.value,props.dir.path).then(res=>tree.value = res)
    }
})
emitter.on('pasteFiles',()=>{
    if(props.dir.path == currentFolder.value || props.dir.path == cutLastPath(currentFolder.value)){
    getTree(disk.value,props.dir.path).then(res=>tree.value = res)
    }
})

watch (isOpen,(newValue)=>{
    if(newValue){
        getTree(disk.value,props.dir.path).then(res=>tree.value = res)
    }
})
watch(currentFolder, (newValue)=>{
   isOpen.value = includesPath(newValue,props.dir.path);
})

function includesPath(path1, path2){
    if(!path1)return;
   const path1Parts = path1.split('/')
   const path2Parts = path2.split('/')
    for(let i = 0; i<path2Parts.length;i++){
        if(path2Parts[i] != path1Parts[i])return false;
    }
    return true
}
function cutLastPath(path){
    let newPath = path.split('/')
    newPath.pop()
   return newPath.join('/')
}
</script>

<template>
    <li class="flex flex-nowrap gap-1.5 mt-1.5 px-1.5 rounded-md transition-colors" :class="currentFolder == dir.path? 'bg-custom-gray-bg py-1':''">
        <NavOpenArrow v-show="dir.props.hasSubdirectories" @arrowClicked="isOpen = !isOpen" :class="isOpen? 'rotate-90':''" class="transition-all shrink-0"/>
        <span class="w-3" v-show="!dir.props.hasSubdirectories"></span>
        <FolderIcon class="w-5 shrink-0 text-custom-blue-main"/>
       <span class="shrink-0 cursor-pointer hover:text-custom-gray-text transition-colors" @click="emitter.emit('openFolder',dir); isOpen=true">{{ dir.basename }}</span>
    </li>
        <ul v-show="isOpen" class="ml-7 mr-2">
            <NavFolder v-for="dir in tree.directories" :key="dir.basename" :dir="dir"/>
        </ul>
</template>
