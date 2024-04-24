<script setup>
import { FolderIcon, ArrowRightIcon } from '@heroicons/vue/24/outline';
const disk = defineModel('disk');
const path = defineModel('path')

defineEmits(['goForward']);

</script>

<template>
    <div class="border  flex  rounded-md h-full items-center justify-between">
        <div class="px-2 flex gap-2">
            <FolderIcon class="w-[1.125rem] text-custom-gray-icons-light shrink-0" />
            <span class="text-sm">
                {{ disk }}://{{ path }}
            </span>
        </div>
        <div class="border-l px-2 flex items-center self-stretch">
            <button class="" @click="$emit('goForward')">
                <ArrowRightIcon class="w-[1.125rem]" />
            </button>
        </div>
    </div>
</template>
