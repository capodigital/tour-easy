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
    </style>
</head>

<body>
    <p style="text-align: center; margin-bottom: 1rem">
        <img style="height:15px;"
            src="data:image/svg+xml;base64,'
                    {{ base64_encode('<svg width="100%" height="100%" viewBox="0 0 1024 768" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"><g transform="matrix(1.69495,0,0,1.69495,-194.649,-236.134)"> <g transform="matrix(1.33333,0,0,1.33333,519.58,143.205)"> <path d="M0,334L-153.998,334C-203.704,334 -243.999,293.705 -243.999,243.999L-243.999,90.001C-243.999,40.295 -203.704,0 -153.998,0L0,0C49.706,0 90.001,40.295 90.001,90.001L90.001,243.999C90.001,293.705 49.706,334 0,334" style="fill:rgb(218,255,0);fill-rule:nonzero;"/> </g> <g transform="matrix(1.33333,0,0,1.33333,568.447,460.93)"> <path d="M0,-11.732C-7.166,-16.706 -14.38,-21.614 -21.602,-26.51C-24.813,-28.688 -27.239,-28.61 -30.566,-26.397C-34.743,-23.619 -38.911,-20.828 -43.102,-18.073C-47.165,-15.402 -48.036,-15.539 -51.504,-18.66C-52.48,-19.539 -53.791,-20.524 -55.009,-20.575C-59.237,-20.753 -63.485,-20.604 -67.677,-20.551L-67.677,9.411C-64.791,9.313 -61.891,9.148 -59.01,9.264C-55.923,9.389 -53.361,8.797 -51.159,6.322C-49.201,4.121 -46.898,4.193 -44.518,5.885C-40.097,9.028 -35.564,12.014 -31.092,15.086C-28.533,16.845 -25.848,16.956 -23.225,15.234C-15.479,10.151 -7.742,5.05 -0.103,-0.194C4.439,-3.311 4.436,-8.653 0,-11.732" style="fill:rgb(38,38,38);fill-rule:nonzero;"/> </g> <g transform="matrix(1.33333,0,0,1.33333,431.237,398.938)"> <path d="M0,-29.418C-1.218,-29.367 -2.529,-28.382 -3.505,-27.503C-6.973,-24.382 -7.844,-24.245 -11.907,-26.916C-16.098,-29.671 -20.266,-32.462 -24.443,-35.24C-27.77,-37.453 -30.196,-37.531 -33.407,-35.353C-40.629,-30.457 -47.843,-25.549 -55.009,-20.575C-59.445,-17.496 -59.448,-12.155 -54.906,-9.037C-47.267,-3.793 -39.53,1.308 -31.784,6.391C-29.161,8.113 -26.476,8.001 -23.917,6.243C-19.445,3.171 -14.912,0.184 -10.491,-2.958C-8.111,-4.65 -5.808,-4.722 -3.85,-2.521C-1.95,-0.386 0.218,0.346 2.76,0.427C2.76,0.498 2.764,0.569 2.763,0.64L11.515,0.64L11.515,-29.411C7.698,-29.473 3.841,-29.58 0,-29.418" style="fill:rgb(38,38,38);fill-rule:nonzero;"/> </g> <g transform="matrix(1.33333,0,0,1.33333,578.712,427.235)"> <path d="M0,-99.051C-3.002,-105.912 -7.008,-111.915 -12.006,-117.06C-17.011,-122.206 -22.94,-126.279 -29.801,-129.281C-36.662,-132.282 -43.951,-133.783 -51.669,-133.783L-162.726,-133.783C-174.45,-133.783 -185.452,-131.565 -195.743,-127.137C-206.034,-122.701 -214.971,-116.698 -222.542,-109.128C-230.12,-101.55 -236.123,-92.619 -240.551,-82.328C-244.987,-72.037 -247.197,-61.029 -247.197,-49.311C-247.197,-37.875 -244.987,-27.015 -240.551,-16.723C-236.123,-6.432 -230.12,2.506 -222.542,10.076C-214.971,17.654 -206.034,23.657 -195.743,28.085C-185.452,32.521 -174.45,34.732 -162.726,34.732L-79.327,34.732L-79.327,5.145L-162.726,5.145C-170.163,5.145 -177.164,3.718 -183.737,0.857C-190.316,-1.997 -196.105,-5.93 -201.103,-10.934C-206.107,-15.933 -210.04,-21.721 -212.894,-28.301C-215.755,-34.873 -217.182,-41.874 -217.182,-49.311C-217.182,-57.03 -215.755,-64.172 -212.894,-70.751C-210.04,-77.323 -206.107,-83.038 -201.103,-87.902C-196.105,-92.76 -190.316,-96.619 -183.737,-99.48C-177.164,-102.334 -170.163,-103.768 -162.726,-103.768L-51.669,-103.768C-44.239,-103.768 -37.948,-101.195 -32.802,-96.05C-27.657,-90.904 -25.084,-84.613 -25.084,-77.183C-25.084,-69.746 -27.657,-63.461 -32.802,-58.316C-37.948,-53.17 -44.239,-50.598 -51.669,-50.598L-95.138,-50.598L-95.138,-20.583L-51.669,-20.583C-43.951,-20.583 -36.662,-22.083 -29.801,-25.085C-22.94,-28.086 -17.011,-32.16 -12.006,-37.305C-7.008,-42.451 -3.002,-48.454 0,-55.314C3.002,-62.175 4.502,-69.465 4.502,-77.183C4.502,-84.901 3.002,-92.19 0,-99.051" style="fill:rgb(38,38,38);fill-rule:nonzero;"/> </g> </g> </svg>') }} " />
            <p style="margin-top: 0; text-align: center; font-weight: bold; padding-left: 1.75rem">MAD MUSIC</p>
    </p>
    <div>
        <h3 style="font-weight: bold; text-align: center; font-size: 1.3em">{{ $tour->artist->name }}</h3>
    </div>
    <p class="text-xs text-gray-400">{{ $tour->notes }}</p>
    <div style="padding-top: .5rem">
        <div style="position: relative;float: right; width: 40%">
            <img style="position: absolute; top: .35rem; height:15px"
                src="data:image/svg+xml;base64,'
                    {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-plus"> <path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" /> <line x1="16" x2="16" y1="2" y2="6" /> <line x1="8" x2="8" y1="2" y2="6" /> <line x1="3" x2="21" y1="10" y2="10" /> <line x1="19" x2="19" y1="16" y2="22" /> <line x1="16" x2="22" y1="19" y2="19" /></svg>') }} " />
            <p style="font-size: 1em; padding-left: 1.1rem">Desde: {{ $tour->startdate }}</p>
        </div>
        <div style="position: relative;width: 40%;padding-left: 2rem">
            <img style="position: absolute; top: .35rem; height:15px"
                src="data:image/svg+xml;base64,'
                    {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-plus"> <path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" /> <line x1="16" x2="16" y1="2" y2="6" /> <line x1="8" x2="8" y1="2" y2="6" /> <line x1="3" x2="21" y1="10" y2="10" /> <line x1="19" x2="19" y1="16" y2="22" /> <line x1="16" x2="22" y1="19" y2="19" /></svg>') }} " />
            <p style="font-size: 1em; padding-left: 1.1rem">Desde: {{ $tour->startdate }}</p>
        </div>
    </div>


    <div class="my-3">
        <p style="text-align: center">
            <span
                style="margin: auto; font-size: 1em; background: #000; color: #fff; padding: .25rem .5rem; border-radius: .25rem; margin-top: 2rem">Itinerarios</span>
        </p>
        @foreach ($itineraries as $activity)
            <div style="padding-top:.25rem; padding-bottom:.25rem">
                <p class="color: #000"><strong>{{ $activity->name }}:</strong> {{ $activity->notes }}</p>
                <hr style="margin-top: .25rem; margin-bottom: .25rem" />
                @switch($activity->typeitinerary_id)
                    @case(1)
                    @case(2)
                        @include('print.fly', [
                            'activity' => $activity,
                            'persons_1' => $activity->persons()->wherePivot('type', 1)->get(),
                            'persons_2' => $activity->persons()->wherePivot('type', 2)->get(),
                        ])
                    @break

                    @case(3)
                        @include('print.transfer', [
                            'activity' => $activity,
                            'persons_1' => $activity->persons()->wherePivot('type', 1)->get(),
                            'persons_2' => $activity->persons()->wherePivot('type', 2)->get(),
                        ])
                    @break

                    @case(4)
                        @include('print.bus', [
                            'activity' => $activity,
                            'persons_1' => $activity->persons()->wherePivot('type', 1)->get(),
                            'persons_2' => $activity->persons()->wherePivot('type', 2)->get(),
                        ])
                    @break

                    @case(5)
                        @include('print.train', [
                            'activity' => $activity,
                            'persons_1' => $activity->persons()->wherePivot('type', 1)->get(),
                            'persons_2' => $activity->persons()->wherePivot('type', 2)->get(),
                        ])
                    @break

                    @case(6)
                        @include('print.hotel', [
                            'activity' => $activity,
                            'persons_1' => $activity->persons()->wherePivot('type', 1)->get(),
                            'persons_2' => $activity->persons()->wherePivot('type', 2)->get(),
                        ])
                    @break

                    @case(7)
                        @include('print.show', [
                            'activity' => $activity,
                            'persons_1' => $activity->persons()->wherePivot('type', 1)->get(),
                            'persons_2' => $activity->persons()->wherePivot('type', 2)->get(),
                        ])
                    @break

                    @case(8)
                    @case(9)
                        @include('print.activity', [
                            'activity' => $activity,
                            'persons_1' => $activity->persons()->wherePivot('type', 1)->get(),
                            'persons_2' => $activity->persons()->wherePivot('type', 2)->get(),
                        ])
                    @break
                @endswitch
            </div>
        @endforeach
        <p style="text-align: center; margin-top: 1rem; margin-bottom: .5rem">
            <span
                style="margin: auto; font-size: 1em; background: #000; color: #fff; padding: .25rem .5rem; border-radius: .25rem; margin-top: 2rem">Personal
                de la gira</span>
        </p>
        @foreach ($tour->persons as $person)
            @include('print.contact', ['person' => $person])
        @endforeach
    </div>
</body>

</html>
