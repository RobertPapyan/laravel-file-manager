<script setup>
import { onMounted } from 'vue';
import TableFolder from '@/Components/TableComponents/TableFolder.vue'
import TableFile from '@/Components/TableComponents/TableFile.vue'
import TableHead from '@/Components/TableComponents/TableHead.vue'
import ContextMenu from '@/Components/ModalComponents/ContextMenu.vue'
import { emitter } from '@/EventBus';
import { watch } from 'vue';
import { ref } from 'vue';
const props = defineProps({
    files:Array,
    folders:Array,
    disks:Object
})
const cardsView = ref(false);
const showContextMenu = ref(false);
const posX = ref(0);
const posY = ref(0);
document.body.addEventListener('click', ()=>{showContextMenu.value = false}, true);
watch(showContextMenu,(newValue)=>{
    if(!newValue)return;

})
emitter.on('changeView',()=>{cardsView.value = !cardsView.value})

let shiftClick = false;


const selectedItems = defineModel();
const showItemsPath = defineModel('showItemsPath');
function openContextMenu(event,item){
    showContextMenu.value = true;
    if(!showContextMenu.value)return;
    posX.value = event.pageX;
    posY.value = event.pageY;
     if(selectedItems.value.length === 1){
        selectedItems.value.pop();
    }else if(selectedItems.value.length != 0){
        let inList = false;
        selectedItems.value.map((i)=>{
            if(i.path === item.path && i.type === item.type)inList = true
        })
        if(!inList) {
            selectedItems.value.splice(0, selectedItems.value.length)
        }
    }
    selectedItems.value.push({path:item.path,type:item.type})

}
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
    <ContextMenu :posX="posX" :posY="posY" v-model="showContextMenu"/>
    <div class="flex-grow h-full overflow-y-auto">
       <!-- <Disks :disks="disks"/>-->
        <table class="w-full" v-if="!cardsView">
            <TableHead  :showPath="showItemsPath"/>
            <TableFolder v-for="folder in folders" :key="folder.path"
            :folder="folder" :selected="isSelected(folder.path,'dir')" :showPath="showItemsPath" :cardView ="cardsView"
            @click.shift="selectMultiple(folder.path,'dir')"
            @click.stop="selectSingle(folder.path,'dir')"
            @contextmenu.prevent="(event)=>{openContextMenu(event,{path:folder.path,type:'dir'})}"
            @dblclick="emitter.emit('openFolder',folder)"
            @openParentFolder="emitter.emit('openFolder',{path:folder.dirname})"
            />
            <TableFile v-for="file in files" :key="file.path"
            :file="file" :selected="isSelected(file.path,'file')" :showPath="showItemsPath" :cardView ="cardsView"
            @click.shift="selectMultiple(file.path,'file')"
            @click.stop="selectSingle(file.path,'file')"
            @contextmenu.prevent="(event)=>{openContextMenu(event,{path:file.path,type:'file'})}"
            @open-parent-folder="emitter.emit('openFolder',{path:folder.dirname})"
            />
        </table>
        <div v-else class="grid grid-cols-4 gap-4 p-2">
            <TableFolder v-for="folder in folders" :key="folder.path"
            :folder="folder" :selected="isSelected(folder.path,'dir')" :showPath="showItemsPath" :cardView ="cardsView"
            @click.shift="selectMultiple(folder.path,'dir')"
            @click.stop="selectSingle(folder.path,'dir')"
            @contextmenu.prevent="(event)=>{openContextMenu(event,{path:folder.path,type:'dir'})}"
            @dblclick="emitter.emit('openFolder',folder)"
            @openParentFolder="emitter.emit('openFolder',{path:folder.dirname})"
            />
            <TableFile v-for="file in files" :key="file.path"
            :file="file" :selected="isSelected(file.path,'file')" :showPath="showItemsPath" :cardView ="cardsView"
            @click.shift="selectMultiple(file.path,'file')"
            @click.stop="selectSingle(file.path,'file')"
            @contextmenu.prevent="(event)=>{openContextMenu(event,{path:file.path,type:'file'})}"
            @open-parent-folder="emitter.emit('openFolder',{path:folder.dirname})"
            />
        </div>
    </div>
</template>
