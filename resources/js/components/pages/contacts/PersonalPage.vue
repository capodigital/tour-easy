<script>
import axios from 'axios'
import PersonalItem from './PersonalItem.vue'
import Confirm from '../../modals/Confirm';
import PersonalCard from './PersonalCard.vue';
import PersonalModal from './PersonalModal.vue';
import PersonalDetails from './PersonalDetails.vue';

export default {
    data() {
        return {
            filter: '',
            persons: [],
            person: {},
            details: null,
            show: false
        };
    },
    methods: {
        send(e) {
            const data = new FormData(e.target)
            this.Utils.lock(e.target)
            data.append('notify', 0);
            data.append('_method', this.person.id == undefined ? 'post' : 'put');
            axios.post(this.person.id == undefined ? 'api/persons' : `api/persons/${this.person.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.person.id == undefined) {
                    this.persons.unshift(response.data.data)
                    this.Utils.notify('Se ha creado correctamente el contacto')
                } else {
                    for (let i in this.persons) {
                        if (this.persons[i].id == this.person.id) {
                            this.persons[i] = response.data.data
                            this.Utils.notify('Se han actualizado correctamente los datos del contacto')
                            break
                        }
                    }
                }
                this.tour = {}
                this.socialmedias = [{}]
                this.files = [{ type: 'link' }]
                this.show = false
                this.Utils.unlock(e.target)
            }).catch((error) => {
                this.Utils.unlock(e.target)
                this.Utils.error(error.response)
            })
        },
        add() {
            this.person = {}
            this.show = true
        },
        edit(item) {
            this.details = null
            Object.assign(this.person, item)
            this.show = true
        },
        destroy(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar este contacto?')
            confirm.fire().then((result) => {
                axios.post('api/persons/' + item.id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    for (let i in this.persons) {
                        if (this.persons[i].id == item.id) {
                            this.persons.splice(i, 1)
                            this.Utils.notify('Se ha eliminado correctamente el contacto')
                            break
                        }
                    }
                    if (item.id == this.person.id) {
                        this.show = false
                    }
                }).catch((error) => {
                    this.Utils.error(error.response)
                })
            })
        },

    },
    created() {
        axios.get('api/persons', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.persons = response.data.data;
        }).catch((error) => {
            this.Utils.error(error.response)
        });
    },
    components: { PersonalItem, PersonalCard, PersonalModal, PersonalDetails }
}
</script>
<template>
    <section class="p-4">
        <div class="relative">
            <div class="flex">
                <h1
                    class="font-bold w-full bg-gradient-to-tr from-app-secondary-300 to-app-secondary-800 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                    PERSONAL
                </h1>
                <div class="flex items-center rounded border border-gray-200 px-2 me-2">
                    <i class="bi bi-funnel-fill text-gray-200"></i>
                    <input v-model="filter" type="text" placeholder="Escribe para filtrar"
                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-2 placeholder:text-gray-300">
                </div>
                <button @click="add"
                    class="bg-gradient-to-tr from-app-primary-500 to-app-primary-700 text-white px-2 py-1 rounded whitespace-nowrap"><i class="bi bi-plus"></i> Añadir</button>
            </div>
            <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-3">
                <template v-for="item in persons">
                    <PersonalCard @edit="edit" @destroy="destroy" @show="details = item" :contact="item"
                        v-if="Utils.filter(['name', 'lastname', 'lang', 'email', 'extra_phone', 'phone', 'position', 'notes', 'agency.tradename', 'agency.taxname', 'country.name', 'typecontact.description'], item, filter)" />
                </template>
            </div>
        </div>
        <PersonalModal v-if="show" :person="person" @send="send" @close="show = false" />
        <PersonalDetails v-if="details != null" @close="details = null" :person="details" @edit="edit" />
    </section>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}

form,
.container-ls {
    max-height: calc(100vh - 11.5rem);
}
</style>
