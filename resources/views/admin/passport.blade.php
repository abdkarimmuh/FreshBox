@extends('layouts.admin-master')
@section('content')
    <passport-personal-access-tokens></passport-personal-access-tokens>
    <passport-clients></passport-clients>
    <passport-authorized-clients></passport-authorized-clients>
@endsection
@push('js')
    <script>
        document.addEventListener("mousewheel", function (event) {
            if (document.activeElement.type === "number") {
                document.activeElement.blur();
            }
        });
    </script>
@endpush
