<x-admin-layout>
    <x-slot name="header">
        <h1 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Edit category') }}
        </h1>
    </x-slot>

    <div class="pt-8 pb-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pb-12">

                <h2 class="text-lg md:text-xl font-bold text-gray-900 px-6 mt-5 mb-5">
                    {{ $category->name }}
                </h2>

                <form action="{{ route('category.update', $category->id)}}" method="POST"
                    enctype="application/x-www-form-urlencoded" accept-charset="UTF-8"
                    autocomplete="off" class="px-6 w-full relative">
                    @method("PUT")
                    @csrf

                    <x-jet-validation-errors class="mb-4" />

                    <div class="mb-5">
                        <x-jet-label for="name" value="{{ __('Category name') }}" />
                        <x-jet-input id="name"
                            class="block mt-1 bg-gray-50 w-full {{ $errors->has('name') ? ' border-rose-400' : '' }}"
                            type="text" name="name" :value="old('name') ?? $category->name"
                            autofocus />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>

                    <div>
                        <x-jet-button type="submit" class="update-button">{{ __("Update") }}
                        </x-jet-button>

                        <a href="{{ route('dashboard')}}"
                            class="cancel-button">{{ __('Cancel') }}</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-admin-layout>