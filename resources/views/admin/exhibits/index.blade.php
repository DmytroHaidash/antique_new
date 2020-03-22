@extends('layouts.admin', ['page_title' => 'Экспонаты'])

@section('content')

    <section>
        <form class="row mb-4">
            <div class="col pr-0">
                <input type="search" name="q" class="form-control" placeholder="Название экспоната" value={{request()->filled('q') ? request()->input("q"): ''}}>
            </div>

            <div class="col-auto">
                <button class="btn btn-primary">Найти</button>
            </div>
        </form>

        <table class="table">
            <thead class="small">
            <tr>
                <th width="10%">Номер</th>
                <th width="55%">Название</th>
                <th width="30%">Секция</th>
                <th class="text-center">Порядок</th>
                <th width="80"></th>
            </tr>
            </thead>

            @forelse($exhibits as $exhibit)
                <tr>
                    <td>{{ $exhibit->props['number'] }}</td>
                    <td>
                        <a href="{{ route('admin.exhibits.edit', $exhibit) }}">
                            {{ $exhibit->title }}
                        </a>
                    </td>
                    <td>
                        @foreach($exhibit->sections as $section)
                            <a href="{{ route('admin.exhibits.index', ['section' => $section->slug]) }}"
                               class="dashed">{{ $section->title }}</a>@if (!$loop->last), @endif
                        @endforeach
                    </td>
                    <td width="150" class="small">
                        <div class="d-flex text-center mb-2">
                            <form action="{{ route('admin.sort.exhibits.up', $exhibit) }}"
                                  method="post" class="col-6 px-0">
                                @csrf

                                <button class="btn btn-sm p-0">&uparrow;</button>
                            </form>

                            <form action="{{ route('admin.sort.exhibits.down', $exhibit) }}"
                                  method="post" class="col-6 px-0">
                                @csrf

                                <button class="btn btn-sm p-0">&downarrow;</button>
                            </form>
                        </div>
                    </td>
                    <td class="nobr">
                        <a href="{{ route('admin.exhibits.edit', $exhibit) }}"
                           class="btn btn-warning btn-squire rounded-circle">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire rounded-circle"
                                onclick="deleteItem('{{ route('admin.exhibits.destroy', $exhibit) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="6">Экспонаты пока не добавлены...</td>
                </tr>
            @endforelse
        </table>

        @if (\App\Models\Section::where('type', 'exhibit')->count())
            <div class="my-4">
                <a href="{{ route('admin.exhibits.create') }}" class="btn btn-primary">
                    Добавить экспонат
                </a>
            </div>
        @else
            <div class="my-4 d-flex align-items-center">
                <span>Сначала нужно</span>

                <a href="{{ route('admin.sections.create') }}" class="btn btn-primary ml-3">
                    Добавить секцию
                </a>
            </div>
        @endif

        {{ $exhibits->appends(request()->except('page'))->links() }}
    </section>

    @include('partials.admin.restore-delete')

@endsection