@extends('layouts.admin', ['page_title' => 'Контакты'])

@section('content')

    <section>
        <table class="table">
            <thead class="small">
            <tr>
                <th width="100%">Имя</th>
                <th>Должность</th>
                <th class="text-center">Порядок</th>
                <th></th>
            </tr>
            </thead>

            @forelse($contacts as $contact)
                <tr>
                    <td>
                        <a href="{{ route('admin.contacts.edit', $contact) }}">
                            {{ $contact->name }}
                        </a>
                    </td>
                    <td class="text-center">
                        {{ $contact->position }}
                    </td>
                    <td width="150" class="small">
                        @if (!$contact->deleted_at)
                            <div class="d-flex text-center mb-2">
                                <form action="{{ route('admin.sort.contacts.up', $contact) }}"
                                      method="post" class="col-6 px-0">
                                    @csrf

                                    <button class="btn btn-sm p-0">&uparrow;</button>
                                </form>

                                <form action="{{ route('admin.sort.contacts.down', $contact) }}"
                                      method="post" class="col-6 px-0">
                                    @csrf

                                    <button class="btn btn-sm p-0">&downarrow;</button>
                                </form>
                            </div>
                        @endif
                    </td>
                    <td class="nobr">
                        @if (!$contact->deleted_at)
                            <a href="{{ route('admin.contacts.edit', $contact) }}"
                               class="btn btn-warning btn-squire rounded-circle">
                                <i class="i-pencil"></i>
                            </a>

                            <button class="btn btn-danger btn-squire rounded-circle"
                                    onclick="deleteItem('{{ route('admin.contacts.destroy', $contact) }}')">
                                <i class="i-trash"></i>
                            </button>
                        @else
                            <button class="btn btn-secondary btn-squire rounded-circle"
                                    onclick="restoreItem('{{ route('admin.contacts.restore', $contact) }}')">
                                <i class="i-reload"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="6">Контакты пока не добавлены...</td>
                </tr>
            @endforelse
        </table>

        <div class="my-4">
            <a href="{{ route('admin.contacts.create') }}" class="btn btn-primary">
                Добавить контакт
            </a>
        </div>
    </section>

    @include('partials.admin.restore-delete')

@endsection