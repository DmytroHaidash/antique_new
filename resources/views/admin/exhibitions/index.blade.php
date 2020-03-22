@extends('layouts.admin', ['page_title' => 'Выставки'])

@section('content')

    <section>
        <form class="row mb-4">
            <div class="col pr-0">
                <input type="search" name="q" class="form-control" placeholder="Название выставки">
            </div>

            <div class="col-auto">
                <button class="btn btn-primary">Найти</button>
            </div>
        </form>

        <table class="table">
            <thead class="small">
            <tr>
                <th>ID</th>
                <th width="65%">Название</th>
                <th class="text-center">Город</th>
                <th>Даты проведения</th>
                <th></th>
            </tr>
            </thead>

            @forelse($exhibitions as $exhibition)
                <tr>
                    <td>{{ $exhibition->id }}</td>
                    <td>
                        <a href="{{ route('admin.exhibitions.edit', $exhibition) }}">
                            {{ $exhibition->title }}
                        </a>
                    </td>
                    <td class="text-center">
                        {{ optional($exhibition->city)->name }}
                    </td>
                    <td>
                        {{ $exhibition->starts_at ? $exhibition->starts_at->format('d.m.Y') : '...' }}
                        &ndash;
                        {{ $exhibition->ends_at ? $exhibition->ends_at->format('d.m.Y') : '...' }}
                    </td>
                    <td class="nobr">
                        <a href="{{ route('admin.exhibitions.edit', $exhibition) }}"
                           class="btn btn-warning btn-squire rounded-circle">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire rounded-circle"
                                onclick="deleteItem('{{ route('admin.exhibitions.destroy', $exhibition) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="6">Выставки пока не добавлены...</td>
                </tr>
            @endforelse
        </table>

        <div class="my-4">
            <a href="{{ route('admin.exhibitions.create') }}" class="btn btn-primary">
                Добавить выставку
            </a>
        </div>

        {{ $exhibitions->appends(request()->except('page'))->links() }}
    </section>

    @include('partials.admin.restore-delete')

@endsection