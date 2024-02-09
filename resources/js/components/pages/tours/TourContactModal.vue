<script>
import CustomModal from '../../common/CustomModal.vue';
import ContactItem from '../contacts/ContactItem.vue';
import axios from 'axios';

export default {
    components: { CustomModal, ContactItem },
    props: {
        tour: Object,
    },
    methods: {
        selectAll(e) {
            if (e.target.checked) {
                for (let contact of this.contacts) {
                    if (!this.ids.includes(contact.id)) {
                        this.ids.push(contact.id);
                    }
                }
            } else {
                this.ids = [];
            }
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
            // data.append('contacts', this.ids);
            axios.post('api/tours/contacts', data, {
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
        for (const item of this.tour.persons) {
            ids.push(item.id);
        }
        return {
            contacts: [],
            ids: ids,
            filter: '',
        }
    },
    created() {
        axios.post('api/persons/agency', { id: this.tour.agency_id }, {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.contacts = response.data.data
        }).catch((error) => {
            this.Utils.error(error.response)
        })
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="save"
            class="bg-gradient-to-tr from-app-primary-100 via-white to-app-primary-200 rounded-3xl rounded-tr p-10 overflow-auto scroll">
            <h1
                class="font-bold bg-gradient-to-tr from-app-primary-500 text-center to-app-primary-900 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                CONTACTOS DE LA GIRA
            </h1>
            <div class="overflow-auto modal-content">
                <div class="max-w-[400px]">
                    <input type="hidden" :value="tour.id" name="tour_id" />
                    <input v-for="(id, index) in ids" type="hidden" :value="id" :name="`contacts[${index}]`" />
                    <div class="flex mb-3 items-center">
                        <div class="flex items-center rounded border border-gray-200 px-2 me-2 w-7/12">
                            <i class="bi bi-funnel-fill text-gray-200"></i>
                            <input v-model="filter" type="text" placeholder="Escribe para filtrar"
                                class="bg-transparent w-full text-gray-200 text-sm border-none focus:outline-none px-3 py-2 placeholder:text-gray-300">
                        </div>
                        <div class="w-5/12 px-2">
                            <div class="form-check items-center">
                                <input aria-label="Seleccionar todos" @change="selectAll"
                                    class="form-check-input me-1" type="checkbox" />
                                <label class="form-check-label leading-4 text-sm mt-1">
                                    Seleccionar todos
                                </label>
                            </div>
                        </div>
                    </div>

                    <template v-for="contact in contacts" :key="contact.id">
                        <ContactItem
                            v-if="Utils.filter(['name', 'lastname', 'lang', 'email', 'extra_phone', 'phone', 'position', 'notes', 'agency.tradename', 'agency.taxname', 'country.name', 'typecontact.description'], contact, filter)"
                            :person="contact" :selected="ids.includes(contact.id)" @update="(e) => update(contact.id, e)" />
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
form {
    background: linear-gradient(138.52deg, rgb(38, 75, 80) 0.44%, rgb(41, 36, 72) 85.15%) !important;
}
</style>
