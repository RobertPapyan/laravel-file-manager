<script setup>
import CopyButton from '../TopNavComponents/Buttons/CopyButton.vue';
import CutButton from '../TopNavComponents/Buttons/CutButton.vue'
import DownloadButton from '../TopNavComponents/Buttons/DownloadButton.vue';
import RenameButton from '../TopNavComponents/Buttons/RenameButton.vue';
import DeleteButton from '../TopNavComponents/Buttons/DeleteButton.vue';
import ZipButton from '../TopNavComponents/Buttons/ZipButton.vue';
import UnzipButton from '../TopNavComponents/Buttons/UnzipButton.vue';
const props = defineProps({
    posX:Number,
    posY:Number
})
const showContextMenu = defineModel();

</script>



<template>
    <div v-show="showContextMenu" class="fixed bg-white min-w-40 px-4 py-4 border border-custom-blue-light rounded-lg shadow-[0px_4px_12px_0px_#0000001A]" :style="'top:'+ posY+ 'px;'+'left:'+posX+'px;'">
        <ul class="space-y-2">
            <li><RenameButton/></li>
            <li><CopyButton/></li>
            <li><CutButton/></li>
            <li><DownloadButton/></li>
            <li><DeleteButton red/></li>
            <li class="pl-1"><ZipButton/></li>
            <li class="pl-1"><UnzipButton/></li>
        </ul>

    </div>
</template>

