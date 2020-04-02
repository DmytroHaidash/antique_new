@extends('layouts.admin', ['page_title' => 'Покупатели'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Покупатели</h1>
            <div class="ml-4">
                <a href="{{ route('admin.buers.create') }}" class="btn btn-primary">
                    Создать покупателя
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

            @forelse($buers as $buer)
                <tr>
                    <td width="20">{{ $buer->id }}</td>
                    <td width="280">
                        <a href="{{ route('admin.buers.edit', $buer) }}" class="underline">
                            {{ $buer->title }}
                        </a>
                    </td>
                    <td width="100">
                        <a href="{{ route('admin.buers.edit', $buer) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire"
                                onclick="deleteItem('{{ route('admin.buers.destroy', $buer) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Покупатели пока не добавлены
                    </td>
                </tr>
            @endforelse
        </table>

        {{ $buers->appends(request()->except('page'))->links() }}
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
