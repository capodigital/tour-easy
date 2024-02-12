<div>
    @switch($activity->typeitinerary_id)
        @case(1)
        @case(2)
            <img style="position: absolute; top: .1rem; height:20px"
                src="data:image/svg+xml;base64,'
                    {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plane-takeoff"> <path d="M2 22h20" /> <path d="M6.36 17.4 4 17l-2-4 1.1-.55a2 2 0 0 1 1.8 0l.17.1a2 2 0 0 0 1.8 0L8 12 5 6l.9-.45a2 2 0 0 1 2.09.2l4.02 3a2 2 0 0 0 2.1.2l4.19-2.06a2.41 2.41 0 0 1 1.73-.17L21 7a1.4 1.4 0 0 1 .87 1.99l-.38.76c-.23.46-.6.84-1.07 1.08L7.58 17.2a2 2 0 0 1-1.22.18Z" /> </svg>') }} " />
        @break

        @case(3)
        @case(4)
            <img style="position: absolute; top: .1rem; height:20px"
                src="data:image/svg+xml;base64,'
                {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bus"> <path d="M8 6v6" /> <path d="M15 6v6" /> <path d="M2 12h19.6" /> <path d="M18 18h3s.5-1.7.8-2.8c.1-.4.2-.8.2-1.2 0-.4-.1-.8-.2-1.2l-1.4-5C20.1 6.8 19.1 6 18 6H4a2 2 0 0 0-2 2v10h3" /> <circle cx="7" cy="18" r="2" /> <path d="M9 18h5" /> <circle cx="16" cy="18" r="2" /></svg>') }} " />
        @break

        @case(5)
            <img style="position: absolute; top: .1rem; height:20px"
                src="data:image/svg+xml;base64,'
                {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-train-front"> <path d="M8 3.1V7a4 4 0 0 0 8 0V3.1" /> <path d="m9 15-1-1" /> <path d="m15 15 1-1" /> <path d="M9 19c-2.8 0-5-2.2-5-5v-4a8 8 0 0 1 16 0v4c0 2.8-2.2 5-5 5Z" /> <path d="m8 19-2 3" /> <path d="m16 19 2 3" /></svg>') }} " />
        @break

        @case(6)
            <img style="position: absolute; top: .1rem; height:20px"
                src="data:image/svg+xml;base64,'
                {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hotel"> <path d="M18 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2Z" /> <path d="m9 16 .348-.24c1.465-1.013 3.84-1.013 5.304 0L15 16" /> <path d="M8 7h.01" /> <path d="M16 7h.01" /> <path d="M12 7h.01" /> <path d="M12 11h.01" /> <path d="M16 11h.01" /> <path d="M8 11h.01" /> <path d="M10 22v-6.5m4 0V22" /></svg>') }} " />
        @break

        @case(7)
            <img style="position: absolute; top: .1rem; height:20px"
                src="data:image/svg+xml;base64,'
                {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-theater"> <path d="M2 10s3-3 3-8" /> <path d="M22 10s-3-3-3-8" /> <path d="M10 2c0 4.4-3.6 8-8 8" /> <path d="M14 2c0 4.4 3.6 8 8 8" /> <path d="M2 10s2 2 2 5" /> <path d="M22 10s-2 2-2 5" /> <path d="M8 15h8" /> <path d="M2 22v-1a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1" /> <path d="M14 22v-1a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1" /></svg>') }} " />
        @break

        @case(8)
            <img style="position: absolute; top: .1rem; height:20px"
                src="data:image/svg+xml;base64,'
                {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clapperboard"> <path d="M20.2 6 3 11l-.9-2.4c-.3-1.1.3-2.2 1.3-2.5l13.5-4c1.1-.3 2.2.3 2.5 1.3Z" /> <path d="m6.2 5.3 3.1 3.9" /> <path d="m12.4 3.4 3.1 4" /> <path d="M3 11h18v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z" /></svg>') }} " />
        @break

        @case(9)
            <img style="position: absolute; top: .1rem; height:20px"
                src="data:image/svg+xml;base64,'
                {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users"> <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /> <circle cx="9" cy="7" r="4" /> <path d="M22 21v-2a4 4 0 0 0-3-3.87" /> <path d="M16 3.13a4 4 0 0 1 0 7.75" /></svg>') }} " />
        @break
    @endswitch
</div>
