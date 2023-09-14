@php
    use App\Models\Link;

    /** @var Link $link */
@endphp
<form action="{{ $action }}" method="POST" id="modalEditForm">
    @csrf
    @isset($method)
        @method($method)
    @endisset
    <div class="mb-6">
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
            {{ __('links.name') }}:
        </label>
        <input type="text" id="name" name="name"
               @isset($link->name) value="{{ $link->name }}" @endisset
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        <div id="name_error" class="error"></div>
    </div>
    <div class="mb-6">
        <label for="originalUrl" class="block mb-2 text-sm font-medium text-gray-900">
            {{ __('links.original_url') }}:
        </label>
        <input type="text" id="originalUrl" name="original_url"
               @isset($link) value="{{ $link->original_url }}" @endisset
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        <div id="original_url_error" class="error"></div>
    </div>
    <div class="mb-6">
        <label for="shortenedUrl" class="block mb-2 text-sm font-medium text-gray-900">
            {{ __('links.shortened_url') }}:
        </label>
        <input type="text" id="shortenedUrl" name="shortened_url"
               @isset($link) value="{{ $link->shortened_url }}" @endisset
               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        <div id="shortened_url_error" class="error"></div>
    </div>
</form>
