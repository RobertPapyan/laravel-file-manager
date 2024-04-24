<script setup>
import LeftNav from '@/Components/Structure/LeftNav.vue'
import NavbarTop from '@/Components/Structure/NavbarTop.vue'
import { provide } from 'vue';
import { onUpdated } from 'vue';
import { onMounted } from 'vue';

const props = defineProps({
    directories:Array,
    disk:String,
})


</script>

<template>
    <section class="max-w-7xl xl:mx-auto mx-2 h-full py-5">
        <div class="border  border-custom-gray-borders h-full overflow-hidden">
            <NavbarTop />
            <div class="flex h-full">
                <LeftNav :directories="directories" />
                <slot />
            </div>
        </div>
    </section>
</template>
