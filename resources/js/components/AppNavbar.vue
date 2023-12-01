<template>
    <nav class="w-screen h-16 flex items-center shadow-lg shadow-gray-300 bg-white">
        <div class="px-2">
            <img src="src/logo.svg" class="h-12 w-12" />
        </div>
        <div class="flex items-center w-full justify-end px-1">
            <div
                class="relative p-2 hover:bg-slate-800 hover:bg-opacity-25 transition-all flex rounded me-2"
            >
            </div>
            <div
                class="relative p-2 group hover:bg-gradient-to-tr hover:from-slate-800 hover:to-slate-950 hover:bg-opacity-90 transition-all flex rounded"
            >
                <div
                    class="w-0 group-hover:w-52 transition-all overflow-hidden px-0 group-hover:px-2"
                >
                    <h5
                        class="whitespace-nowrap font-bold text-slate-900 leading-5 text-end group-hover:text-white mt-1"
                    >
                        Ana Maris López
                    </h5>
                    <p
                        class="whitespace-nowrap text-slate-700 leading-4 text-sm text-end group-hover:text-gray-200"
                    >
                        anamarislopez@hotmail.com
                    </p>
                </div>
                <img
                    src="src/user_4.jpg"
                    class="rounded-full h-10 w-10 cursor-pointer me-2"
                />
                <span
                    class="w-4 h-4 flex items-center justify-center rounded-full bg-red-600 text-white absolute text-center text-xs font-semibold"
                    style="top: .2rem; right: .2rem"
                    >4</span
                >
            </div>
        </div>
    </nav>
</template>
