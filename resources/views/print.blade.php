<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gira</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <style>
        /* ! tailwindcss v3.4.1 | MIT License | https://tailwindcss.com */
        *,
        ::after,
        ::before {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb
        }

        ::after,
        ::before {
            --tw-content: ''
        }

        :host,
        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-feature-settings: normal;
            font-variation-settings: normal;
            -webkit-tap-highlight-color: transparent
        }

        body {
            margin: 0;
            line-height: inherit
        }

        hr {
            height: 0;
            color: inherit;
            border-top-width: 1px
        }

        abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        b,
        strong {
            font-weight: bolder
        }

        code,
        kbd,
        pre,
        samp {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-feature-settings: normal;
            font-variation-settings: normal;
            font-size: 1em
        }

        small {
            font-size: 80%
        }

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sub {
            bottom: -.25em
        }

        sup {
            top: -.5em
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            font-feature-settings: inherit;
            font-variation-settings: inherit;
            font-size: 100%;
            font-weight: inherit;
            line-height: inherit;
            color: inherit;
            margin: 0;
            padding: 0
        }

        button,
        select {
            text-transform: none
        }

        [type=button],
        [type=reset],
        [type=submit],
        button {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none
        }

        :-moz-focusring {
            outline: auto
        }

        :-moz-ui-invalid {
            box-shadow: none
        }

        progress {
            vertical-align: baseline
        }

        ::-webkit-inner-spin-button,
        ::-webkit-outer-spin-button {
            height: auto
        }

        [type=search] {
            -webkit-appearance: textfield;
            outline-offset: -2px
        }

        ::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        summary {
            display: list-item
        }

        blockquote,
        dd,
        dl,
        figure,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        hr,
        p,
        pre {
            margin: 0
        }

        fieldset {
            margin: 0;
            padding: 0
        }

        legend {
            padding: 0
        }

        menu,
        ol,
        ul {
            list-style: none;
            margin: 0;
            padding: 0
        }

        dialog {
            padding: 0
        }

        textarea {
            resize: vertical
        }

        input::placeholder,
        textarea::placeholder {
            opacity: 1;
            color: #9ca3af
        }

        [role=button],
        button {
            cursor: pointer
        }

        :disabled {
            cursor: default
        }

        audio,
        canvas,
        embed,
        iframe,
        img,
        object,
        svg,
        video {
            display: block;
            vertical-align: middle
        }

        img,
        video {
            max-width: 100%;
            height: auto
        }

        [hidden] {
            display: none
        }

        *,
        ::before,
        ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia:
        }

        .float-right {
            float: right
        }

        .my-1 {
            margin-top: 0.25rem;
            margin-bottom: 0.25rem
        }

        .my-2 {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem
        }

        .my-3 {
            margin-top: 0.75rem;
            margin-bottom: 0.75rem
        }

        .mb-1 {
            margin-bottom: 0.25rem
        }

        .mb-2 {
            margin-bottom: 0.5rem
        }

        .me-1 {
            margin-inline-end: 0.25rem
        }

        .me-2 {
            margin-inline-end: 0.5rem
        }

        .ms-1 {
            margin-inline-start: 0.25rem
        }

        .mt-1 {
            margin-top: 0.25rem
        }

        .mt-2 {
            margin-top: 0.5rem
        }

        .mt-3 {
            margin-top: 0.75rem
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .w-11\/12 {
            width: 91.666667%
        }

        .w-full {
            width: 100%
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr))
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .justify-between {
            justify-content: space-between
        }

        .justify-around {
            justify-content: space-around
        }

        .overflow-hidden {
            overflow: hidden
        }

        .rounded {
            border-radius: 0.25rem
        }

        .rounded-lg {
            border-radius: 0.5rem
        }

        .rounded-md {
            border-radius: 0.375rem
        }

        .border {
            border-width: 1px
        }

        .border-gray-500 {
            --tw-border-opacity: 1;
            border-color: rgb(107 114 128 / var(--tw-border-opacity))
        }

        .border-gray-700 {
            --tw-border-opacity: 1;
            border-color: rgb(55 65 81 / var(--tw-border-opacity))
        }

        .bg-gray-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(107 114 128 / var(--tw-bg-opacity))
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity))
        }

        .bg-opacity-40 {
            --tw-bg-opacity: 0.4
        }

        .p-0 {
            padding: 0px
        }

        .p-2 {
            padding: 0.5rem
        }

        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem
        }

        .ps-2 {
            padding-inline-start: 0.5rem
        }

        .text-center {
            text-align: center
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem
        }

        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem
        }

        .font-bold {
            font-weight: 700
        }

        .text-gray-200 {
            --tw-text-opacity: 1;
            color: rgb(229 231 235 / var(--tw-text-opacity))
        }

        .text-gray-800 font-bold {
            --tw-text-opacity: 1;
            color: rgb(209 213 219 / var(--tw-text-opacity))
        }

        .text-gray-400 {
            --tw-text-opacity: 1;
            color: rgb(156 163 175 / var(--tw-text-opacity))
        }

        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity))
        }

        .text-gray-900 font-bold {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity))
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }
    </style>
</head>

<body class="">
    <div class="mt-1">
        <h3 class="font-bold text-lg text-gray-200 text-center">{{ $tour->artist->name }}</h3>
    </div>
    <p class="text-xs text-gray-400">{{ $tour->notes }}</p>
    <div class="flex justify-around text-xs mt-2">
        <div class="flex rounded bg-app-primary-500 bg-opacity-40 py-1 px-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                stroke="rgb(204, 212, 249)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-calendar-plus">
                <path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                <line x1="16" x2="16" y1="2" y2="6" />
                <line x1="8" x2="8" y1="2" y2="6" />
                <line x1="3" x2="21" y1="10" y2="10" />
                <line x1="19" x2="19" y1="16" y2="22" />
                <line x1="16" x2="22" y1="19" y2="19" />
            </svg>
            <p class="ms-1 text-app-primary-100">Desde: {{ $tour->startdate }}</p>
        </div>
        <div class="flex rounded bg-app-primary-500 bg-opacity-40 py-1 px-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                stroke="rgb(204, 212, 249)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-calendar-check-2">
                <path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                <line x1="16" x2="16" y1="2" y2="6" />
                <line x1="8" x2="8" y1="2" y2="6" />
                <line x1="3" x2="21" y1="10" y2="10" />
                <path d="m16 20 2 2 4-4" />
            </svg>
            <p class="ms-1 text-app-primary-100">Hasta: {{ $tour->enddate }}</p>
        </div>
        <div class="my-3">
            @foreach ($itineraries as $activity)
                <article class="bg-white rounded-lg mb-1 border border-gray-700 w-full">
                    <div class="flex items-center w-full">
                        <div class="p-2 w-11/12 flex items-center">
                            {{-- <div class="me-2">
                                <ActivityIcon :activity="activity" />
                            </div> --}}
                            <div class="w-full">
                                <small class="float-right text-xs text-gray-400">
                                    {{ $activity->tour->tourname }}
                                </small>
                                <h3 class="text-gray-200 text-sm">{{ $activity->name }}</h3>
                                <p class="text-gray-400 text-xs">{{ $activity->notes }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full transition-all overflow-hidden px-4 p-2">
                        <div class="flex items-center mt-1">
                            <div class="ps-2">
                                <p class="text-gray-900 font-bold text-sm">Tipo de actividad</p>
                                <p class="text-gray-400 text-xs">{{ $activity->typeitinerary->description }}</p>
                            </div>
                        </div>
                        <hr class="my-2 border-gray-800" />
                        <div class="flex items-center w-full">

                            <div class="flex w-1/3 items-center mt-1">
                                <div>
                                    <p class="text-gray-900 font-bold text-sm">Fecha y hora de inicio</p>
                                    <p class="text-gray-400 text-xs">
                                        {{ $activity->startdate }}</p>
                                </div>
                            </div>
                            <hr class="my-2 border-gray-800" />
                            <div class="flex 1/3 justify-between items-center mt-2">
                                <div>
                                    <p class="text-gray-900 font-bold text-sm">Fecha y hora de fin</p>
                                    <p class="text-gray-400 text-xs">
                                        {{ $activity->enddate }}</p>
                                </div>
                            </div>

                        </div>
                        <hr class="my-2 border-gray-800" />
                        @if ($activity->typeitinerary_id == 1)
                            <div class="flex float-right w-1/3 items-center mt-1">
                                <div>
                                    <p class="text-gray-900 font-bold text-sm">Hora del show</p>
                                    <p class="text-gray-400 text-xs">{{ $activity->showtime }}</p>
                                </div>
                            </div>
                            <div class="flex w-1/3 items-center mt-1">
                                <div>
                                    <p class="text-gray-900 font-bold text-sm">Prueba de sonido</p>
                                    <p class="text-gray-400 text-xs">{{ $activity->showcheck }}</p>
                                </div>
                            </div>
                            <hr class="my-2 border-gray-800" />
                        @endif
                        @if (in_array($activity->typeitinerary_id, [1, 4, 6, 7, 8]))
                            <div class="flex items-center mt-1">
                                <div>
                                    <p v-if="Number(activity.typeitinerary_id) == 1"
                                        class="text-gray-900 font-bold text-sm">
                                        Encargado del show
                                    </p>
                                    <p v-else class="text-gray-900 font-bold text-sm">
                                        Encargado de transporte
                                    </p>
                                    <p class="text-gray-400 text-sm">{{ $activity->person->name }}</p>
                                </div>
                            </div>
                            <hr class="my-2 border-gray-800" />
                        @endif
                        @if (!in_array($activity->typeitinerary_id, [4, 8]))
                            <div class="flex items-center mt-1">
                                <div>
                                    <p class="text-gray-900 font-bold text-sm">Lugar</p>
                                    <p class="text-gray-400 text-xs">{{ $activity->place->name }}</p>
                                </div>
                            </div>
                            <hr class="my-2 border-gray-800" />
                        @endif
                        <div class="flex justify-between">
                            <div class="flex items-center mt-1">
                                <div>
                                    <p class="text-gray-900 font-bold text-sm">Ciudad de partida</p>
                                    <p class="text-gray-400 text-xs">{{ $activity->citystart->name }}
                                        ({{ $activity->citystart->code }})
                                    </p>
                                </div>
                            </div>
                            @if ($activity->typeitinerary_id == 6 || $activity->typeitinerary_id == 7)
                                <hr class="my-2 border-gray-800" />
                                <div class="flex items-center mt-1">
                                    <div>
                                        <p class="text-gray-900 font-bold text-sm">Ciudad de llegada</p>
                                        <p class="text-gray-400 text-xs">{{ $activity->cityend->name }}
                                            ({{ $activity->cityend->code }})</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
            <div class="p-2">
                <p class="text-sm text-gray-900 font-bold">Contactos</p>
                @foreach ($tour->persons as $person)
                    <article class="rounded-lg gradient-2 mb-1 border border-gray-700 w-full">
                        <div class="flex items-center w-full">
                            <div class="p-2 w-11/12 flex items-center">
                                <div class="w-full">
                                    <small class="float-right text-xs text-gray-400">
                                        {{ $person->typecontact->description }}
                                    </small>
                                    <h3 class="text-gray-200 text-sm">{{ $person->name }}</h3>
                                    <p class="text-gray-400 text-xs">{{ $person->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full transition-all overflow-hidden px-4 p-0">
                            <p class="text-gray-400 text-xs mb-2">{{ $person->notes }}</p>
                            <div class="w-full transition-all overflow-hidden p-2">
                                <div class="flex items-center my-1">
                                    <i class="bi bi-geo-alt text-lg me-2 text-gray-200"></i>
                                    <div>
                                        <h3 class="text-gray-800 font-bold">Nacionalidad</h3>
                                        <p class="text-sm text-gray-400">{{ $person->country->name }} </p>
                                    </div>
                                </div>
                                <hr class="bg-gray-500 text-gray-500" />
                                <div class="flex items-center my-1">
                                    <i class="bi bi-calendar-day text-lg me-2 text-gray-200"></i>
                                    <div>
                                        <h3 class="text-gray-800 font-bold">Fecha de nacimiento</h3>
                                        <p class="text-sm text-gray-400">{{ $person->birthday }}</p>
                                    </div>
                                </div>
                                <hr class="bg-gray-500 text-gray-500" />
                                <div class="flex items-center my-1">
                                    <i class="bi bi-telephone text-lg me-2 text-gray-200"></i>
                                    <div>
                                        <h3 class="text-gray-800 font-bold">Número de teléfono principal</h3>
                                        <p class="text-sm text-gray-400">{{ $person->phone }}</p>
                                    </div>
                                </div>
                                <hr class="bg-gray-500 text-gray-500" />
                                <div class="flex items-center my-1">
                                    <i class="bi bi-telephone text-lg me-2 text-gray-200"></i>
                                    <div>
                                        <h3 class="text-gray-800 font-bold">Número de teléfono secundario</h3>
                                        <p class="text-sm text-gray-400">{{ $person->extra_phone }}</p>
                                    </div>
                                </div>
                                <hr class="bg-gray-500 text-gray-500" />
                                <div class="flex items-center my-1">
                                    <i class="bi bi-telephone text-lg me-2 text-gray-200"></i>
                                    <div>
                                        <h3 class="text-gray-800 font-bold">Pasaporte</h3>
                                        <p class="text-sm text-gray-400">{{ $person->passport }} (Expira:
                                            {{ $person->passport_expiry }})</p>
                                    </div>
                                </div>
                                <hr class="bg-gray-500 text-gray-500" />
                                <div class="flex items-center my-1">
                                    <i v-if="person.notify_type == 'WhatsApp'"
                                        class="bi bi-whatsapp text-lg me-2 text-gray-200"></i>
                                    <i v-else-if="person.notify_type == 'Telegram'"
                                        class="bi bi-telegram text-lg me-2 text-gray-200"></i>
                                    <i v-else-if="person.notify_type == 'SMS'"
                                        class="bi bi-message text-lg me-2 text-gray-200"></i>
                                    <i v-else class="bi bi-envelope text-lg me-2 text-gray-200"></i>
                                    <div>
                                        <h3 class="text-gray-800 font-bold">Método de notificación</h3>
                                        <p class="text-sm text-gray-400">{{ $person->notify_type }}</p>
                                    </div>
                                </div>
                                <hr class="bg-gray-500 text-gray-500" />
                                <div class="flex items-center my-1">
                                    <i class="bi bi-telephone text-lg me-2 text-gray-200"></i>
                                    <div>
                                        <h3 class="text-gray-800 font-bold">Grupo</h3>
                                        <p class="text-sm text-gray-400">{{ $person->group->name }}</p>
                                    </div>
                                </div>
                                <hr class="bg-gray-500 text-gray-500" />
                                <div class="flex items-center my-1">
                                    <i class="bi bi-translate text-lg me-2 text-gray-200"></i>
                                    <div>
                                        <h3 class="text-gray-800 font-bold">Idioma</h3>
                                        <p class="text-sm text-gray-400">{{ $person->lang }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
                <div class="p-2">
                    <p class="text-sm text-gray-900 font-bold">Redes sociales</p>
                    <div class="mt-3 grid grid-cols-2">
                        @foreach ($tour->socialmedias as $socialmedia)
                            <a href="{{ $socialmedia->url }}" target="_blank"
                                class="px-3 rounded-md flex justify-center text-sky-500 font-bolditems-center me-1">
                                {{ $socialmedia->url }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
