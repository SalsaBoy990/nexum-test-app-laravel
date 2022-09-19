<x-admin-layout>
    <x-slot name="header">
        <h1 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Dokumentum-kezelő alkalmazás') }}
        </h1>
    </x-slot>

    <div class="pt-6 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">

                <section>
                    <h2 class="font-bold text-2xl mb-6">Kategóriák</h2>

                    <ul id="categries-tree" class="text-gray-900 w-full">
                        <li>/</li>
                        @foreach ($categories as $category)
                        <li class="bg-gray-100 inline-block w-full pb-1">
                            <span
                                class="flex flex-row gap-x-1 pl-6 py-4 font-bold justify-between border-b border-t border-gray-200 items-center {{ $selectedCategory->id === $category->id ? 'active-category' : '' }}">
                                <div class="flex align-center">
                                    @if (count($category->categories) > 0)
                                    <span class="caret caret-down"></span>
                                    @endif
                                    <h2>
                                        <a href="{{ route('category.selected', $category->id)}}">
                                            {{ $category->name }}
                                        </a>
                                    </h2>
                                    <small class="px-2 text-gray-500">id =
                                        {{ $category->id }}</small>
                                </div>
                                <div class="flex flex-row items-center gap-x-2 mr-4">
                                    <div x-data="{ modalOpen: false }">
                                        <button class="edit-button" @click="modalOpen = true">
                                            <x-icon.edit></x-icon.edit>Szerkeszt
                                        </button>

                                        <x-admin.modal :title="$category->name">
                                            <form
                                                action="{{ route('category.update', $category->id)}}"
                                                method="POST"
                                                enctype="application/x-www-form-urlencoded"
                                                accept-charset="UTF-8" autocomplete="off"
                                                class="flex flex-col gap-2">
                                                @method("PUT")
                                                @csrf

                                                <input type="text" class="input-control" name="name"
                                                    value="{{ old('name') ?? $category->name }}">

                                                <button type="submit" class="button">
                                                    {{ __("Mentés") }}
                                                </button>
                                            </form>
                                        </x-admin.modal>
                                    </div>

                                    <div x-data="{ modalOpen: false }">
                                        <x-jet-danger-button type="button" class="text-xs px-2"
                                            title="Törlés" @click="modalOpen = true">
                                            <x-icon.trash></x-icon.trash>Töröl
                                        </x-jet-danger-button>
                                        <x-admin.modal :title="'Biztosan törölni akarod?'">
                                            <form
                                                action="{{ route('category.destroy', $category->id) }}"
                                                enctype="application/x-www-form-urlencoded"
                                                accept-charset="UTF-8" autocomplete="off"
                                                class="flex flex-col gap-2" method="post">
                                                @csrf
                                                @method('delete')

                                                <div class="pb-4 font-bold">{{ $category->name }}
                                                </div>
                                                <x-jet-danger-button type="submit"
                                                    class="text-xs px-2" title="Törlés">
                                                    Törlés
                                                </x-jet-danger-button>
                                            </form>
                                        </x-admin.modal>
                                    </div>

                                    <div x-data="{ modalOpen: false }">
                                        <button @click="modalOpen = true" class="icon-button">
                                            <x-icon.add></x-icon.add>Új
                                        </button>

                                        <x-admin.modal :title="'Alkategória hozzáadása'">
                                            <form action="{{ route('category.store') }}"
                                                method="post"
                                                enctype="application/x-www-form-urlencoded"
                                                accept-charset="UTF-8" autocomplete="off"
                                                class="flex flex-col gap-2">
                                                @csrf
                                                @method('post')

                                                <input type="number" class="hidden"
                                                    name="category_id"
                                                    value="{{ intval($category->id) }}">
                                                <input type="text" class="input-control" name="name"
                                                    value="" placeholder="alkategória neve">
                                                <button type="submit" class="button">
                                                    Hozzáad
                                                </button>
                                            </form>
                                        </x-admin.modal>
                                    </div>

                                    <div x-data="{ modalOpen: false }">
                                        <button @click="modalOpen = true" class="upload-button">
                                            <x-icon.upload></x-icon.upload>Dokumentum
                                        </button>

                                        <x-admin.modal :title="'Dokumentum hozzáadása'">
                                            <form
                                                action="{{ route('document.store', $category->id)}}"
                                                method="POST" enctype="multipart/form-data"
                                                accept-charset="UTF-8" autocomplete="off"
                                                class="flex flex-col gap-2">
                                                @method("POST")
                                                @csrf

                                                <div class="mb-5">
                                                    <x-jet-label for="view_name"
                                                        value="{{ __('Megjelenő név*') }}" />
                                                    <x-jet-input id="view_name"
                                                        class="block mt-1 bg-gray-50 w-full {{ $errors->has('view_name') ? ' border-rose-400' : '' }}"
                                                        type="text" name="view_name"
                                                        :value="old('view_name')" autofocus />
                                                    <x-jet-input-error for="view_name"
                                                        class="mt-2" />
                                                </div>

                                                <input type="number" class="hidden"
                                                    name="category_id"
                                                    value="{{ intval($category->id) }}">

                                                <div class="flex flex-col md:flex-row">
                                                    <div class="mb-5">

                                                        <x-jet-label for="file_path"
                                                            value="{{ __('Fájl feltöltése*') }}" />

                                                        <div class="mb-3 mt-1 w-96">
                                                            <input
                                                                class="form-control block w-full px-3 py-1.5
                                                                text-sm font-normal
                                                                text-gray-700
                                                                bg-white bg-clip-padding border border-solid 
                                                                {{ $errors->has('file_path') ? ' border-rose-400' : 'border-gray-300' }} 
                                                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                                                type="file" id="file_path"
                                                                name="file_path" autofocus>
                                                        </div>
                                                        <x-jet-input-error for="file_path"
                                                            class="mt-2" />
                                                    </div>
                                                </div>

                                                <button type="submit" class="button">
                                                    Hozzáadás
                                                </button>

                                            </form>
                                        </x-admin.modal>
                                    </div>

                                    <div class="ml-4 flex flex-row gap-x-4">
                                        @can('authorize_upload_to_category', $category)
                                        <form
                                            action="{{ route('permission.upload.detach', ['category' => $category->id, 'user' => auth()->user()->id ])}}">
                                            @method('get')
                                            @csrf

                                            <label for="" class="text-sm">
                                                <input type="checkbox" name="" id=""
                                                    class="inactive-checkbox checked" checked
                                                    disabled>
                                                Feltöltés
                                            </label>
                                            <button class="text-sm button ml-1">
                                                Tiltás
                                            </button>
                                        </form>

                                        @else

                                        <form
                                            action="{{ route('permission.upload.attach', ['category' => $category->id, 'user' => auth()->user()->id ])}}">
                                            @method('get')
                                            @csrf

                                            <label for="" class="text-sm">
                                                <input type="checkbox" name="" id=""
                                                    class="inactive-checkbox" disabled>
                                                Feltöltés
                                            </label>

                                            <button class="text-sm button ml-1">
                                                Enged
                                            </button>
                                        </form>

                                        @endcan

                                        @can('authorize_download_from_category', $category)

                                        <form
                                            action="{{ route('permission.download.detach', ['category' => $category->id, 'user' => auth()->user()->id ])}}">
                                            @method('get')
                                            @csrf

                                            <label for="" class="text-sm">
                                                <input type="checkbox" name="" id=""
                                                    class="inactive-checkbox checked" disabled
                                                    checked>
                                                Letöltés
                                            </label>

                                            <button class="text-sm button ml-1">
                                                Tiltás
                                            </button>
                                        </form>
                                        @else
                                        <form
                                            action="{{ route('permission.download.attach', ['category' => $category->id, 'user' => auth()->user()->id ])}}">
                                            @method('get')
                                            @csrf
                                            <label for="" class="text-sm">
                                                <input type="checkbox" name="" id=""
                                                    class="inactive-checkbox" disabled>
                                                Letöltés
                                            </label>
                                            <button class="text-sm button ml-1">Enged</button>
                                        </form>
                                        @endcan

                                    </div>

                                </div>
                            </span>

                            <ul class="pl-6 w-full nested active">
                                @foreach ($category->childrenCategories as $childCategory)
                                <x-child-category-list :childCategory="$childCategory"
                                    :selectedCategory="$selectedCategory">
                                </x-child-category-list>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                        <li class="pl-6 mt-4">
                            <div x-data="{ modalOpen: false }">
                                <button @click="modalOpen = true" class="icon-button">
                                    <x-icon.add></x-icon.add>Új kategória
                                </button>

                                <x-admin.modal :title="'Kategória hozzáadása'">
                                    <form action="{{ route('category.store') }}" method="post"
                                        class="flex flex-col sm:flex-row gap-2">
                                        @csrf
                                        @method('post')

                                        <input type="text" class="input-control" name="name"
                                            value="" placeholder="kategória neve">
                                        <button type="submit" class="button">
                                            Hozzáadás
                                        </button>
                                    </form>
                                </x-admin.modal>
                            </div>
                        </li>
                    </ul>
                </section>
            </div>

            <section>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-8">
                    <h3 class="text-2xl font-bold mb-2">{{ $selectedCategory->name }}</h3>
                    <h4 class="text-lg font-semibold mb-4 text-gray-500">Dokumentumok</h4>

                    <x-admin.documents-table :documents="$documents"
                        :selectedCategory="$selectedCategory"></x-admin.documents-table>
                </div>
            </section>
        </div>
    </div>
</x-admin-layout>