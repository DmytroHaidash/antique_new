@extends('layouts.admin', ['page_title' => 'Статусы'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Статусы</h1>
            <div class="ml-4">
                <a href="{{ route('admin.statuses.create') }}" class="btn btn-primary">
                    Создать статус
                </a>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
            <tr class="small">
                <th>#</th>
                <th>Название</th>
                <th></th>
            </tr>
            </thead>

            @forelse($statuses as $status)
                <tr>
                    <td width="20">{{ $status->id }}</td>
                    <td width="280">
                        <a href="{{ route('admin.statuses.edit', $status) }}" class="underline">
                            {{ $status->title }}
                        </a>
                    </td>
                    <td width="100">
                        <a href="{{ route('admin.statuses.edit', $status) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire"
                                onclick="deleteItem('{{ route('admin.statuses.destroy', $status) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Статусы пока не добавлены
                    </td>
                </tr>
            @endforelse
        </table>

        {{ $statuses->appends(request()->except('page'))->links() }}
    </section>

@endsection

@push('scripts')
    <form method="post" id="delete" style="display: none">
        @csrf
        @method('delete')
    </form>

    <script>
      function deleteItem(route) {
        const form = document.getElementById('delete');
        const conf = confirm('Уверены?');

        if (conf) {
          form.action = route;
          form.submit();
        }
      }
    </script>
@endpush
