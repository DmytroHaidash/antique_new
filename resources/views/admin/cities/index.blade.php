@extends('layouts.admin', ['page_title' => 'Города'])

@section('content')

    <section>
        <table class="table">
            <thead class="small">
            <tr>
                <th>ID</th>
                <th width="100%">Название</th>
                <th>Выставки</th>
                <th></th>
            </tr>
            </thead>

            @forelse($cities as $city)
                <tr>
                    <td>{{ $city->id }}</td>
                    <td>
                        <a href="{{ route('admin.cities.edit', $city) }}">
                            {{ $city->name }}
                        </a>
                    </td>
                    <td class="text-center">
                        {{ $city->exhibitions_count }}
                    </td>
                    <td class="nobr">
                        <a href="{{ route('admin.cities.edit', $city) }}"
                           class="btn btn-warning btn-squire rounded-circle">
                            <i class="i-pencil"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="6">Категории пока не добавлены...</td>
                </tr>
            @endforelse
        </table>

        <div class="my-4">
            <a href="{{ route('admin.cities.create') }}" class="btn btn-primary">
                Добавить город
            </a>
        </div>

        {{ $cities->appends(request()->except('page'))->links() }}
    </section>

    @include('partials.admin.restore-delete')

@endsection