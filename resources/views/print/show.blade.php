<article>
    <div style="position: relative">
        @include('print.activity-icon', ['activity' => $activity])
        <div style="padding-left: 2rem">
            <p style="color: #000000; font-weight: bold; font-size: 1.05em">Tipo de itinerario</p>
            <p style="color: #474747;font-size:.9em">{{ $activity->typeitinerary->description }}</p>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="width: 100%;">
        <div style="position: relative;">
            <div style="padding-left: 2rem">
                <p style="color: #000; font-weight: bold; font-size: 1.05em">Fecha y hora del show</p>
                <p style="color: #474747;font-size:.9em">{{ $activity->startdate }}
                </p>
            </div>
        </div>

        <hr style="margin-top: .25rem; margin-bottom: .25rem" />

        <div style="position: relative;">
            <div style="padding-left: 2rem">
                <p style="color: #000; font-weight: bold; font-size: 1.05em">Fecha y hora de fin del show</p>
                <p style="color: #474747;font-size:.9em">{{ $activity->enddate }}
                </p>
            </div>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="position: relative; margin-bottom: .25rem">
        <div style="padding-left: 2rem">
            <p style="color: #000; font-weight: bold; font-size: 1.05em">Recinto</p>
            <p style="color: #474747;font-size:.9em">{{ $activity->place->name }}</p>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="position: relative; margin-bottom: .25rem">
        <div style="padding-left: 2rem">
            <p style="color: #000; font-weight: bold; font-size: 1.05em">Prueba de sonido</p>
            <p style="color: #474747;font-size:.9em">{{ $activity->showcheck }}</p>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="position: relative; margin-bottom: .25rem">
        <div style="padding-left: 2rem">
            <p style="color: #000; font-weight: bold; font-size: 1.05em">Apertura de puertas</p>
            <p style="color: #474747;font-size:.9em">{{ $activity->showtime }}</p>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="position: relative; margin-bottom: .25rem;margin-bottom: .5rem">
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
