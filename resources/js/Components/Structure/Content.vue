<script setup>
import TableFolder from '@/Components/TableComponents/TableFolder.vue'
import TableFile from '@/Components/TableComponents/TableFile.vue'
import TableHead from '@/Components/TableComponents/TableHead.vue'
import ContextMenu from '@/Components/ModalComponents/ContextMenu.vue'
import SelectBox from '@/Components/ModalComponents/SelectBox.vue'
import { emitter } from '@/EventBus';
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
const dragStartPosition = ref({x:0,y:0});
const dragEndPosition = ref({x:0,y:0});
const showDragBox = ref(false);
const foldersRefs = ref([]);
const filesRefs = ref([]);
const contentDiv = ref(null);
const emit = defineEmits(['loadMore']);

document.body.addEventListener('click', ()=>{showContextMenu.value = false}, true);
emitter.on('changeView',()=>{cardsView.value = !cardsView.value;})
emitter.on('scrollContentToTop',()=>{
    contentDiv.value.scrollTop = 0;
})
let shiftClick = false;
let dragStarted = false;

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

function startDrag(event){
    dragStarted = true;
    showDragBox.value = true;
    dragStartPosition.value = {
        x:event.pageX,
        y:event.pageY
    }

}
function drag(event){
    dragEndPosition.value = {
        x:event.pageX,
        y:event.pageY
    }
}
function endDrag(event){

    if(!dragStarted) return;
    showDragBox.value = false;
    selectedItems.value.splice(0, selectedItems.value.length)

    foldersRefs.value.map((f,index)=>{
        if(f === null)return;
        const filePosition = f.getBoundingClientRect();
        const cross = rectanglesCross(
        {c1:dragStartPosition.value,c2:dragEndPosition.value},
        {c1:{x:filePosition.x,y:filePosition.y},c2:{x:filePosition.x+filePosition.width,y:filePosition.y+filePosition.height}})
        if(cross){
            selectedItems.value.push({type:'dir',path:props.folders[index].path})
        }
    })
    filesRefs.value.map((f,index)=>{
        if(f === null)return;
        const filePosition = f.getBoundingClientRect();
        const cross = rectanglesCross(
        {c1:dragStartPosition.value,c2:dragEndPosition.value},
        {c1:{x:filePosition.x,y:filePosition.y},c2:{x:filePosition.x+filePosition.width,y:filePosition.y+filePosition.height}})
        if(cross){

            selectedItems.value.push({type:'file',path:props.files[index].path})
        }
    })

    dragStarted = false;

}

function rectanglesCross(rec1, rec2){
    rec1.topEdge = Math.min(rec1.c1.y,rec1.c2.y);
    rec1.bottomEdge = Math.max(rec1.c1.y,rec1.c2.y);
    rec1.leftEdge = Math.min(rec1.c1.x,rec1.c2.x);
    rec1.rightEdge = Math.max(rec1.c1.x,rec1.c2.x);

    rec2.topEdge = Math.min(rec2.c1.y,rec2.c2.y);
    rec2.bottomEdge = Math.max(rec2.c1.y,rec2.c2.y);
    rec2.leftEdge = Math.min(rec2.c1.x,rec2.c2.x);
    rec2.rightEdge = Math.max(rec2.c1.x,rec2.c2.x);
    if(rec1.topEdge > rec2.bottomEdge || rec1.bottomEdge<rec2.topEdge || rec1.rightEdge<rec2.leftEdge || rec1.leftEdge > rec2.rightEdge){
        return false
    }
    return true
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
/*
function resetSelection(){
    if(dragStarted){
        dragStarted = false;
        return;
    }
    selectedItems.value.splice(0, selectedItems.value.length)
}
*/
function handleScroll(event){

    if(event.target.scrollHeight - event.target.clientHeight === event.currentTarget.scrollTop){
        emit('loadMore')
    }
}
window.addEventListener('mouseup', (e)=>{endDrag(e)}, false);
</script>


<template>
    <ContextMenu :posX="posX" :posY="posY" v-model="showContextMenu"/>
    <SelectBox :startPos="dragStartPosition" :endPos="dragEndPosition" v-if="showDragBox"/>
    <div class="flex-grow h-full overflow-y-auto pb-4 select-none" ref="contentDiv"
    @click="resetSelection"
    @mousedown.self="startDrag"
    @mousemove="drag"
    @scroll="handleScroll"
    >
       <!-- <Disks :disks="disks"/>-->
        <table class="w-full" v-if="!cardsView" >
            <TableHead  :showPath="showItemsPath"/>
            <TableFolder v-for="(folder,index) in folders" :key="folder.path" v-model="foldersRefs[index]"
            :folder="folder" :selected="isSelected(folder.path,'dir')" :showPath="showItemsPath" :cardView ="cardsView"
            @click.shift="selectMultiple(folder.path,'dir')"
            @click.stop="selectSingle(folder.path,'dir')"
            @contextmenu.prevent="(event)=>{openContextMenu(event,{path:folder.path,type:'dir'})}"
            @dblclick="emitter.emit('openFolder',folder)"
            @openParentFolder="emitter.emit('openFolder',{path:folder.dirname})"
            />
            <TableFile v-for="(file,index) in files" :key="file.path" v-model="filesRefs[index]"
            :file="file" :selected="isSelected(file.path,'file')" :showPath="showItemsPath" :cardView ="cardsView"
            @click.shift="selectMultiple(file.path,'file')"
            @click.stop="selectSingle(file.path,'file')"
            @contextmenu.prevent="(event)=>{openContextMenu(event,{path:file.path,type:'file'})}"
            @open-parent-folder="emitter.emit('openFolder',{path:folder.dirname})"
            />
        </table>
        <div v-else class="grid grid-cols-5 gap-5 gap-y-10 p-2" @mousedown.self="startDrag">
            <TableFolder v-for="(folder,index) in folders" :key="folder.path" v-model="foldersRefs[index]"
            :folder="folder" :selected="isSelected(folder.path,'dir')" :showPath="showItemsPath" :cardView ="cardsView"
            @click.shift="selectMultiple(folder.path,'dir')"
            @click.stop="selectSingle(folder.path,'dir')"
            @contextmenu.prevent="(event)=>{openContextMenu(event,{path:folder.path,type:'dir'})}"
            @dblclick="emitter.emit('openFolder',folder)"
            @openParentFolder="emitter.emit('openFolder',{path:folder.dirname})"
            />
            <TableFile v-for="(file,index) in files" :key="file.path"   v-model="filesRefs[index]"
            :file="file" :selected="isSelected(file.path,'file')" :showPath="showItemsPath" :cardView ="cardsView"
            @click.shift="selectMultiple(file.path,'file')"
            @click.stop="selectSingle(file.path,'file')"
            @contextmenu.prevent="(event)=>{openContextMenu(event,{path:file.path,type:'file'})}"
            @open-parent-folder="emitter.emit('openFolder',{path:folder.dirname})"
            />
        </div>
    </div>
</template>
