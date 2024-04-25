<script setup>
const props = defineProps({
    startPos:Object,
    endPos: Object
})

function getTop(startPos,endPos){
        return Math.min(startPos.y,endPos.y)
}

function getLeft(startPos,endPos){
       return Math.min(startPos.x,endPos.x)
}

function getWidth(startPos,endPos){
    return Math.abs(startPos.x-endPos.x)
}

function getHeight(startPos,endPos){
    return Math.abs(startPos.y-endPos.y)
}

</script>


<template>

    <div class="bg-[rgba(225,229,234,0.6)] border-2 fixed"
    :style="`top:${getTop(startPos,endPos)}px; left:${getLeft(startPos,endPos)}px; width:${getWidth(startPos,endPos)}px; height:${getHeight(startPos,endPos)}px;`">

    </div>

</template>
