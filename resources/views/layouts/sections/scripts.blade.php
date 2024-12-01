<script src="{{ asset('admin') }}/assets/vendor/libs/jquery/jquery.js"></script>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<!-- select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- datatables -->
<script src="{{ asset('admin') }}/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="{{ asset('admin') }}/assets/vendor/libs/datatables-bs5/buttons.colVis.min.js"></script>

<!-- pusher -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
   var pusher = new Pusher("{{ config('pusher.key') }}", {
      cluster: "{{ config('pusher.cluster') }}",
      encrypted: true
   });

   var channel = pusher.subscribe('new-articles');
   channel.bind("App\\Events\\NewsUpdatedEvent", function(data) {
      toast_success(data);
      $('#records_table').DataTable().ajax.reload(null, false);
   });
</script>
<!-- Page JS -->
<script src="{{ asset('admin') }}/js/datatable_news.js"></script>
<script src="{{ asset('admin') }}/js/script.js"></script>

@stack('AJAX')