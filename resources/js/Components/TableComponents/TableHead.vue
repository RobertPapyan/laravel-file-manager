<script setup>
const props = defineProps({
    showPath:Boolean
})

</script>

<template>
    <thead class="text-left min-h-11 bg-custom-gray-bg">
        <th class="font-normal px-[0.625rem] py-2 text-custom-black-text">Name</th>
        <th class="font-normal px-[0.625rem] py-2 text-custom-black-text" v-show="showPath">Path</th>
        <th class="font-normal px-[0.625rem] py-2 text-custom-black-text">Date</th>
        <th class="font-normal px-[0.625rem] py-2 text-custom-black-text">Type</th>
        <th class="font-normal pr-4 py-2 text-custom-black-text text-end">Size</th>
    </thead>
</template>
