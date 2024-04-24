<script setup>
import {HomeIcon, ArrowLeftIcon, ArrowRightIcon,ArrowUpIcon, ArrowPathIcon, ListBulletIcon} from '@heroicons/vue/24/outline'

const props = defineProps ({
    type:String
})

</script>


<template>
    <button v-if="type == 'main'" class="flex py-1 px-3 border rounded-md gap-2 items-center bg-gradient-to-b from-white to-[rgba(102,102,102,0.05)]">
        <HomeIcon class="w-[1.125rem]"/>
        <span class="text-sm">Main</span>
    </button>
    <button v-else-if="type == 'leftArrow'" class="flex py-1 px-1.5 border rounded-md gap-2 items-center bg-gradient-to-b from-white to-[rgba(102,102,102,0.05)]">
        <ArrowLeftIcon class="w-[1.125rem]"/>
    </button>
    <button v-else-if="type == 'rightArrow'" class="flex py-1 px-1.5 border rounded-md gap-2 items-center bg-gradient-to-b from-white to-[rgba(102,102,102,0.05)]">
        <ArrowRightIcon class="w-[1.125rem]"/>
    </button>
    <button v-else-if="type == 'topArrow'" class="flex py-1 px-1.5 border rounded-md gap-2 items-center bg-gradient-to-b from-white to-[rgba(102,102,102,0.05)]">
        <ArrowUpIcon class="w-[1.125rem]"/>
    </button>
    <button v-else-if="type == 'refreshArrow'" class="flex py-1 px-1.5 border rounded-md gap-2 items-center bg-gradient-to-b from-white to-[rgba(102,102,102,0.05)]">
        <ArrowPathIcon class="w-[1.125rem]"/>
    </button>
    <button v-else-if="type == 'changeView'" class="flex py-1 px-1.5 border rounded-md gap-2 items-center bg-gradient-to-b from-white to-[rgba(102,102,102,0.05)]">
        <ListBulletIcon class="w-[1.125rem]"/>
    </button>

</template>
