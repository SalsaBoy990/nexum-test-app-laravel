<li class="pl-6 w-full">
    <span
        class="flex flex-row gap-x-1 pl-6 py-4 justify-between font-normal items-center {{ $selectedCategory->id === $childCategory->id ? 'active-category' : '' }}">
        
        <div class="flex items-center">
            @if (count($childCategory->categories) > 0)
            <span class="caret caret-down"></span>
            @endif

            <div>
                <a href="{{ route('category.selected', $childCategory->id)}}">
                    {{ $childCategory->name }}
                </a>
            </div>
            <small class="px-2 text-gray-500">id = {{ $childCategory->id }}</small>
        </div>
        <div class="flex flex-row items-center gap-x-2 mr-4">
            <div x-data="{ modalOpen: false }">
                <button class="edit-button" @click="modalOpen = true" title="Szerkeszt">
                    <x-icon.edit></x-icon.edit>
                </button>

                <x-admin.modal :title="$childCategory->name">
                    <form action="{{ route('category.update', $childCategory->id)}}" method="POST"
                        enctype="application/x-www-form-urlencoded" accept-charset="UTF-8"
                        autocomplete="off" class="flex flex-col sm:flex-row gap-2">
                        @method("PUT")
                        @csrf

                        <input type="text" class="input-control" name="name"
                            value="{{ old('name') ?? $childCategory->name }}">

                        <x-jet-button type="submit" class="update-button">{{ __("Mentés") }}
                        </x-jet-button>
                    </form>
                </x-admin.modal>
            </div>


            <div x-data="{ modalOpen: false }">
                <x-jet-danger-button type="button" class="text-xs" title="Törlés"
                    @click="modalOpen = true">
                    <x-icon.trash></x-icon.trash>
                </x-jet-danger-button>
                <x-admin.modal :title="'Biztosan törölni akarod?'">
                    <form action="{{ route('category.destroy', $childCategory->id) }}" method="post"
                        enctype="application/x-www-form-urlencoded" accept-charset="UTF-8"
                        autocomplete="off" class="flex flex-col gap-2">
                        @csrf
                        @method('delete')

                        <div class="pb-4 font-bold">{{ $childCategory->name }}</div>
                        <x-jet-danger-button type="submit" class="text-xs px-2" title="Törlés">
                            Törlés
                        </x-jet-danger-button>
                    </form>
                </x-admin.modal>
            </div>

            <div x-data="{ modalOpen: false }">
                <button @click="modalOpen = true" class="icon-button px-2" title="Új kategória">
                    <x-icon.add></x-icon.add>
                </button>
                <x-admin.modal :title="'Alkategória hozzáadása'">
                    <form action="{{ route('category.store') }}" method="post"
                        class="flex flex-col sm:flex-row gap-2">
                        @csrf
                        @method('post')

                        <input type="text" class="input-control" name="name" value=""
                            placeholder="alkategória neve">
                        <input type="number" class="hidden" name="category_id"
                            value="{{ intval($childCategory->id) }}">
                        <button type="submit" class="button">
                            Hozzáadás
                        </button>
                    </form>
                </x-admin.modal>
            </div>

            <div x-data="{ modalOpen: false }">
                <button @click="modalOpen = true" class="upload-button px-2" title="Feltöltés">
                    <x-icon.upload></x-icon.upload>
                </button>

                <x-admin.modal :title="'Dokumentum hozzáadása'">
                    <form action="{{ route('document.store')}}" method="POST"
                        enctype="multipart/form-data" accept-charset="UTF-8" autocomplete="off"
                        class="flex flex-col gap-2">
                        @method("POST")
                        @csrf

                        <div class="mb-5">
                            <x-jet-label for="view_name" value="{{ __('Megjelenő név*') }}" />
                            <x-jet-input id="view_name"
                                class="block mt-1 bg-gray-50 w-full {{ $errors->has('view_name') ? ' border-rose-400' : '' }}"
                                type="text" name="view_name" :value="old('view_name')" autofocus />
                            <x-jet-input-error for="view_name" class="mt-2" />
                        </div>

                        <input type="number" class="hidden" name="category_id"
                            value="{{ intval($childCategory->id) }}">

                        <div class="flex flex-col md:flex-row">
                            <div class="mb-5">

                                <x-jet-label for="file_path" value="{{ __('Fájl feltöltése*') }}" />

                                <div class="mb-3 mt-1 w-96">
                                    <input
                                        class="form-control block w-full px-3 py-1.5
                                        text-sm font-normaltext-gray-700bg-white bg-clip-padding border border-solid 
                                        {{ $errors->has('file_path') ? ' border-rose-400' : 'border-gray-300' }} 
                                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        type="file" id="file_path" name="file_path" autofocus>
                                </div>
                                <x-jet-input-error for="file_path" class="mt-2" />
                            </div>
                        </div>

                        <button type="submit" class="button">
                            Hozzáadás
                        </button>
                    </form>
                </x-admin.modal>
            </div>

        </div>
    </span>

    <ul class="pl-6 w-full nested active">
        @if (count($childCategory->categories) > 0)
        @foreach ($childCategory->categories as $childCategory)
        <x-child-category-list :childCategory="$childCategory"
            :selectedCategory="$selectedCategory"></x-child-category-list>
        @endforeach
        @endif
    </ul>
</li>