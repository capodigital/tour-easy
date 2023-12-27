<script>
export default {
    props: {
        documents: Array,
        dark: {
            type: Boolean,
            default: false,
        },
    }
}
</script>
<template>
    <div class="w-full">
        <span class="text-sm text-black px-2 py-1 bg-gray-200 rounded">Documentos</span>
        <div class="py-1 w-full overflow-hidden">
            <div v-for="document in documents" :class="{'bg-slate-900': dark}" class="flex overflow-hidden my-1 rounded items-center border border-b-gray-400 border-t-0 border-x-0 last:border-b-0 p-1 w-full">
                <i v-if="document.document_path != null" class="bi bi-file-earmark-check text-2xl text-gray-300"></i>
                <i v-else class="bi bi-google text-2xl text-gray-300"></i>
                <div class="ms-2 w-full overflow-hidden" v-if="document.document_path != null">
                    <h4 class="text-gray-300 font-semibold leading-4 truncate">{{ document.name }}</h4>
                    <a target="_blank" class="text-white text-sm hover:underline truncate leading-4" :href="'src/' + document.document_path">{{ document.name }}</a>
                </div>
                <div class="ms-2 w-full overflow-hidden" v-else>
                    <h4 class="text-gray-300 font-semibold leading-4 truncate">Documento de Drive</h4>
                    <a target="_blank" class="text-white text-sm hover:underline truncate leading-4" :href="document.url">{{document.url}}</a>
                </div>
            </div>
        </div>
    </div>
</template>
