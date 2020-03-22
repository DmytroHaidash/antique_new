<form method="post" id="delete" style="display: none">
    @csrf
    @method('delete')
</form>

<form method="post" id="restore" style="display: none">
    @csrf
</form>

@push('scripts')
    <script>
      function deleteItem(route) {
        const form = document.getElementById('delete');
        const conf = confirm('Уверены?');

        if (conf) {
          form.action = route;
          form.submit();
        }
      }

      function restoreItem(route) {
        const form = document.getElementById('restore');
        const conf = confirm('Уверены?');

        if (conf) {
          form.action = route;
          form.submit();
        }
      }
    </script>
@endpush