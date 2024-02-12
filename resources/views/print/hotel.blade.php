<article>
    <div style="position: relative">
        @include('print.activity-icon', ['activity' => $activity])
        <div style="padding-left: 2rem">
            <p style="color: #000000; font-weight: bold; font-size: 1.05em">Tipo de itinerario</p>
            <p style="color: #474747;font-size:.9em">{{ $activity->typeitinerary->description }}</p>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="position: relative; margin-bottom: .25rem">
        <div style="padding-left: 2rem">
            <p style="color: #000; font-weight: bold; font-size: 1.05em">Hotel</p>
            <p style="color: #474747;font-size:.9em">{{ $activity->place->name }}</p>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="width: 100%;">
        <div style="position: relative;">
            <div style="padding-left: 2rem">
                <p style="color: #000; font-weight: bold; font-size: 1.05em">Fecha y hora de llegada</p>
                <p style="color: #474747;font-size:.9em">{{ $activity->startdate }}
                </p>
            </div>
        </div>

        <hr style="margin-top: .25rem; margin-bottom: .25rem" />

        <div style="position: relative;">
            <div style="padding-left: 2rem">
                <p style="color: #000; font-weight: bold; font-size: 1.05em">Fecha y hora de salida</p>
                <p style="color: #474747;font-size:.9em">{{ $activity->enddate }}
                </p>
            </div>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="position: relative; margin-bottom: .25rem">
        <div style="padding-left: 2rem">
            <p style="color: #000; font-weight: bold; font-size: 1.05em">Ciudad</p>
            <p style="color: #474747;font-size:.9em">{{ $activity->citystart->name }} ({{ $activity->citystart->code }})</p>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="position: relative; margin-bottom: .25rem">
        <img style="position: absolute; top: .1rem; height:20px"
            src="data:image/svg+xml;base64,'
                {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plane me-2"> <pathd="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z" /></svg>') }} " />
        <div style="padding-left: 2rem">
            <p style="color: #000; font-weight: bold; font-size: 1.05em">Ciudad</p>
            <p style="color: #474747;font-size:.9em">{{ $activity->citystart->name }} ({{ $activity->citystart->code }})</p>
        </div>
    </div>
    <span
        style="font-size: .9em; background: #414141; color: #fff; padding: .25rem .5rem; border-radius: .25rem; margin-top: 2rem">Personas
        resposables</span>
    <div style="margin-bottom: .5rem; margin-top: .5rem">
        @foreach ($persons_1 as $person)
            @include('print.contact', ['person' => $person])
        @endforeach
        @if (count($persons_1) == 0)
            <div>
                <p style="color: #a7a7a7; text-align: center">No hay personas resposables</p>
            </div>
        @endif
    </div>
    <span
        style="font-size: .9em; background: #414141; color: #fff; padding: .25rem .5rem; border-radius: .25rem; margin-top: 2rem">Personas
        asociadas</span>
    <div class="mt-2">
        @foreach ($persons_2 as $person)
            @include('print.contact', ['person' => $person])
        @endforeach
        @if (count($persons_2) == 0)
            <div>
                <p style="color: #a7a7a7; text-align: center">No hay personas asociadas</p>
            </div>
        @endif
    </div>
    <hr style="border: solid 1px rgb(107 114 128); margin-top: .25rem; margin-bottom: .25rem" />
</article>
