@extends('layouts.admin-master')

@section('content')
<add_deliver_order-component :user_id="{{ auth()->user()->id }}"></add_deliver_order-component>
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
