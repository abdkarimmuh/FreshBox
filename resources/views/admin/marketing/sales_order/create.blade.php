@extends('layouts.admin-master')

@section('content')
<addsalesorder-component :user_id="{{ auth()->user()->id }}"></addsalesorder-component>
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
