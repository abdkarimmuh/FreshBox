@extends('layouts.admin-master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Sales Order</h1>
        </div>
        <div class="section-body">
            <editsalesorder-component sales_order='{!! $sales_order->toJson() !!}'
                                      sales_order_details='{!! $sales_order_details->toJson() !!}'></editsalesorder-component>
        </div>
    </section>
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
