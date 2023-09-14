@php
    use App\Models\Link;
    use Illuminate\Support\Collection;

    /** @var Collection<int,Link> $links */
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('links.links') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(count($links))
                <table class="table-auto w-full text-left">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('links.name') }}</th>
                        <th>{{ __('links.original_url') }}</th>
                        <th>{{ __('links.shortened_url') }}</th>
                        <th>{{ __('links.visits') }}</th>
                        <th>{{ __('links.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($links as $link)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $link->name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($link->original_url, 20) }}</td>
                            <td>
                                <a href="{{ request()->root() . '/' . $link->shortened_url }}">
                                    {{ request()->root() . '/' . $link->shortened_url }}
                                </a>
                            </td>
                            <td>{{ $link->visits }}</td>
                            <td>
                                <button type="button" data-id="{{ $link->id }}"
                                        data-modal-target="modalEdit" data-modal-toggle="modalEdit"
                                        class="editButton rounded-lg text-white bg-blue-700 hover:bg-blue-800 px-3 py-1.5">
                                    {{ __('links.edit') }}
                                </button>
                                <button type="button" data-modal-target="modalDelete" data-modal-toggle="modalDelete"
                                        class="deleteButton rounded-lg text-white bg-red-700 hover:bg-red-800 px-3 py-1.5"
                                        data-id="{{ $link->id }}">
                                    {{ __('links.delete') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div>
                    {{ __('links.not_exist') }}
                </div>
            @endif

            <button id="createButton" type="button" data-modal-target="modalEdit" data-modal-toggle="modalEdit"
                    class="rounded-lg text-white bg-blue-700 hover:bg-blue-800 px-3 py-1.5">
                {{ __('links.create') }}
            </button>

            <x-modalEdit/>
            <x-modalDelete/>
        </div>
    </div>
</x-app-layout>
