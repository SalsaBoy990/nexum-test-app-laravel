<div>
    @if (count($documents) === 0)
    <p class="py-8">Még nincs dokumentum feltöltve ehhez a kategóriához.</p>
    @else
    <table class="min-w-full">
        <thead class="border-b">
            <tr>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                    {{ __('#') }}
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                    {{ __('Megjelenő név') }}
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                    {{ __('Metaadatok') }}
                </th>
                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                    {{ __('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documents as $document)
            <tr class="border-b">
                <td class="py-4 px-2">
                    {{ $document->id }}
                </td>
                <td class="py-4 px-2">

                    <h3 class="text-base font-semibold font-exo">
                        <a href="{{ $document->file_link }}" download>{{ $document->view_name }}</a>
                    </h3>
                    @if($document->file_link)
                    <img src="{{ $document->file_link }}" class="p-1 bg-white border rounded w-20"
                        alt="{{ $document->view_name }}" />
                    @endif
                    </a>
                </td>

                <td class="py-4 px-2">
                    <ul class="text-sm">
                        <li>Eredeti fájlnév: <b>{{ $document->original_filename }}</b></li>
                        <li>Verzió: <b>{{ $document->version }}</b></li>
                        <li>Méret: <b>{{ $document->filesize }}</b></li>
                        <li>Feltöltve: <b>{{ $document->last_modified->diffForHumans() }}</b></li>
                    </ul>
                </td>
                <td>
                    <div class="flex flex-row items-center gap-x-2">

                        <div x-data="{ modalOpen: false }">
                            <button @click="modalOpen = true" class="edit-button">
                                <x-icon.edit></x-icon.edit>
                            </button>

                            <x-admin.modal :title="$document->view_name">
                                <form action="{{ route('document.update', $document->id)}}"
                                    method="POST" enctype="multipart/form-data"
                                    accept-charset="UTF-8" autocomplete="off"
                                    class="flex flex-col gap-2">
                                    @method("PUT")
                                    @csrf

                                    <div class="mb-5">
                                        <x-jet-label for="view_name"
                                            value="{{ __('Megjelenő név*') }}" />
                                        <x-jet-input id="view_name"
                                            class="block mt-1 bg-gray-50 w-full {{ $errors->has('view_name') ? ' border-rose-400' : '' }}"
                                            type="text" name="view_name"
                                            value="{{ old('view_name') ?? $document->view_name }}"
                                            autofocus />
                                        <x-jet-input-error for="view_name" class="mt-2" />
                                    </div>

                                    <input type="number" class="hidden" name="category_id"
                                        value="{{ intval($selectedCategory->id) }}">

                                    <div class="flex flex-col md:flex-row">
                                        <div class="mb-5">

                                            <div class="mb-2">
                                                Feltöltött fájl:<br> <b>{{ $document->file_link }}</b>
                                            </div>

                                            <x-jet-label for="file_path"
                                                value="{{ __('Fájl cseréje (opcionális)') }}" />

                                            <div class="mb-3 mt-1 w-96">
                                                <input
                                                    class="form-control block w-full px-3 py-1.5
                                                text-sm font-normal
                                                text-gray-700
                                                bg-white bg-clip-padding border border-solid 
                                                {{ $errors->has('file_path') ? ' border-rose-400' : 'border-gray-300' }} 
                                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                                    type="file" id="file_path" name="file_path"
                                                    autofocus>
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

                        <div x-data="{ modalOpen: false }">
                            <x-jet-danger-button type="button" class="text-xs" title="Törlés"
                                @click="modalOpen = true">
                                <x-icon.trash></x-icon.trash>
                            </x-jet-danger-button>
                            <x-admin.modal :title="'Biztosan törölni akarod?'">
                                <form action="{{ route('document.destroy', $document->id) }}"
                                    method="post" enctype="application/x-www-form-urlencoded"
                                    accept-charset="UTF-8" autocomplete="off"
                                    class="flex flex-col gap-2">
                                    @csrf
                                    @method('delete')

                                    <div class="pb-4 font-bold">{{ $document->view_name }}</div>
                                    <x-jet-danger-button type="submit" class="text-xs px-2"
                                        title="Törlés">
                                        Törlés
                                    </x-jet-danger-button>
                                </form>
                            </x-admin.modal>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>