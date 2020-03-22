@extends('layouts.admin', ['page_title' => 'Создание поставщика'])

@section('content')

    <section id="content">
        <form action="{{ route('admin.suppliers.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="title">Название</label>
                <input type="text" class="form-control" id="title" name="title"
                       value="{{ old('title') }}" required>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
