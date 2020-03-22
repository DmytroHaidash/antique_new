@extends('layouts.admin', ['page_title' => 'Пользователи'])

@section('content')

    <section>
        <table class="table">
            <thead class="small">
            <tr>
                <th width="100%">Имя</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Создан</th>
                <th></th>
            </tr>
            </thead>

            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ __('admin.roles.' . mb_strtolower($user->role)) }}</td>
                    <td class="nobr">{{ $user->created_at->format('d.m.Y H:i') }}</td>
                    <td width="80" class="nobr">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="btn btn-warning btn-squire rounded-circle">
                            <i class="i-pencil"></i>
                        </a>

                        @if (Auth::user()->id !== $user->id)
                            <button class="btn btn-danger btn-squire rounded-circle"
                                    onclick="deleteItem('{{ route('admin.users.destroy', $user) }}')">
                                <i class="i-trash"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

        <div class="my-4">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                Добавить пользователя
            </a>
        </div>

        @include('partials.admin.restore-delete')

        {{ $users->appends(request()->except('page'))->links() }}
    </section>

@endsection
