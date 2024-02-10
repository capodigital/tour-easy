<script>
import MultiSelect from '../../common/MultiSelect.vue';


export default {
    emits: ['updatecities'],
    props: {
        tour: Object,
        activity: Object,
        suppliers: Array,
        startdate: String,
        starttime: String,
        enddate: String,
        endtime: String,
        countries: Array,
        start_cities: Array,
        end_cities: Array,
        persons_1: Array,
        persons_2: Array,
    },
    components: { MultiSelect },
    data() {
        const contacts = []
        const associated = []
        for (const item of this.tour.persons) {
            if (this.Utils.contact(item, this.activity.typeitinerary_id)) {
                contacts.push(item)
            }
            if (item.typecontact_id != 8 && item.typecontact_id != 9) {
                associated.push(item)
            }
        }
        return {
            contacts: contacts,
            associated: associated,
            _startdate: this.startdate,
            _starttime: this.starttime,
            _enddate: this.enddate,
            _endtime: this.endtime,
        }
    },
}
</script>

<template>
    <div>
        <div>
            <label class="text-slate-200 text-xs font-semibold">Hotel</label>
            <div class="flex items-center rounded border border-gray-300 px-2">
                <select required v-model="activity.place_id" name="place_id"
                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                    <template v-for="item in places">
                        <option v-if="Utils.place(item, activity.typeitinerary_id)" class="text-black" :value="item.id">
                            {{ item.name }}
                        </option>
                    </template>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-x-2">
            <div>
                <label class="text-slate-200 text-xs font-semibold">Fecha y hora de llegada</label>
                <div class="flex">
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-2 me-1 w-1/2">
                        <i class="bi bi-calendar-day text-gray-100"></i>
                        <input required :min="Utils.getDateInput(tour.startdate)" :max="Utils.getDateInput(tour.enddate)"
                            v-model="_startdate" type="date" placeholder="Fecha del show"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                    </div>
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-2 me-1 w-1/2">
                        <i class="bi bi-calendar-day text-gray-100"></i>
                        <input required v-model="_starttime" type="time" placeholder="Hora del show"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                    </div>
                </div>
                <input type="hidden" name="startdate" :value="_startdate + ' ' + _starttime" />
            </div>
            <div>
                <label class="text-slate-200 text-xs font-semibold">Fecha y hora de salida</label>
                <div class="flex">
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-2 me-1 w-1/2">
                        <i class="bi bi-calendar-day text-gray-100"></i>
                        <input :min="Utils.getDateInput(tour.startdate)" :max="Utils.getDateInput(tour.enddate)" required
                            v-model="_enddate" type="date" placeholder="Fecha de fin del show"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                    </div>
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-2 me-1 w-1/2">
                        <i class="bi bi-calendar-day text-gray-100"></i>
                        <input required v-model="_endtime" type="time" placeholder="Hora de fin del show"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                    </div>
                </div>
                <input type="hidden" name="enddate" :value="_enddate + ' ' + _endtime" />
            </div>
        </div>
        <div class="grid grid-cols-2 gap-x-2">
            <div>
                <label class="text-slate-200 text-xs font-semibold">País</label>
                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                    <i class="bi bi-globe text-gray-100"></i>
                    <select required v-model="activity._country_start"
                        @change="(e) => $emit('updatecities', { code: e.target.value, type: 'start' })"
                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        <option class="text-black" v-for="country in countries" :value="country.code">{{
                            country.name }}</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="text-slate-200 text-xs font-semibold">Ciudad</label>
                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                    <i class="bi bi-globe-americas text-gray-100"></i>
                    <select required v-model="activity.city_start_id" name="city_start_id"
                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        <option class="text-black" v-for="city in start_cities" :value="city.id">
                            {{ city.name }} ({{ city.code }})
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-x-2">
            <div>
                <label class="text-slate-200 text-xs font-semibold">Personas resposables</label>
                <MultiSelect :ids="persons_1" label="Seleccionar contactos" :options="contacts"
                    :initial="activity.persons_1">
                    <template v-slot="{ item }">
                        <div class="w-full">
                            <small class="float-right text-gray-500 text-xs">{{ item.typecontact.description }}</small>
                            <p class="text-gray-200 text-sm">{{ item.name }}</p>
                            <small class="float-right text-gray-500 text-xs">{{ item.group.name }}</small>
                            <p class="text-gray-500 text-sm">{{ item.email }}</p>
                        </div>
                    </template>
                </MultiSelect>
                <input type="hidden" :name="`persons_1[${index}]`" :value="id" v-for="(id, index) in persons_1" />
            </div>
            <div>
                <label class="text-slate-200 text-xs font-semibold">Personas asociadas</label>
                <MultiSelect :ids="persons_2" label="Seleccionar contactos" :options="associated"
                    :initial="activity.persons_2">
                    <template v-slot="{ item }">
                        <div class="w-full">
                            <small class="float-right text-gray-500 text-xs">{{ item.typecontact.description }}</small>
                            <p class="text-gray-200 text-sm">{{ item.name }}</p>
                            <small class="float-right text-gray-500 text-xs">{{ item.group.name }}</small>
                            <p class="text-gray-500 text-sm">{{ item.email }}</p>
                        </div>
                    </template>
                </MultiSelect>
                <input type="hidden" :name="`persons_2[${index}]`" :value="id" v-for="(id, index) in persons_2" />
            </div>
        </div>
        <div>
            <label class="text-slate-200 text-xs font-semibold">Notas</label>
            <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                <textarea rows="3" v-model="activity.notes" name="notes" placeholder="Notas"
                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
            </div>
        </div>
        <div class="form-check items-center text-gray-200 pt-2">
            <input type="hidden" :value="activity._outoftour ? 1 : 0" name="outoftour" />
            <input aria-label="Fuera de gira" class="form-check-input me-2" type="checkbox" v-model="activity._outoftour" />
            <label class="form-check-label leading-4 text-sm text-center mt-1">
                Fuera de gira
            </label>
        </div>
    </div>
</template>
