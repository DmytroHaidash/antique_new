@extends('layouts.admin', ['page_title' => 'Товары'])

@section('content')

    <section id="content">
        <div class="d-flex align-items-center mb-5">
            <h1 class="h3 mb-0">Товары</h1>
            <div class="ml-4">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    Создать товар
                </a>
            </div>
        </div>

        <form class="my-4 d-flex">
            <div class="mr-2 flex-grow-1">
                <input type="text" name="q" value="{{ request()->get('q', null) }}" class="form-control"
                       placeholder="Поиск по товарам">
            </div>
            <button class="btn btn-primary">
                <i class="i-search"></i>
                Найти
            </button>
        </form>
        @if ($tags->count())
            <div class="mb-5 d-flex" style="font-size: 14px;">
                @foreach($tags as  $tag)
                    <div class="d-inline-flex align-items-center bg-secondary text-white flex-nowrap rounded mr-2">
                        <span class="py-1 px-2">
                            {{ $tag->translate('title') }}
                        </span>
                        <a href="{{ $tag->query_filter }}"
                           class="p-2 bg-dark text-white bg-secondary text-white rounded-right"
                           style="line-height: 15px;">
                            &times;
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <table class="table">
            <thead>
            <tr class="small">
                <th>#</th>
                <th>Название</th>
                <th>Категория</th>
                <th class="text-center">Порядок</th>
                <th></th>
            </tr>
            </thead>

            @forelse($products as $product)
                <tr>
                    <td width="20">{{ $product->id }}</td>
                    <td width="280">
                        <a href="{{ route('admin.products.edit', $product) }}" class="underline">
                            {{ $product->title }}
                        </a>
                    </td>
                    <td>
                        @forelse($product->categories as $category)
                            <a href="{{ $category->query_filter }}"
                               class="bg-secondary text-white py-1 px-2 rounded small mr-1 nowrap">
                                {{ $category->title }}
                            </a>
                        @empty
                            ---
                        @endforelse
                    </td>
                    <td width="150" class="small">
                        <div class="d-flex text-center mb-2">
                            <form action="{{ route('admin.sort.products.up', $product) }}"
                                  method="post" class="col-6 px-0">
                                @csrf

                                <button class="btn btn-sm p-0">&uparrow;</button>
                            </form>

                            <form action="{{ route('admin.sort.products.down', $product) }}"
                                  method="post" class="col-6 px-0">
                                @csrf

                                <button class="btn btn-sm p-0">&downarrow;</button>
                            </form>
                        </div>
                    </td>
                    <td width="100">
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="btn btn-warning btn-squire">
                            <i class="i-pencil"></i>
                        </a>
                        <button class="btn btn-danger btn-squire"
                                onclick="deleteItem('{{ route('admin.products.destroy', $product) }}')">
                            <i class="i-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Товары пока не добавлены
                    </td>
                </tr>
            @endforelse
        </table>

        {{ $products->appends(request()->except('page'))->links() }}
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
