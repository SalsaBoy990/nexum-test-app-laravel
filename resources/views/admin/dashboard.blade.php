<x-admin-layout>
    <x-slot name="header">
        <h1 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <div class="pt-6 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <h2 class="font-bold text-lg mb-6">Dokumentum-kezelő alkalmazás</h2>


                <ul id="categries-tree" class="text-gray-900 w-full">
                    <li>/</li>
                    @foreach ($categories as $category)
                    <li class="bg-gray-100 inline-block w-full pb-1">
                        <span class="flex flex-row gap-x-1 pl-6 py-4 font-bold items-center">
                            <span class="caret"></span>
                            {{ $category->name }}
                            <small class="px-2 text-gray-500">id = {{ $category->id }}</small>

                            <div class="flex flex-row items-center gap-x-2">
                                <div x-data="{ modalOpen: false }">
                                    <button class="edit-button" @click="modalOpen = true"
                                        title="Szerkeszt">
                                        <x-icon.edit></x-icon.edit>
                                    </button>

                                    <x-admin.modal :title="$category->name">
                                        <form action="{{ route('category.update', $category->id)}}"
                                            method="POST"
                                            enctype="application/x-www-form-urlencoded"
                                            accept-charset="UTF-8" autocomplete="off"
                                            class="flex flex-col sm:flex-row gap-2">
                                            @method("PUT")
                                            @csrf

                                            <input type="text" class="input-control" name="name"
                                                value="{{ old('name') ?? $category->name }}">

                                            <x-jet-button type="submit" class="update-button">
                                                {{ __("Mentés") }}
                                            </x-jet-button>
                                        </form>
                                    </x-admin.modal>
                                </div>

                                <div x-data="{ modalOpen: false }">
                                    <x-jet-danger-button type="button" class="text-xs"
                                        title="Törlés" @click="modalOpen = true">
                                        <x-icon.trash></x-icon.trash>
                                    </x-jet-danger-button>
                                    <x-admin.modal :title="'Biztosan törölni akarod?'">
                                        <form
                                            action="{{ route('category.destroy', $category->id) }}"
                                            enctype="application/x-www-form-urlencoded"
                                            accept-charset="UTF-8" autocomplete="off"
                                            class="flex flex-col gap-2"
                                            method="post">
                                            @csrf
                                            @method('delete')

                                            <div class="pb-4 font-bold">{{ $category->name }}
                                            </div>
                                            <x-jet-danger-button type="submit" class="text-xs px-2"
                                                title="Törlés">
                                                Törlés
                                            </x-jet-danger-button>
                                        </form>
                                    </x-admin.modal>
                                </div>

                            </div>
                        </span>

                        <ul class="pl-6 w-full nested">
                            @foreach ($category->childrenCategories as $childCategory)
                            <x-child-category-list :childCategory="$childCategory">
                            </x-child-category-list>
                            @endforeach
                            <li class="pl-6 mt-4">
                                <div x-data="{ modalOpen: false }" class="z-50">
                                    <button @click="modalOpen = true" class="icon-button">
                                        <x-icon.add></x-icon.add>Új
                                    </button>

                                    <x-admin.modal :title="'Alategória hozzáadása'">
                                        <form action="{{ route('category.store') }}" method="post"
                                            enctype="application/x-www-form-urlencoded"
                                            accept-charset="UTF-8" autocomplete="off"
                                            class="flex flex-col sm:flex-row gap-2">
                                            @csrf
                                            @method('post')

                                            <input type="number" class="hidden" name="category_id"
                                                value="{{ intval($category->id) }}">
                                            <input type="text" class="input-control" name="name"
                                                value="" placeholder="alkategória neve">
                                            <button type="submit" class="button">
                                                Hozzáadás
                                            </button>
                                        </form>
                                    </x-admin.modal>
                                </div>

                            </li>
                        </ul>
                    </li>
                    @endforeach
                    <li class="pl-6 mt-4">
                        <div x-data="{ modalOpen: false }" class="z-50">
                            <button @click="modalOpen = true" class="icon-button">
                                <x-icon.add></x-icon.add>Új
                            </button>

                            <x-admin.modal :title="'Kategória hozzáadása'">
                                <form action="{{ route('category.store') }}" method="post"

                                    class="flex flex-col sm:flex-row gap-2">
                                    @csrf
                                    @method('post')

                                    <input type="text" class="input-control" name="name" value=""
                                        placeholder="kategória neve">
                                    <button type="submit" class="button">
                                        Hozzáadás
                                    </button>
                                </form>
                            </x-admin.modal>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-admin-layout>