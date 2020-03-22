@extends('layouts.admin', ['page_title' => 'Категории товаров'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Категории товаров</h1>
            <div class="ml-4">
                <a href="{{ route('admin.product_categories.create') }}" class="btn btn-primary">
                    Создать категорию
                </a>
            </div>
        </div>

        <table class="table">
            <thead>
            <tr class="small">
                <th>#</th>
                <th>Название</th>
                <th class="text-center">Товаров в категории</th>
                <th class="text-center">Порядок</th>
                <th></th>
            </tr>
            </thead>

            @forelse($categories as $category)
                <tr>
                    <td width="20">{{ $category->id }}</td>
                    <td width="280">
                        <a href="{{ route('admin.product_categories.edit', $category) }}" class="underline">
                            {{ $category->translate('title') }}
                        </a>
                    </td>
                    <td class="text-center small">{{ $category->products()->count() }}</td>
                    <td width="150" class="small">
                        <div class="d-flex text-center mb-2">
                            <form action="{{ route('admin.sort.product_categories.up', $category) }}"
                                  method="post" class="col-6 px-0">
                                @csrf

                                <button class="btn btn-sm p-0">&uparrow;</button>
                            </form>

                            <form action="{{ route('admin.sort.product_categories.down', $category) }}"
                                  method="post" class="col-6 px-0">
                                @csrf

                                <button class="btn btn-sm p-0">&downarrow;</button>
                            </form>
                        </div>
                    </td>
                    <td width="100">
                        <a href="{{ route('admin.product_categories.edit', $category) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire"
                                onclick="deleteItem('{{ route('admin.product_categories.destroy', $category) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Категории пока не добавлены
                    </td>
                </tr>
            @endforelse
        </table>

        {{ $categories->appends(request()->except('page'))->links() }}
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
