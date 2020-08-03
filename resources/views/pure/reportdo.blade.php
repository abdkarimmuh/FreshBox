@extends('layouts.admin-master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Report SO {{ date('Y-m-d') }}</h4>
            </div>
            <div class="card-body">
                <div class="float-left">
                   <a href="{{ route('admin.report.reportdo.export', ['soid' => request('soid')]) }}" class="btn btn-primary"><i class="fa fa-download"></i> CSV</a>
                  </div>
                  <div class="float-right">
                    <form method="get" action="{{ route('admin.report.reportdo.index', ['soid' => request('soid')]) }}" enctype="multipart/form-data">
                        <div class="input-group">

                            <select class="form-control select2"  name="soid">
                                @foreach ($dataSO as $so)
                                  <option value="{{ $so->soid }}">{{ $so->SONO }}</option>   
                                @endforeach
                            </select>

                          <div class="input-group-append">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>

                   </div>
 
                <div class="table-responsive">
                    @if (count($data)>0)
                        <table class="table table-striped table-md">
                            <tbody>
                                <tr>
                                <th>SO No.</th>
                                <th>SO Date</th>
                                <th>DO Number</th>
                                <th>DO Date</th>
                                <th>Customer Name</th>
                                <th>Customer ID</th>
                                <th>SKUID</th>
                                <th>Item Name</th>
                                <th>Qty DO</th>
                                <th>Unit</th>
                                <th>No PO</th>
                            </tr>
                                @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row->SONO }}</td>
                                    <td>
                                        
                                        @php
                                            $xyz = strtotime($row->SODate);
                                        @endphp
                                        
                                        {{  date('Y-m-d', $xyz ) }}
                                    </td>
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
                                @endforeach
                            </tbody>
                        </table>
                    @else
                    <div class="text-center p-3 text-muted">
                        <h5>No Results</h5>
                        <p>Looks like you have not added any Data Order B2B yet!</p>
                    </div>
    
                    @endif
    
                  </div>
            </div>

        </div>
    </div>
</div>
@endsection
