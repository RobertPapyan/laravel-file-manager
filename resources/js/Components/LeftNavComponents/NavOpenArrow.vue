<script setup>
import {PlayIcon} from '@heroicons/vue/24/solid'


</script>


<template>
    <PlayIcon @click.stop="$emit('arrowClicked')" class="w-3 text-custom-gray-text cursor-pointer"/>
</template>
