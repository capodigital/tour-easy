<article style="border-radius: .25rem; border: solid 1px #a3a3a3; padding: .25rem">
    <div class="flex items-center w-full">
        <div style="position: relative; margin-bottom: .25rem">
            <div style="padding-left: .25rem">
                <small style="float: right; color: #999999; font-size: .85em">
                    {{ $person->typecontact->description }}
                </small>
                <p style="color: #000; font-weight: bold; font-size: 1.05em">{{ $person->name }}</p>
                <p style="color: #474747;font-size:.9em">{{ $person->email }}</p>
            </div>
        </div>
    </div>
    {{-- <div class="w-full transition-all overflow-hidden px-4" :class="{ 'h-0 p-0': collapse, 'h-auto p-2': !collapse }">
        <p class="text-gray-400 text-xs mb-2">{{ person->notes }}</p>
        <div class="w-full transition-all overflow-hidden p-2">
            <div class="flex items-center my-1">
                <i class="bi bi-geo-alt text-lg me-2 text-gray-200"></i>
                <div>
                    <h3 class="text-gray-300">Nacionalidad</h3>
                    <p class="text-sm text-gray-400">{{ person->country->name }} </p>
                </div>
            </div>
            <hr class="bg-gray-500 text-gray-500" />
            <div class="flex items-center my-1">
                <i class="bi bi-calendar-day text-lg me-2 text-gray-200"></i>
                <div>
                    <h3 class="text-gray-300">Fecha de nacimiento</h3>
                    <p class="text-sm text-gray-400">{{ person->birthday }}</p>
                </div>
            </div>
            <hr class="bg-gray-500 text-gray-500" />
            <a :href="'tel:' + person.phone" class="flex items-center my-1">
                <i class="bi bi-telephone text-lg me-2 text-gray-200"></i>
                <div>
                    <h3 class="text-gray-300">Número de teléfono principal</h3>
                    <p class="text-sm text-gray-400">{{ person->phone }}</p>
                </div>
            </a>
            <hr class="bg-gray-500 text-gray-500" />
            <a :href="'tel:' + person.extra_phone" class="flex items-center my-1">
                <i class="bi bi-telephone text-lg me-2 text-gray-200"></i>
                <div>
                    <h3 class="text-gray-300">Número de teléfono secundario</h3>
                    <p class="text-sm text-gray-400">{{ person->extra_phone }}</p>
                </div>
            </a>
            <hr class="bg-gray-500 text-gray-500" />
            <div class="flex items-center my-1">
                <i class="bi bi-passport text-lg me-2 text-gray-200"></i>
                <div>
                    <h3 class="text-gray-300">Pasaporte</h3>
                    <p class="text-sm text-gray-400">{{ person->passport }} (Expira: {{ person->passport_expiry }})</p>
                </div>
            </div>
            <hr class="bg-gray-500 text-gray-500" />
            <div class="flex items-center my-1">
                <i v-if="person.notify_type == 'WhatsApp'" class="bi bi-whatsapp text-lg me-2 text-gray-200"></i>
                <i v-else-if="person.notify_type == 'Telegram'" class="bi bi-telegram text-lg me-2 text-gray-200"></i>
                <i v-else-if="person.notify_type == 'SMS'" class="bi bi-message text-lg me-2 text-gray-200"></i>
                <i v-else class="bi bi-envelope text-lg me-2 text-gray-200"></i>
                <div>
                    <h3 class="text-gray-300">Método de notificación</h3>
                    <p class="text-sm text-gray-400">{{ person->notify_type }}</p>
                </div>
            </div>
            <hr class="bg-gray-500 text-gray-500" />
            <div class="flex items-center my-1">
                <i class="bi bi-collection text-lg me-2 text-gray-200"></i>
                <div>
                    <h3 class="text-gray-300">Grupo</h3>
                    <p class="text-sm text-gray-400">{{ person->group->name }}</p>
                </div>
            </div>
            <hr class="bg-gray-500 text-gray-500" />
            <div class="flex items-center my-1">
                <i class="bi bi-translate text-lg me-2 text-gray-200"></i>
                <div>
                    <h3 class="text-gray-300">Idioma</h3>
                    <p class="text-sm text-gray-400">{{ person->lang }}</p>
                </div>
            </div>
            <div class="mt-3 grid grid-cols-5">
                <a v-for="socialmedia in person.socialmedias" :href="socialmedia.url" target="_blank"
                    class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                    <img :src="socialmedia.typesocialmedia.logo.replace('http://localhost/', '')" class="" />
                </a>
            </div>
        </div>
    </div> --}}
</article>
