<script>
import CustomModal from '../../common/CustomModal.vue';
import axios from 'axios';

export default {
    components: { CustomModal },
    props: {
        tour: Object,
    },
    methods: {
        selected(country) {
            for (const item of this.tour.countries) {
                if (item.id == country.id) {
                    return true;
                }
            }
            return false;
        },
        update(id, e) {
            if (e.target.checked) {
                if (!this.ids.includes(id)) {
                    this.ids.push(id);
                }
            } else {
                this.ids.splice(this.ids.indexOf(id), 1);
            }
        },
        save(e) {
            const data = new FormData(e.target);
            axios.post('api/tours/countries', data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.$emit('update', response.data.data)
            }).catch((error) => {
                this.Utils.error(error.response)
            })
        }
    },
    data() {
        const ids = [];
        for (const item of this.tour.countries) {
            ids.push(item.id);
        }
        return {
            countries: [],
            ids: ids,
            filter: '',
        }
    },
    created() {
        axios.get('api/countries', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.countries = response.data.data
        }).catch((error) => {
            this.Utils.error(error.response)
        })
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="save"
            class="gradient-1 rounded-xl rounded-tr p-10 overflow-auto scroll">
            <h1
                class="font-bold bg-gradient-to-tr from-app-primary-500 text-center to-app-primary-900 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                PAÍSES DE LA GIRA
            </h1>
            <div class="overflow-auto modal-content">
                <div class="max-w-[400px]">
                    <input type="hidden" :value="tour.id" name="tour_id" />
                    <input v-for="(id, index) in ids" type="hidden" :value="id" :name="`countries[${index}]`" />
                    <div class="flex items-center rounded border border-gray-200 px-2 me-2 mb-3">
                        <i class="bi bi-funnel-fill text-gray-200"></i>
                        <input v-model="filter" type="text" placeholder="Escribe para filtrar"
                            class="bg-transparent w-full text-gray-200 text-sm border-none focus:outline-none px-3 py-2 placeholder:text-gray-300">
                    </div>
                    <template v-for="country in countries" :key="country.id">
                        <article v-if="Utils.filter(['name', 'code'], country, filter)" class="rounded-lg gradient-2 mb-1 border border-gray-700 w-full p-2">
                            <div class="flex items-center w-full">
                                <div class="me-2 flex items-center">
                                    <input aria-label="Seleccionar país" @change="(e) => update(country.id, e)"
                                        class="form-check-input me-2" type="checkbox" :checked="selected(country)" />
                                    <span class="w-8 h-8 rounded-full flex justify-center items-center bg-app-primary-600 text-white font-bold text-xs">{{
                                        country.code }}</span>
                                </div>
                                <div class="w-full">
                                    <h3 class="text-gray-200 text-sm">{{ country.name }}</h3>
                                </div>
                            </div>
                        </article>
                    </template>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-600 to-slate-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
                <button type="submit"
                    class="mt-8 overlay-button bg-gradient-to-tr from-app-primary-500 to-app-primary-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Actualizar
                </button>
            </div>
        </form>
    </CustomModal>
</template>
<style scoped>
span {
    font-family: 'Archivo Black', sans-serif;
}
</style>
