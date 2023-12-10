<template>
    <div>
        <nav class="w-screen h-16 flex items-center shadow-lg shadow-gray-300 bg-white">
            <div class="px-2">
                <img src="src/logo.svg" class="h-12 w-12" />
            </div>
        </nav>
        <main>
            <div class="grid grid-cols-3 gap-x-3 p-3">
                <div>

                </div>
                <div>
                    <h1
                        class="font-bold bg-gradient-to-tr text-center from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                        VIDEOS POPULARES</h1>
                    <iframe width="100%" height="525" style="border-radius: 1rem;"
                    src="https://www.youtube.com/embed/videoseries?si=iwRuGQ0Kd2n9Xb12&amp;list=PLRW7iEDD9RDR3nExwJcID9uzkHI3y53YX"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
                </div>
                <div>
                    <h1
                        class="font-bold bg-gradient-to-tr text-center from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                        PLAYLIST</h1>
                    <iframe style="border-radius:12px"
                        src="https://open.spotify.com/embed/playlist/04qRJ1mdnlkBAAlDTJfeAa?utm_source=generator&theme=0"
                        width="100%" height="525" frameBorder="0" allowfullscreen=""
                        allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                        loading="lazy"></iframe>

                </div>
            </div>

        </main>
    </div>
</template>
<style>h1 {
    font-family: 'Archivo Black', sans-serif;
}</style>
