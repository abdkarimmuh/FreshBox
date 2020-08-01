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
            <th>SO No.</th>
            <th>SO Date</th>
            <th>DO Number</th>
            <th>DO Date</th>
            <th>Customer Name</th>
            <th>Customer ID</th>
            <th>SKUID</th>
            <th>Item Name</th>
            <th>QTY DO</th>
            <th>Unit</th>
            <th>No PO</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($data as $row)
        <tr>
            <td>{{ $row->SONO }}</td>
            <td>{{  Carbon\Carbon::parse($row->created_at)->format('Y-m-d') }}</td>
            <td>{{ $row->DONO }}</td>
            <td>{{ $row->DODate }}</td>
            <td>{{ $row->CustName }}</td>
            <td>{{ $row->CUSTID }}</td>
            <td>{{ $row->SKUID }}</td>
            <td>{{ $row->ItemName }}</td>
            <td>{{ number_format($row->QTYDO, 2)  }}</td>
            <td>{{ $row->Unit }}</td>
            <td>{{ $row->NOPO }}</td>
        </tr>
    @empty
        <tr style="text-align: center">
            <td colspan="10">
                DATA MASIH KOSONG
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>

</html>
