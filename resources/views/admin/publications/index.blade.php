@extends('layouts.admin', ['page_title' => 'Публикации'])

@section('content')

    <section>
        <form class="row mb-4">
            <div class="col pr-0">
                <input type="search" name="q" class="form-control" placeholder="Название">
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
                <th>Секция</th>
                <th></th>
            </tr>
            </thead>

            @forelse($publications as $publication)
                <tr>
                    <td>{{ $publication->id }}</td>
                    <td>
                        <a href="{{ route('admin.publications.edit', $publication) }}">
                            {{ $publication->title }}
                        </a>
                    </td>
                    <td class="text-center">
                        @foreach($publication->sections as $section)
                            <a href="{{ route('admin.publications.index', ['section' => $section->slug]) }}">
                                {{ $section->title }}
                            </a>
                        @endforeach
                    </td>
                    <td class="nobr">
                        <a href="{{ route('admin.publications.edit', $publication) }}"
                           class="btn btn-warning btn-squire rounded-circle">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire rounded-circle"
                                onclick="deleteItem('{{ route('admin.publications.destroy', $publication) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="6">Публикации пока не добавлены...</td>
                </tr>
            @endforelse
        </table>

        @if (\App\Models\Section::where('type', 'publication')->count() && \App\Models\Author::count())
            <div class="my-4">
                <a href="{{ route('admin.publications.create') }}" class="btn btn-primary">
                    Добавить публикацию
                </a>
            </div>
        @else
            <div class="my-4 d-flex align-items-center">
                <span>Сначала нужно</span>

                @if (!\App\Models\Section::where('type', 'publication')->count())
                    <a href="{{ route('admin.sections.create') }}" class="btn btn-primary ml-3">
                        Добавить секцию
                    </a>
                @endif

                @if (!\App\Models\Author::count())
                    <a href="{{ route('admin.authors.create') }}" class="btn btn-primary ml-3">
                        Добавить автора
                    </a>
                @endif
            </div>
        @endif

        {{ $publications->appends(request()->except('page'))->links() }}
    </section>

    @include('partials.admin.restore-delete')

@endsection