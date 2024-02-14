<script>
import CustomModal from '../common/CustomModal.vue';
import Confirm from '../modals/Confirm';
import axios from 'axios';
import SupplierItem from './SupplierItem.vue';
import SupplierModal from './SupplierModal.vue';

export default {
    components: { CustomModal, SupplierItem, SupplierModal },
    data() {
        return {
            show: false,
            suppliers: [],
            supplier: {},
            agencies: [],
            countries: [],
            groups: [],
            country_id: 'AF',
            languages: [],
            socialmedias: [{}],
            files: [{ type: 'link' }],
        }
    },
    methods: {
        send(e) {
            const data = new FormData(e.target)
            this.Utils.lock(e.target)
            data.append('_method', this.supplier.id == undefined ? 'post' : 'put');
            axios.post(this.supplier.id == undefined ? 'api/suppliers' : `api/suppliers/${this.supplier.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.supplier.id == undefined) {
                    this.suppliers.unshift(response.data.data)
                    this.Utils.notify('Se ha creado correctamente el proveedor')
                } else {
                    for (let i in this.suppliers) {
                        if (this.suppliers[i].id == this.supplier.id) {
                            this.suppliers[i] = response.data.data
                            this.Utils.notify('Se han actualizado correctamente los datos del proveedor')
                            break
                        }
                    }
                }
                this.supplier = {}
                this.socialmedias = [{}]
                this.show = false
                this.Utils.unlock(e.target)
            }).catch((error) => {
                this.Utils.unlock(e.target)
                this.Utils.error(error.response)
            })
        },
        add() {
            this.supplier = {}
            this.show = true
        },
        edit(item) {
            Object.assign(this.supplier, item)
            this.show = true
        },
        destroy(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar este proveedor?')
            confirm.fire().then((result) => {
                axios.post('api/suppliers/' + item.id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    for (let i in this.suppliers) {
                        if (this.suppliers[i].id == item.id) {
                            this.suppliers.splice(i, 1)
                            this.Utils.notify('Se ha eliminado correctamente el proveedor')
                            break
                        }
                    }
                    if (item.id == this.supplier.id) {
                        this.show = false
                    }
                }).catch((error) => {
                    this.Utils.error(error.response)
                })
            })
        },
    },
    created() {
        axios.get('api/suppliers', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.suppliers = response.data.data;
        }).catch((error) => {
            this.Utils.error(error.response)
        });
    },
}
</script>
<template>
    <div>
        <CustomModal @close="$emit('close')">
            <div @submit.prevent="(e) => $emit('send', e)"
                class="rounded-2xl gradient-2 shadow-md shadow-gray-800 p-4 overflow-auto transition-all cursor-pointer">
                <input type="hidden" :value="Utils.user().id" name="agency_id" />
                <h1
                    class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                    PROVEEDORES
                </h1>
                <div class="overflow-auto modal-content">
                    <div>
                        <SupplierItem v-for="item in suppliers" :supplier="item" @edit="edit" @destroy="destroy" />
                    </div>
                </div>
                <div class="flex justify-center">
                    <button type="button" @click="$emit('close')"
                        class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-600 to-slate-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                        Cerrar
                    </button>
                    <button @click="add"
                        class="mt-8 overlay-button bg-gradient-to-tr from-app-primary-500 to-app-primary-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                        Agregar
                    </button>
                </div>
            </div>
        </CustomModal>
        <SupplierModal v-if="show" :supplier="supplier" @send="send" @close="show = false" />
    </div>
</template>
<style scoped>
form {
    background: linear-gradient(138.52deg, rgb(81, 44, 44) -1.32%, rgb(37, 44, 78) 85.77%);
}
</style>
