@extends('layouts.admin', ['page_title' => 'Страницы'])

@section('content')

    <section>
        <table class="table">
            <thead class="small">
            <tr>
                <th>ID</th>
                <th width="100%">Название</th>
                <th></th>
            </tr>
            </thead>

            @forelse($pages as $page)
                <tr>
                    <td>{{ $page->id }}</td>
                    <td>
                        @if ($page->parent_id)
                            <span class="text-muted">&mdash;</span>
                        @endif
                        <a href="{{ route('admin.pages.edit', $page) }}">
                            {{ $page->title }}
                        </a>
                    </td>
                    <td class="nobr">
                        <a href="{{ route('admin.pages.edit', $page) }}"
                           class="btn btn-warning btn-squire rounded-circle">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire rounded-circle"
                                onclick="deleteItem('{{ route('admin.pages.destroy', $page) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
                @if ($page->children->count())
                    @foreach($page->children as $child)
                        <tr>
                            <td>{{ $child->id }}</td>
                            <td>
                                <span class="text-muted">&mdash;</span>
                                <a href="{{ route('admin.pages.edit', $child) }}">
                                    {{ $child->title }}
                                </a>
                            </td>
                            <td class="nobr">
                                <a href="{{ route('admin.pages.edit', $child) }}"
                                   class="btn btn-warning btn-squire rounded-circle">
                                    <i class="i-pencil"></i>
                                </a>
                                <button class="btn btn-danger btn-squire rounded-circle"
                                        onclick="deleteItem('{{ route('admin.pages.destroy', $child) }}')">
                                    <i class="i-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @empty
                <tr class="text-center">
                    <td colspan="6">Страницы пока не добавлены...</td>
                </tr>
            @endforelse
        </table>

        <div class="my-4">
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                Добавить страницу
            </a>
        </div>

        {{ $pages->appends(request()->except('page'))->links() }}
    </section>

    @include('partials.admin.restore-delete')

@endsection