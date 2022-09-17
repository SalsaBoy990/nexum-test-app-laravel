<li class="pl-6 w-full">
    <span class="flex flex-row gap-x-1 pl-6 py-4 font-medium items-center">
        <span class="caret"></span>
        {{ $childCategory->name }}
        <small class="px-2 text-gray-500">id = {{ $childCategory->id }}</small>

        <div class="flex flex-row items-center gap-x-2">
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

                        <input type="text" class="input-control" name="name" value="{{ old('name') ?? $childCategory->name }}">

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
        </div>
    </span>
    @if ($childCategory->categories)
    <ul class="pl-6 w-full nested">
        @foreach ($childCategory->categories as $childCategory)
        <x-child-category-list :childCategory="$childCategory"></x-child-category-list>
        @endforeach
        <li class="pl-6 mt-4">
            <div x-data="{ modalOpen: false }">
                <button @click="modalOpen = true" class="icon-button">
                    <x-icon.add></x-icon.add>Új
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
        </li>
    </ul>
    @endif
</li>