<template x-if="modalOpen == true">
    <div class="relative">
        <div @click.away="modalOpen = false"
            class="form-modal fixed top-40 mx-auto shadow-lg rounded-md bg-white max-w-lg">

            <!-- Modal header -->
            <div class="flex justify-between items-center text-xl rounded-t-md px-4 py-2">
                <h3 class="font-medium">{{ $title }}</h3>
                <button @click="modalOpen = false">x</button>
            </div>

            <!-- Modal body -->
            <div class="max-h-fit overflow-y-auto px-4 py-10">
                {{ $slot }}
            </div>
        </div>
        <div class="flex fixed top-0 right-0 left-0 z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        </div>
    </div>


</template>