<script>
import CustomModal from '../../../common/CustomModal.vue';
import axios from 'axios';

export default {
    components: { CustomModal },
    props: {
        tour: Object,
    },
    data() {
        return {
            images: [],
            uploading: false,
            preview: null
        }
    },
    methods: {
        remove(index) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar esta imagen?')
            confirm.fire().then((result) => {
                axios.post('api/photos/' + this.images[index].id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    this.images.splice(index, 1)
                    this.Utils.notify('Se eliminó la imagen correctamente');
                }).catch((error) => {
                    this.Utils.error(error.response)
                })
            })
        },
        updatePreview(e) {
            const files = e.target.files
            if (files && files.length) {
                this.preview = URL.createObjectURL(files[0])
            } else {
                this.preview = null
            }
        },
        saveImage(e) {
            const data = new FormData(e.target)
            this.uploading = true
            axios.post('api/photos', data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.preview = null
                this.images.push(response.data.data)
                this.$emit('update', this.images)
                this.Utils.notify('Se subió la imagen correctamente')
                this.uploading = false
            }).catch((error) => {
                this.uploading = false
                this.Utils.error(error.response)
            })
        },
        openPicker() {
            if (this.preview == null) {
                this.$el.querySelector('#tour-image').click()
            }
        },
    },
    created() {
        axios.post('api/photos/tour', { id: this.tour.id }, {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.images = response.data.data
        })
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="(e) => $emit('send', e)"
            class="bg-gradient-to-tr from-slate-700 to-slate-950 rounded-2xl shadow-md shadow-gray-500 p-4 overflow-auto transition-all cursor-pointer">
            <div class="flex items-center">
                <h1
                    class="font-bold bg-gradient-to-tr w-full  from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                    IMÁGENES DE LA GIRA
                </h1>
                <button @click="$emit('close')" class="bg-slate-800 text-white rounded px-2 py-1">Cerrar</button>
            </div>
            <div class="overflow-auto modal-content">
                <div v-viewer="options" class="images md:grid">
                    <div class="relative" v-for="(image, index) in images">
                        <button @click="remove(index)"
                            class="absolute bg-transparent border-none z-50 focus:outline-none text-white top-1 right-1"><i
                                class="bi bi-trash"></i></button>
                        <div class="image cursor-pointer h-56 bg-cover bg-center"
                            :style="{ 'background-image': `url(${image.url})` }" :key="index">
                            <img class="opacity-0" :src="image.url" :alt="`${tour.tourname} - ${index}`" />
                        </div>

                    </div>
                    <form @submit.prevent="saveImage">
                        <input type="file" @change="updatePreview" class="hidden" id="tour-image" name="image" />
                        <input type="hidden" name="tour_id" :value="tour.id" />
                        <div @click="openPicker" :class="{ 'border-2': preview == null }"
                            class="relative border-gray-500 h-full rounded cursor-pointer border-dashed min-h-[14rem] flex justify-center items-center">
                            <i v-if="preview == null" class="bi bi-plus text-6xl text-gray-500"></i>
                            <div class="h-56 w-full bg-cover" v-else :style="{ 'background-image': `url(${preview})` }">
                                <button v-if="uploading != true" @click="preview = null"
                                    class="absolute bg-transparent border-none z-50 focus:outline-none text-white top-1 right-1"><i
                                        class="bi bi-trash"></i></button>
                                <div
                                    class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                                    <div v-if="uploading" class="spinner-border me-2" role="status"><span
                                            class="visually-hidden">Loading...</span></div>
                                    <button v-else class="text-white text-4xl opacity-75 hover:opacity-100" type="submit"><i
                                            class="bi bi-upload"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </form>
    </CustomModal>
</template>
<style scoped>
.images {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    grid-gap: 1px;
}

.modal-content {
    max-height: calc(100vh - 7rem);
}
</style>
