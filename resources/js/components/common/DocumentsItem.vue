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
    <div>
        <span class="text-sm text-black px-2 py-1 bg-gray-200 rounded">Documentos</span>
        <div class="py-1">
            <div v-for="document in documents" :class="{'bg-slate-900': dark}" class="flex my-1 rounded items-center border border-b-gray-400 border-t-0 border-x-0 last:border-b-0 p-1">
                <i v-if="document.document_path != null" class="bi bi-file-earmark-check text-2xl text-white"></i>
                <i v-else class="bi bi-google text-2xl text-white"></i>
                <div class="ms-2" v-if="document.document_path != null">
                    <h4 class="text-gray-300 font-semibold leading-4 truncate">{{ document.name }}</h4>
                    <a target="_blank" class="text-white text-sm hover:underline truncate leading-4" :href="'src/' + document.document_path">{{ document.name }}</a>
                </div>
                <div class="ms-2" v-else>
                    <h4 class="text-gray-300 font-semibold leading-4">Documento de Drive</h4>
                    <a target="_blank" class="text-white text-sm hover:underline truncate leading-4" :href="document.url">{{document.url}}</a>
                </div>
            </div>
        </div>
    </div>
</template>
