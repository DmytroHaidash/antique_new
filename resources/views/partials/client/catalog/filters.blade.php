<div class="flex flex-wrap justify-center">
    @if ($categories->count())
        @foreach($categories as $category)
            <a href="{{$search? '?search='.$search.'&' : '?'}}category={{ $category->slug }}"
               class="mx-px button button--primary{{ $search_category == $category->slug ? '-outline' : '' }}">
                {{ $category->title }}
            </a>
        @endforeach
        @if(request()->filled('category') || request()->filled('search'))
            <a href="{{ url()->current() }}" class="mx-px button button--primary-outline">
                @lang('pages.catalog.filter.clear')
            </a>
        @endif
    @endif

</div>