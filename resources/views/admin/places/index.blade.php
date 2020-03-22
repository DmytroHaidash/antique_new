@extends('layouts.admin', ['page_title' => 'Места проведения'])

@section('content')

    <section>
        <form class="row mb-4">
            <div class="col pr-0">
                <input type="search" name="q" class="form-control" placeholder="Название места"
                       value="{{ request('q') }}">
            </div>

            <div class="col-auto">
                <button class="btn btn-primary">Найти</button>
            </div>
        </form>

        <table class="table">
            <thead class="small">
            <tr>
                <th>ID</th>
                <th width="100%">Название</th>
                <th></th>
            </tr>
            </thead>

            @forelse($places as $place)
                <tr>
                    <td>{{ $place->id }}</td>
                    <td>
                        <a href="{{ route('admin.places.edit', $place) }}">
                            {{ $place->title }}
                        </a>
                    </td>
                    <td class="nobr">
                        <a href="{{ route('admin.places.edit', $place) }}"
                           class="btn btn-warning btn-squire rounded-circle">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire rounded-circle"
                                onclick="deleteItem('{{ route('admin.places.destroy', $place) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="6">Места проведения пока не добавлены...</td>
                </tr>
            @endforelse
        </table>

        <div class="my-4">
            <a href="{{ route('admin.places.create') }}" class="btn btn-primary">
                Добавить место
            </a>
        </div>

        {{ $places->appends(request()->except('page'))->links() }}
    </section>

    @include('partials.admin.restore-delete')

@endsection