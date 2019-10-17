<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
<table style="width:100%; border-collapse: collapse;" border="1px">
    <thead>
    <tr>
        <th><b>No</b></th>
        <th><b>Customer</b></th>
        <th><b>SO No.</b></th>
        <th><b>SO Date</b></th>
        <th><b>Area</b></th>
        <th><b>Category</b></th>
        <th><b>Item Code</b></th>
        <th><b>Item Name</b></th>
        <th><b>Unit</b></th>
        <th><b>Quantity 1</b></th>
        <th><b>DO No.</b></th>
        <th><b>DO Date</b></th>
        <th><b>Quantity 2</b></th>
        <th><b>Price/Unit</b></th>
        <th><b>No. PO</b></th>
        <th><b>Cust ID</b></th>
    </tr>
    </thead>
    <tbody>
    @forelse ($data as $idx => $row)
        <tr>
            <td>{{ $idx + 1 }}</td>
            <td>{{ $row->delivery_order->customer->name }}</td>
            <td>{{ $row->sales_order_detail->sales_order_no }}</td>
            <td>{{ $row->sales_order_detail->so_date }}</td>
            <td>0</td>
            <td>{{ $row->sales_order_detail->category_name }}</td>
            <td> {{$row->item->skuid}}</td>
            <td> {{$row->item->name_item}}</td>
            <td>{{ $row->uom->name }}</td>
            <td>{{ $row->sales_order_detail->qty }}</td>
            <td>{{ $row->delivery_order->delivery_order_no }}</td>
            <td>{{ $row->delivery_order->do_date }}</td>
            <td>{{ $row->qty_do }}</td>
            <td>{{ $row->sales_order_detail->amount_price }}</td>
            <td>{{ $row->sales_order_detail->no_po }}</td>
            <td>{{ $row->delivery_order->customer->id }}</td>
        </tr>
    @empty
        <tr style="text-align: center">
            <td colspan="11">
                DATA MASIH KOSONG
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>

</html>
