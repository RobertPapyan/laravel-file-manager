<script setup>
import { inject } from 'vue';
import TopNavButton from '@/Components/TopNavComponents/NavComponents/TopNavButton.vue'
import PathComponent from '@/Components/TopNavComponents/NavComponents/PathComponent.vue'
import SearchComponent from '@/Components/TopNavComponents/NavComponents/SearchComponent.vue'
import { emitter } from '@/EventBus';
import { watch } from 'vue';

const disk = inject('disk');
const currentFolder = inject('currentFolder')
let history = [];
let backMove = false;
let historyIndex = 0;


watch(currentFolder,(newValue)=>{
    if(backMove){
        backMove = false; return;
    }
    if(historyIndex != history.length - 1)history = history.slice(0,historyIndex);
    history.push(newValue);
    historyIndex = history.length - 1;
})

function goBack(){
    backMove = true;
    historyIndex--;
    emitter.emit('openFolder',{path:history[historyIndex]})
}
function goForward(){
    backMove = true;
    historyIndex < history.length - 1? historyIndex++: historyIndex = history.length-1;
    emitter.emit('openFolder',{path:history[historyIndex]})
}
function toParent (){
    let parentPath = currentFolder.value.split('/');
    parentPath.pop();
    parentPath = parentPath.join('/');
    emitter.emit('openFolder',{path:parentPath})
}

emitter.on('changeDisk',()=>{
    history = []
})
</script>


<template>
   <div class="px-4 py-2 flex gap-2 items-center justify-between">
        <div class="flex gap-2 shrink-0">
            <TopNavButton :type="'main'" @click="emitter.emit('goHome')"/>
            <TopNavButton :type="'leftArrow'" @click="goBack"/>
            <TopNavButton :type="'rightArrow'" @click="goForward"/>
            <TopNavButton :type="'topArrow'" @click="toParent"/>
            <TopNavButton :type="'refreshArrow'" @click="emitter.emit('refreshFolder')"/>
        </div>
        <div class="grow self-stretch">
            <PathComponent v-model:disk="disk" v-model:path="currentFolder" @goForward="goForward"/>
        </div>
        <div class="self-stretch flex gap-2">
            <SearchComponent />
            <TopNavButton :type="'changeView'" @click.stop="emitter.emit('changeView')"/>
        </div>
   </div>
</template>
