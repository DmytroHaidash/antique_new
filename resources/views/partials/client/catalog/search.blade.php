<form action="{{ route('client.catalog.index') }}" class=" flex items-center mb-4">
    <input type="search" name="search" class="form-control text-lg mr-2"
           value="{{ old('search') ?? $search }}"
           placeholder="{{ trans('pages.catalog.search.placeholder') }}" required>
    @if(request()->has('category'))
        <input type="hidden" name="category" value="{{request('category')}}">
    @endif
    <button class="button button--primary h-12">@lang('pages.catalog.search.button')</button>
</form>