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
            <p style="color: #000; font-weight: bold; font-size: 1.05em">Supplier</p>
            <p style="color: #474747;font-size:.9em">{{ $activity->supplier->tradename }} ({{ $activity->supplier->taxname }})</p>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="position: relative; margin-bottom: .25rem">
        <div style="padding-left: 2rem">
            <p style="color: #000; font-weight: bold; font-size: 1.05em">Transportadora</p>
            <p style="color: #474747;font-size:.9em">{{ $activity->carrier }} ({{ $activity->carrier_id }})</p>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="width: 100%;">
        <div style="position: relative;">
            <div style="padding-left: 2rem">
                <p style="color: #000; font-weight: bold; font-size: 1.05em">Fecha y hora de partida</p>
                <p style="color: #474747;font-size:.9em">{{ $activity->startdate }}
                </p>
            </div>
        </div>
        <hr style="margin-top: .25rem; margin-bottom: .25rem" />
        <div style="position: relative;">
            <div style="padding-left: 2rem">
                <p style="color: #000; font-weight: bold; font-size: 1.05em">Fecha y hora de llegada</p>
                <p style="color: #474747;font-size:.9em">{{ $activity->enddate }}
                </p>
            </div>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="position: relative; margin-bottom: .25rem">
        <div style="padding-left: 2rem">
            <p style="color: #000; font-weight: bold; font-size: 1.05em">Ciudad de partida</p>
            <p style="color: #474747;font-size:.9em">{{ $activity->citystart->name }} ({{ $activity->citystart->code }})</p>
        </div>
    </div>
    <hr style="margin-top: .25rem; margin-bottom: .25rem" />
    <div style="position: relative; margin-bottom: .25rem">
        <div style="padding-left: 2rem">
            <p style="color: #000; font-weight: bold; font-size: 1.05em">Ciudad de llegada</p>
            <p style="color: #474747;font-size:.9em">{{ $activity->cityend->name }} ({{ $activity->cityend->code }})</p>
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
