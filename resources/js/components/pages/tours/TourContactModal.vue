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
        selected(contact) {
            for (const item of this.tour.persons) {
                if (item.id == contact.id) {
                    return true;
                }
            }
            return false;
        },
        update(id, checked) {
            if (checked) {
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
                    <ContactItem v-for="contact in contacts" :person="contact" :selected="selected(contact)"
                        @change="(checked) => update(contact.id, checked)" />
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
