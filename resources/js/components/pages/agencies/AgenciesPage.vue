<script>
import axios from 'axios'
import AgencyItem from './AgencyItem.vue'
import Confirm from "../../modals/Confirm"
import PasswordModal from "../../common/PasswordModal.vue"
import AgencyModal from './AgencyModal.vue'
import ManagerModal from './ManagerModal.vue'
export default {
    data() {
        return {
            filter: '',
            agencies: [],
            agency: {},
            agency_password_id: null,
            user_password_id: null,
            user: {
                show: false,
            },
            show: false,
        };
    },
    methods: {
        send(e) {
            const data = new FormData(e.target)
            this.Utils.lock(e.target)
            data.append('_method', this.agency.id == undefined ? 'post' : 'put');
            axios.post(this.agency.id == undefined ? 'api/agencies' : `api/agencies/${this.agency.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.agency.id == undefined) {
                    this.agencies.unshift(response.data.data)
                    this.Utils.notify('Se ha creado correctamente la agencia')
                } else {
                    for (let i in this.agencies) {
                        if (this.agencies[i].id == this.agency.id) {
                            this.agencies[i] = response.data.data
                            this.Utils.notify('Se han actualizado correctamente los datos de la agencia')
                            break
                        }
                    }
                }
                this.agency = {}
                this.socialmedias = [{}]
                this.files = [{ type: 'link' }]
                this.show = false
                this.Utils.unlock(e.target)
            }).catch((error) => {
                this.Utils.unlock(e.target)
                this.Utils.error(error.response)
            })
        },
        manager(e) {
            const data = new FormData(e.target)
            this.Utils.lock(e.target)
            data.append('_method', this.user.id == undefined ? 'post' : 'put');
            axios.post(this.user.id == undefined ? 'api/users' : `api/users/${this.user.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.user.id == undefined) {
                    this.Utils.notify('Se ha creado correctamente el administrador')
                } else {
                    this.Utils.notify('Se han actualizado correctamente los datos del administrador')
                }
                for (let i in this.agencies) {
                    if (this.agencies[i].id == response.data.data.id) {
                        this.agencies[i] = response.data.data
                        break
                    }
                }
                this.user = { show: false }
                this.show = false
                this.Utils.unlock(e.target)
            }).catch((error) => {
                this.Utils.unlock(e.target)
                this.Utils.error(error.response)
            })
        },
        add() {
            this.agency = {}
            this.socialmedias = [{}]
            this.files = [{ type: 'link' }]
            this.show = true
        },
        edit(item) {
            this.country_id = item.city.country.code
            Object.assign(this.agency, item)
            this.show = true
        },
        editManager(user) {
            Object.assign(this.user, user)
            this.user.show = true
        },
        destroy(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar esta agencia?')
            confirm.fire().then((result) => {
                axios.post('api/agencies/' + item.id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    for (let i in this.agencies) {
                        if (this.agencies[i].id == item.id) {
                            this.agencies.splice(i, 1)
                            this.Utils.notify('Se ha eliminado correctamente la agencia')
                            break
                        }
                    }
                }).catch((error) => {
                    this.Utils.error(error.response)
                })

            })
        },
        destroyManager(user) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar este documento?')
            confirm.fire().then((result) => {
                axios.post('api/users/' + user.id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    for (let i in this.agencies) {
                        if (this.agencies[i].id == user.agency_id) {
                            this.agencies[i] = response.data.data
                            this.Utils.notify('Se ha eliminado correctamente el administrador')
                            break
                        }
                    }
                }).catch((error) => {
                    this.Utils.error(error.response)
                })
            })
        },
        changeAgencyPassword(form) {
            this.Utils.lock(form)
            const data = new FormData(form)
            axios.post(`api/agencies/password/${this.agency_password_id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.Utils.notify('Se ha cambiado la contraseña correctamente')
                this.agency_password_id = null
            }).catch((error) => {
                this.Utils.unlock(form)
                this.Utils.error(error.response)
            })
        },
        changeUserPassword(form) {
            this.Utils.lock(form)
            const data = new FormData(form)
            axios.post(`api/users/password/${this.user_password_id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.Utils.notify('Se ha cambiado la contraseña correctamente')
                this.user_password_id = null
            }).catch((error) => {
                this.Utils.unlock(form)
                this.Utils.error(error.response)
            })
        }
    },
    created() {
        axios.get('api/agencies', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.agencies = response.data.data;
        }).catch((error) => {
            this.Utils.error(error.response);
        });
    },
    components: { AgencyItem, PasswordModal, AgencyModal, ManagerModal }
}
</script>
<template>
    <section class="p-4">
        <div class="relative">
            <div class="flex">
                <h1
                    class="font-bold bg-gradient-to-tr w-full from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                    AGENCIAS</h1>
                <div v-if="Utils.role() == 'user'" class="flex items-center rounded border border-gray-400 px-2 me-2">
                    <i class="bi bi-funnel-fill text-gray-400"></i>
                    <input v-model="filter" type="text" placeholder="Escribe para filtrar"
                        class="bg-transparent w-full text-gray-700 text-sm border-none focus:outline-none px-3 py-2">
                </div>
                <button v-if="Utils.role() == 'user'" @click="add"
                    class="px-2 py-1 text-white bg-gradient-to-tr from-slate-800 to-slate-950 rounded">Añadir</button>
            </div>
            <div class="mt-4 grid sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                <template v-for="item in agencies">
                    <AgencyItem @manageradd="user.show = true" @managerdestroy="destroyManager" @manageredit="editManager"
                        @agency_password="(id) => agency_password_id = id" @user_password="(id) => user_password_id = id"
                        @edit="edit" @destroy="destroy" :agency="item"
                        v-if="Utils.filter(['tradename', 'taxname', 'taxcode', 'phone', 'address', 'email', 'owner', 'notes', 'city.name'], item, filter)" />
                </template>
            </div>
        </div>
        <transition name="bounce" mode="out-in">
            <ManagerModal v-if="Utils.role() == 'agency' && user.show" @send="manager" @close="user = { show: false }"
                :user="user" />
        </transition>
        <transition name="bounce" mode="out-in">
            <AgencyModal v-if="Utils.role() != 'artist' && show" :agency="agency" @close="show = false" @send="send" />
        </transition>
        <transition name="bounce" mode="out-in">
            <PasswordModal v-if="agency_password_id != null" @send="changeAgencyPassword"
                @close="agency_password_id = null" />
        </transition>
        <transition name="bounce" mode="out-in">
            <PasswordModal v-if="user_password_id != null" @send="changeUserPassword" @close="user_password_id = null" />
        </transition>
    </section>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}
</style>
