@extends('layouts.admin', ['page_title' => $buer->title])

@section('content')

    <section id="content">
        <form action="{{ route('admin.buers.update', $buer) }}" method="post">
            @csrf
            @method('patch')
            <div class="form-group">
                <label for="title">Название</label>
                <input type="text" class="form-control" id="title" name="title"
                       value="{{ old('title')?? $buer->title }}" required>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>

@endsection
