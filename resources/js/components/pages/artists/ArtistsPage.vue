<script>
import axios from 'axios'
import ArtistsItem from './ArtistsItem.vue'
import Confirm from "../../modals/Confirm"
import PasswordModal from '../../common/PasswordModal.vue';
import ArtistModal from './ArtistModal.vue';
import ArtistCard from './ArtistCard.vue';
import ArtistDetails from './ArtistDetails.vue';

export default {
    data() {
        return {
            filter: '',
            artists: [],
            artist: {
                birthday: new Date().toLocaleDateString()
            },
            details: null,
            agencies: [],
            password_id: null,
            show: false,
        };
    },
    methods: {
        add() {
            this.artist = {
                birthday: this.Utils.date(new Date())
            }
            this.show = true
        },
        edit(item) {
            this.details = null
            Object.assign(this.artist, item)
            this.show = true
        },
        destroy(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar este artista?')
            confirm.fire().then((result) => {
                if (result.status == "accept") {
                    axios.post('api/artists/' + item.id, { _method: 'delete' }, {
                        headers: {
                            'Authorization': `Bearer ${this.Utils.token()}`
                        }
                    }).then((response) => {
                        for (let i in this.artists) {
                            if (this.artists[i].id == item.id) {
                                this.artists.splice(i, 1)
                                this.Utils.notify('Se ha eliminado correctamente el artista')
                                break
                            }
                        }
                    }).catch((error) => {
                        this.Utils.error(error.response)
                    })
                }
            })
        },
        send(e) {
            const data = new FormData(e.target)
            this.Utils.lock(e.target)
            data.append('_method', this.artist.id == undefined ? 'post' : 'put');
            axios.post(this.artist.id == undefined ? 'api/artists' : `api/artists/${this.artist.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.artist.id == undefined) {
                    this.artists.unshift(response.data.data)
                    this.Utils.notify('Se ha agregado correctamente el artista')
                } else {
                    for (let i in this.artists) {
                        if (this.artists[i].id == this.artist.id) {
                            this.artists[i] = response.data.data
                            this.Utils.notify('Se han actualizado correctamente los datos del artista')
                            break
                        }
                    }
                }
                this.tour = {}
                this.socialmedias = [{}]
                this.files = [{ type: 'link' }]
                this.show = false
                this.preview = 'src/user_placeholder.png'
                this.Utils.unlock(e.target)
            }).catch((error) => {
                this.Utils.unlock(e.target)
                this.Utils.error(error.response)
            })
        },
        changePassword(form) {
            this.Utils.lock(form)
            const data = new FormData(form)
            axios.post(`api/artists/password/${this.password_id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then(() => {
                this.Utils.notify('Se ha cambiado las contraseña correctamente')
                this.password_id = null
            }).catch((error) => {
                this.Utils.unlock(form)
                this.Utils.error(error.response)
            })
        }
    },
    created() {
        axios.get('api/artists', {
            headers: {
                Authorization: `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.artists = response.data.data;
        });
    },
    components: { ArtistsItem, PasswordModal, ArtistModal, ArtistCard, ArtistDetails }
}
</script>
<template>
    <section class="">
        <div class="flex mb-1 p-2">
            <h1
                class="font-bold w-full bg-gradient-to-tr from-app-secondary-300 to-app-secondary-800 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                ARTISTAS
            </h1>
            <div class="flex items-center rounded border border-gray-200 px-2 me-2">
                <i class="bi bi-funnel-fill text-gray-200"></i>
                <input v-model="filter" type="text" placeholder="Escribe para filtrar"
                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-2">
            </div>
            <button v-if="Utils.role() != 'artist'" @click="add"
                class="bg-gradient-to-tr from-app-primary-500 to-app-primary-700 text-white px-2 py-1 rounded whitespace-nowrap"><i class="bi bi-plus"></i> Añadir</button>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 p-3">
            <template v-for="item in artists">
                <ArtistCard @edit="edit" @destroy="destroy" @show="(item) => details = item" :artist="item"
                    v-if="Utils.filter(['name', 'lastname', 'stagename', 'email', 'agency.tradename', 'agency.taxname'], item, filter)" />
            </template>
        </div>
        <ArtistModal v-if="show" @close="show = false" @send="send" :artist="artist" />
        <ArtistDetails v-if="details != null" @close="details = null" :artist="details" @edit="edit" />
        <PasswordModal v-if="password_id != null" @send="changePassword" @close="password_id = null" />
    </section>
</template>
<style scoped>
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0px 1000px rgb(30 41 59) inset;
}

input:-webkit-autofill {
    -webkit-text-fill-color: white
}

h1 {
    font-family: 'Archivo Black', sans-serif;
}

form,
.container {
    max-height: calc(100vh - 7.5rem);
}
</style>
