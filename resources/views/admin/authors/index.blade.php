@extends('layouts.admin', ['page_title' => 'Авторы'])

@section('content')

    <section>
        <form class="row mb-4">
            <div class="col pr-0">
                <input type="search" name="q" class="form-control" placeholder="Имя автора">
            </div>

            <div class="col-auto">
                <button class="btn btn-primary">Найти</button>
            </div>
        </form>

        <table class="table">
            <thead class="small">
            <tr>
                <th width="100%">Имя</th>
                <th>Записей</th>
                <th></th>
            </tr>
            </thead>

            @forelse($authors as $author)
                <tr>
                    <td>
                        <a href="{{ route('admin.authors.edit', $author) }}">
                            {{ $author->name }}
                        </a>
                    </td>
                    <td class="text-center">
                        {{ $author->exhibits_count + $author->publications_count }}
                    </td>
                    <td class="nobr">
                        <a href="{{ route('admin.authors.edit', $author) }}"
                           class="btn btn-warning btn-squire rounded-circle">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire rounded-circle"
                                onclick="deleteItem('{{ route('admin.authors.destroy', $author) }}')">
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

        <div class="my-4">
            <a href="{{ route('admin.authors.create') }}" class="btn btn-primary">
                Добавить автора
            </a>
        </div>

        {{ $authors->appends(request()->except('page'))->links() }}
    </section>

    @include('partials.admin.restore-delete')

@endsection