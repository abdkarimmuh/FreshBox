@extends('layouts.admin-master')

@section('content')
    <div class="col-12">
        <div class="card col-12">
            <div class="card-header">
                <h4>Sales Order Details</h4>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Sales Order No</b><span style="color: red;">*</span></label>
                            <div>
                                <input type="text" class="form-control" name="sales_order_no"
                                       value="{{$data->sales_order_no}}" placeholder="Sales Order No.">
                                <div class="invalid-feedback">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Customer</b><span style="color: red;">*</span></label>
                            <div>
                                <input type="text" class="form-control" name="customer_id"
                                       value="{{ $data->customer->name }}"
                                       disabled>
                                <div class="invalid-feedback">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Source Order</b><span style="color: red;">*</span></label>
                            <div>
                                <input type="text" class="form-control" name="source_order_id"
                                       value="{{ $data->source_order_name }}"
                                       disabled>
                                <div class="invalid-feedback">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Fulfillment Date</b><span style="color: red;">*</span></label>
                            <div>
                                <date-picker lang="en"
                                             value="{{ $data->fulfillment_date }}"></date-picker>
                                <div class="invalid-feedback">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive m-t-40" style="clear: both;">
                            <table class="table table-hover" id="contentTable" style="font-size: 9pt;">
                                <thead>
                                <tr>
                                    <th class="text-center">SKUID</th>
                                    <th class="text-center">Item Name</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">UOM</th>
                                    <th class="text-center">Amount Price</th>
                                    <th class="text-center">Total Amount</th>
                                    <th class="text-center">Notes</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($grand_total = 0)
                                @foreach($data->sales_order_details as $order_detail)
                                    <tr>
                                        <td>{{ $order_detail->skuid }}</td>
                                        <td>{{ $order_detail->item->name_item }}</td>
                                        <td style="text-align: right;">
                                            <input type="number" placeholder="Qty"
                                                   class="form-control" value="{{ $order_detail->qty }}">
                                        </td>
                                        <td>{{ $order_detail->item->uom->name }}</td>
                                        <td>{{ format_price($order_detail->amount_price) }}</td>
                                        <td>{{ format_price($order_detail->total_amount) }}</td>
                                        <td>
                                            <input type="text" placeholder="Notes"
                                                   class="form-control" value="{{ $order_detail->notes }}">
                                        </td>
                                    </tr>
                                    @php($grand_total += $order_detail->total_amount)
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5" style="text-align: right;">Grand Total</td>
                                    <td style="text-align: right;">{{ format_price($grand_total) }}</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><b>Remarks</b><span style="color: red;">*</span></label>
                                <textarea class="form-control" id="Remarks"
                                          name="Remarks">{{ $data->remarks }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card-body">
                                <button class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
