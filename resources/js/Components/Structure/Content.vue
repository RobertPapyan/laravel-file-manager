<script setup>
import { onMounted } from 'vue';
import TableFolder from '@/Components/TableComponents/TableFolder.vue'
import TableFile from '@/Components/TableComponents/TableFile.vue'
import TableHead from '@/Components/TableComponents/TableHead.vue'
import { emitter } from '@/EventBus';
import { watch } from 'vue';
import { ref } from 'vue';
const props = defineProps({
    files:Array,
    folders:Array,
    disks:Object
})
const cardsView = ref(false);

emitter.on('changeView',()=>{cardsView.value = !cardsView.value})

let shiftClick = false;



const selectedItems = defineModel();
const showItemsPath = defineModel('showItemsPath');

function selectSingle(item,type){
    if(shiftClick){shiftClick = false; return}
    selectedItems.value.splice(0, selectedItems.value.length)
    selectedItems.value.push({path:item,type:type})
}
function selectMultiple (item,type){
    if(!selectedItems.value.length)return

    selectedItems.value.splice(1, selectedItems.value.length-1)
    const allFiles = [...props.folders,...props.files]
    const lastFolder = props.folders.length-1;
    let hasMatch = false;

    for(let i = 0; i<allFiles.length;i++){
        if(allFiles[i].path === item || allFiles[i].path === selectedItems.value[0].path){
            if(hasMatch && selectedItems.value[0].path != allFiles[i].path){
                i>lastFolder ? selectedItems.value.push({path:allFiles[i].path,type:'file'}) :selectedItems.value.push({path:allFiles[i].path,type:'dir'})
            }
            hasMatch = !hasMatch
        }
        if(hasMatch && allFiles[i].path !== selectedItems.value[0].path) i>lastFolder ? selectedItems.value.push({path:allFiles[i].path,type:'file'}) :selectedItems.value.push({path:allFiles[i].path,type:'dir'}) ;
    }
    shiftClick = true;
}
function isSelected(path,type){
    for(let i = 0; i<selectedItems.value.length;i++){
        if(selectedItems.value[i].path === path && selectedItems.value[i].type === type)return true
    }
    return false
}
</script>


<template>
    <div class="flex-grow h-full overflow-y-auto">
       <!-- <Disks :disks="disks"/>-->
        <table class="w-full" v-if="!cardsView">
            <TableHead  :showPath="showItemsPath"/>
            <TableFolder v-for="folder in folders" :key="folder.path"
            :folder="folder" :selected="isSelected(folder.path,'dir')" :showPath="showItemsPath" :cardView ="cardsView"
            @click.shift="selectMultiple(folder.path,'dir')"
            @click="selectSingle(folder.path,'dir')"
            @dblclick="emitter.emit('openFolder',folder)"
            @openParentFolder="emitter.emit('openFolder',{path:folder.dirname})"
            />
            <TableFile v-for="file in files" :key="file.path"
            :file="file" :selected="isSelected(file.path,'file')" :showPath="showItemsPath" :cardView ="cardsView"
            @click.shift="selectMultiple(file.path,'file')"
            @click="selectSingle(file.path,'file')"
            @open-parent-folder="emitter.emit('openFolder',{path:folder.dirname})"
            />
        </table>
        <div v-else class="grid grid-cols-4 gap-4 p-2">
            <TableFolder v-for="folder in folders" :key="folder.path"
            :folder="folder" :selected="isSelected(folder.path,'dir')" :showPath="showItemsPath" :cardView ="cardsView"
            @click.shift="selectMultiple(folder.path,'dir')"
            @click="selectSingle(folder.path,'dir')"
            @dblclick="emitter.emit('openFolder',folder)"
            @openParentFolder="emitter.emit('openFolder',{path:folder.dirname})"
            />
            <TableFile v-for="file in files" :key="file.path"
            :file="file" :selected="isSelected(file.path,'file')" :showPath="showItemsPath" :cardView ="cardsView"
            @click.shift="selectMultiple(file.path,'file')"
            @click="selectSingle(file.path,'file')"
            @open-parent-folder="emitter.emit('openFolder',{path:folder.dirname})"
            />
        </div>
    </div>
</template>
