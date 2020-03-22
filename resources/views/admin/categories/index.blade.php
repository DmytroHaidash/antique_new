@extends('layouts.admin', ['page_title' => 'Категории'])

@section('content')

    <section>
        <table class="table">
            <thead class="small">
            <tr>
                <th>ID</th>
                <th width="100%">Название</th>
                <th>Записей</th>
                <th></th>
            </tr>
            </thead>

            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                        @if ($category->parent_id)
                            <span class="text-muted">&mdash;</span>
                        @endif
                        <a href="{{ route('admin.categories.edit', $category) }}">
                            {{ $category->title }}
                        </a>
                    </td>
                    <td class="text-center">
                        {{ $category->posts_count }}
                    </td>
                    <td class="nobr">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="btn btn-warning btn-squire rounded-circle">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire rounded-circle"
                                onclick="deleteItem('{{ route('admin.categories.destroy', $category) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
                @if ($category->children->count())
                    @foreach($category->children as $child)
                        <tr>
                            <td>{{ $child->id }}</td>
                            <td>
                                <span class="text-muted">&mdash;</span>
                                <a href="{{ route('admin.categories.edit', $child) }}">
                                    {{ $child->title }}
                                </a>
                            </td>
                            <td class="text-center">
                                {{ $child->posts()->count() }}
                            </td>
                            <td class="nobr">
                                <a href="{{ route('admin.categories.edit', $child) }}"
                                   class="btn btn-warning btn-squire rounded-circle">
                                    <i class="i-pencil"></i>
                                </a>
                                <button class="btn btn-danger btn-squire rounded-circle"
                                        onclick="deleteItem('{{ route('admin.categories.destroy', $child) }}')">
                                    <i class="i-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @empty
                <tr class="text-center">
                    <td colspan="6">Категории пока не добавлены...</td>
                </tr>
            @endforelse
        </table>

        <div class="my-4">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                Добавить категорию
            </a>
        </div>

        {{ $categories->appends(request()->except('page'))->links() }}
    </section>

    @include('partials.admin.restore-delete')

@endsection