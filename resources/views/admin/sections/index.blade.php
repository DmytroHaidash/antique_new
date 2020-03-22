@extends('layouts.admin', ['page_title' => 'Секции'])

@section('content')

    <section>
        <table class="table">
            <thead class="small">
            <tr>
                <th>ID</th>
                <th width="100%">Название</th>
                <th>Записей</th>
                <th class="text-center">Порядок</th>
                <th></th>
            </tr>
            </thead>

            @forelse($sections as $section)
                <tr>
                    <td>{{ $section->id }}</td>
                    <td>
                        @if ($section->parent_id)
                            <span class="text-muted">&mdash;</span>
                        @endif
                        <a href="{{ route('admin.sections.edit', $section) }}">
                            {{ $section->title }}
                        </a>
                    </td>
                    <td class="text-center">
                        {{ $section->exhibits_count + $section->publications_count }}
                    </td>
                    <td width="150" class="small">
                        <div class="d-flex text-center mb-2">
                            <form action="{{ route('admin.sort.sections.up', $section) }}"
                                  method="post" class="col-6 px-0">
                                @csrf

                                <button class="btn btn-sm p-0">&uparrow;</button>
                            </form>

                            <form action="{{ route('admin.sort.sections.down', $section) }}"
                                  method="post" class="col-6 px-0">
                                @csrf

                                <button class="btn btn-sm p-0">&downarrow;</button>
                            </form>
                        </div>
                    </td>
                    <td class="nobr">
                        <a href="{{ route('admin.sections.edit', $section) }}"
                           class="btn btn-warning btn-squire rounded-circle">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire rounded-circle"
                                onclick="deleteItem('{{ route('admin.sections.destroy', $section) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
                @if ($section->children->count())
                    @foreach($section->children()->withCount(['exhibits', 'publications'])->get() as $child)
                        <tr>
                            <td>{{ $child->id }}</td>
                            <td>
                                <span class="text-muted">&mdash;</span>
                                <a href="{{ route('admin.sections.edit', $child) }}">
                                    {{ $child->title }}
                                </a>
                            </td>
                            <td class="text-center">
                                {{ $child->exhibits_count + $child->publications_count }}
                            </td>
                            <td width="150" class="small">
                                <div class="d-flex text-center mb-2">
                                    <form action="{{ route('admin.sort.sections.up', $child) }}"
                                          method="post" class="col-6 px-0">
                                        @csrf

                                        <button class="btn btn-sm p-0">&uparrow;</button>
                                    </form>

                                    <form action="{{ route('admin.sort.sections.down', $child) }}"
                                          method="post" class="col-6 px-0">
                                        @csrf

                                        <button class="btn btn-sm p-0">&downarrow;</button>
                                    </form>
                                </div>
                            </td>
                            <td class="nobr">
                                <a href="{{ route('admin.sections.edit', $child) }}"
                                   class="btn btn-warning btn-squire rounded-circle">
                                    <i class="i-pencil"></i>
                                </a>
                                <button class="btn btn-danger btn-squire rounded-circle"
                                        onclick="deleteItem('{{ route('admin.sections.destroy', $child) }}')">
                                    <i class="i-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            @empty
                <tr class="text-center">
                    <td colspan="6">Секции пока не добавлены...</td>
                </tr>
            @endforelse
        </table>

        <div class="my-4">
            <a href="{{ route('admin.sections.create') }}" class="btn btn-primary">
                Добавить секцию
            </a>
        </div>

        {{ $sections->appends(request()->except('page'))->links() }}
    </section>

    @include('partials.admin.restore-delete')

@endsection