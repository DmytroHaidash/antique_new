<style>
    body { font-family: DejaVu Sans, sans-serif; }
</style>
@foreach($images as $photo)
    <img src="{{ $photo->getPath() }}" style="width: 700px; height: auto; padding: 10px">
@endforeach
