<script setup>
import { PencilSquareIcon } from '@heroicons/vue/24/outline';
import { emitter } from '@/EventBus';



</script>


<template>
      <button @click.stop="emitter.emit('openRenameFilesModal')" class="flex gap-1.5 cursor-pointer items-center text-custom-black-text hover:text-custom-gray-text transition-colors">
        <PencilSquareIcon class="w-[1.125rem] text-custom-gray-icons"/>
        <span class="text-sm">Rename</span>
    </button>

</template>
