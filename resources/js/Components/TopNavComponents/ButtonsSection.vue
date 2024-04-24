<script setup>
import NewFileButton from '@/Components/TopNavComponents/Buttons/NewFileButton.vue'
import NewFolderButton from '@/Components/TopNavComponents/Buttons/NewFolderButton.vue'
import UploadFileButton from '@/Components/TopNavComponents/Buttons/UploadFileButton.vue'
import CopyButton from '@/Components/TopNavComponents/Buttons/CopyButton.vue'
import CutButton from '@/Components/TopNavComponents/Buttons/CutButton.vue'
import PasteButton from '@/Components/TopNavComponents/Buttons/PasteButton.vue'
import RenameButton from '@/Components/TopNavComponents/Buttons/RenameButton.vue'
import DownloadButton from '@/Components/TopNavComponents/Buttons/DownloadButton.vue'
import DeleteButton from '@/Components/TopNavComponents/Buttons/DeleteButton.vue'
import ZipButton from '@/Components/TopNavComponents/Buttons/ZipButton.vue'
import UnzipButton from '@/Components/TopNavComponents/Buttons/UnzipButton.vue'
</script>


<template>
    <div class="flex justify-center py-3 px-2 gap-5 border-b border-custom-gray-borders">
        <div class="flex align-center gap-4">
            <NewFileButton/>
            <NewFolderButton/>
            <UploadFileButton/>
        </div>
        <div class="h-9 w-0.5 bg-custom-gray-borders"></div>
        <div class="flex align-center gap-4">
            <CopyButton />
            <CutButton />
            <PasteButton />
            <RenameButton />
            <DownloadButton />
            <DeleteButton />
        </div>
        <div class="h-9 w-0.5 bg-custom-gray-borders"></div>
        <div class="flex align-center gap-4">
            <ZipButton />
            <UnzipButton />
        </div>
    </div>
</template>
