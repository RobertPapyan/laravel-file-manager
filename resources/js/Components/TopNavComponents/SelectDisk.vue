<script setup>
import { inject } from 'vue';
import { InboxIcon } from '@heroicons/vue/24/outline';
import { ChevronDownIcon } from '@heroicons/vue/24/solid';
import { ref } from 'vue';
import {Listbox,ListboxButton,ListboxOptions,ListboxOption, } from '@headlessui/vue'
import { emitter } from '@/EventBus';

const diskList  = inject('diskList')
const disk = inject('disk')
const showDiskList = ref(false)
const selectedDisk = ref('public')
</script>


<template>

    <Listbox v-model="selectedDisk">
        <div class=" border-b pb-2 border-custom-gray-borders">
            <div class=" h-7">
                <div class="relative bg-white border border-custom-gray-borders  py-[0.1rem] rounded-lg z-40">
                <div class="flex items-center justify-between px-2">
                    <span class="flex gap-2 text-sm cursor-pointer" @click="emitter.emit('goHome')">
                        <InboxIcon class="w-[1.275rem] text-custom-gray-icons" />{{ disk }}
                    </span>
                    <ListboxButton>
                        <ChevronDownIcon @click="showDiskList = !showDiskList" class="w-[1rem] cursor-pointer" />
                    </ListboxButton>
                </div>

                <ListboxOptions class="relative mb-1 mt-1 bg-white px-2">

                    <ListboxOption v-for="(d, diskName) in diskList" :key="diskName" :value="diskName"
                    @click="emitter.emit('changeDisk',diskName);showDiskList = false"
                    class="text-sm flex gap-2  rounded-md py-1 cursor-pointer"
                    :class="diskName === disk? 'hidden cursor-default text-custom-gray-icons-light':'hover:bg-custom-gray-bg'">

                        <InboxIcon class="w-[1.275rem] text-custom-gray-icons" :class="diskName === disk? 'cursor-default text-custom-gray-icons-light':''"/> <span> {{ diskName }} </span>

                    </ListboxOption>
                </ListboxOptions>
            </div>
            </div>
        </div>

    </Listbox>



    <!-- <div class="flex items-center">
        <div class=" min-w-36 border border-custom-gray-borders px-2 py-[0.1rem] rounded-lg">
            <div class="flex items-center justify-between">
            <span class="flex gap-2 text-sm">
                <InboxIcon class="w-[1.275rem] text-custom-gray-icons" />{{ disk }}
            </span>
            <ChevronDownIcon @click="showDiskList = !showDiskList" class="w-[1rem] cursor-pointer" />
            </div>
            <ul v-show="showDiskList" class="">
                <li v-for="(disk,diskName) in diskList">
                    {{ diskName }}
                </li>
            </ul>
        </div>

    </div> -->
</template>
