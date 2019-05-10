@extends('page.main')

@section('body')
    @include($view)
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $("body").on("click",".alert button.close", function() {
            $(this).closest(".alert").remove();
        });
    });
</script>
@stack('scripts_distribuidor')
@endpush