<script setup>
const props = defineProps({
    errorMessage:String
})


</script>

<template>
    <span class="text-sm text-red-600 block mt-2 ml-1">
        *{{ errorMessage }}
    </span>
</template>
