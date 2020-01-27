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
        <th><b>Nama</b></th>
        <th><b>Total Customer</b></th>
        <th><b>Total SKUID</b></th>
        <th><b>Max End Periode</b></th>
        <th><b>Type Price</b></th>
        <th><b>Remarks</b></th>
    </tr>
    </thead>
    <tbody>
    @forelse ($data as $idx => $row)
        <tr>
            <td>{{ $idx + 1 }}</td>
            <td>{{ $row->name }}</td>
            <td>{{ $row->total_cust }}</td>
            <td>{{ $row->tot_skuid }}</td>
            <td>{{ $row->end_periode }}</td>
            <td>{{ $row->type_price }}</td>
            <td>{{ $row->remarks }}</td>
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
