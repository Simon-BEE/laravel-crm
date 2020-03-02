@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.20.0/ui/trumbowyg.min.css">
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.20.0/trumbowyg.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.20.0/langs/fr.min.js"></script>
<script>
    $('#{{ $id }}').trumbowyg({
        lang: 'fr',
    });
</script>
@if ($property)
    <script>
        $('#{{ $id }}').trumbowyg('html', `{!! $property->body !!}`);
    </script>
@endif
