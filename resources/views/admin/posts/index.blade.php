@extends('layouts.admin', ['page_title' => 'Пресс-центр'])

@section('content')

    <section>
        <form class="row mb-4">
            <div class="col pr-0">
                <input type="search" name="q" class="form-control" placeholder="Заголовок записи" value={{request()->filled('q') ? request()->input("q"): ''}}>
            </div>

            <div class="col-auto">
                <button class="btn btn-primary">Найти</button>
            </div>
            @if(request()->filled('q'))
                <a href="{{route('admin.posts.index')}}" class="btn btn-primary">Сбросить поиск</a>
            @endif
        </form>

        <table class="table">
            <thead class="small">
            <tr>
                <th>ID</th>
                <th width="65%">Заголовок</th>
                <th>Категория</th>
                <th></th>
            </tr>
            </thead>

            @forelse($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>
                        <a href="{{ route('admin.posts.edit', $post) }}">
                            {{ $post->title }}
                        </a>
                    </td>
                    <td>
                        @foreach($post->categories as $category)
                            <a href="{{ route('admin.posts.index', ['category' => $category->slug]) }}"
                               class="dashed">{{ $category->title }}</a>
                            @if(!$loop->last)
                                /
                            @endif
                        @endforeach
                    </td>
                    <td class="nobr">
                        <a href="{{ route('admin.posts.edit', $post) }}"
                           class="btn btn-warning btn-squire rounded-circle">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire rounded-circle"
                                onclick="deleteItem('{{ route('admin.posts.destroy', $post) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="6">Записи пока не добавлены...</td>
                </tr>
            @endforelse
        </table>

        @if (\App\Models\Category::count())
            <div class="my-4">
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                    Добавить запись
                </a>
            </div>
        @else
            <div class="my-4 d-flex align-items-center">
                <span>Сначала нужно</span>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary ml-3">
                    Добавить категорию
                </a>
            </div>
        @endif

        {{ $posts->appends(request()->except('page'))->links() }}
    </section>

    @include('partials.admin.restore-delete')

@endsection