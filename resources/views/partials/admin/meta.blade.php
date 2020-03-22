<h2 class="mt-2">Meta-данные</h2>

<div class="form-group">
    <label for="meta[title]">Заголовок</label>
    <input type="text" name="meta[title]" class="form-control"
           value="{!! $meta ? $meta->title : '' !!}">
</div>

<div class="form-group">
        <label for="meta[description]">Описание</label>
        <textarea cols="4" name="meta[description]" class="form-control">{!! $meta ? $meta->description : '' !!}</textarea>
</div>

<div class="form-group">
    <label for="meta[keywords]">Ключевые слова</label>
    <input type="text" name="meta[keywords]" class="form-control"
           value="{!! $meta ? $meta->keywords : '' !!}">
</div>
