@extends('layouts.admin', ['page_title' => $supplier->title])

@section('content')

    <section id="content">
        <form action="{{ route('admin.suppliers.update', $supplier) }}" method="post">
            @csrf
            @method('patch')
            <div class="form-group">
                <label for="title">Название</label>
                <input type="text" class="form-control" id="title" name="title"
                       value="{{ old('title')?? $supplier->title }}" required>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
