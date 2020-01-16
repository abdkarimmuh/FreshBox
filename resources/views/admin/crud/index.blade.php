@extends('layouts.admin-master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-lg-9">
                        <div class="row">
                            <h4 class="text-danger">{{ $config['title'] }}</h4>
                            @isset($config['route-add'])
                                <a href="{{ route($config['route-add']) }}" class="btn btn-danger ml-2">
                                    Add <i class="fas fa-plus"></i>
                                </a>
                            @endisset
                            @isset($config['route-upload'])
                                <a href="{{ url($config['route-upload']) }}" class="btn btn-success ml-2">
                                    Bulk Upload
                                    <i class="fas fa-plus"></i>
                                </a>
                            @endisset
                            @isset($config['route-multiple-print'])
                                <a class="btn btn-info ml-2" onclick="document.getElementById('checked-form').submit()"
                                   style="color: white">Print <i class="fas fa-print"></i>
                                </a>
                            @endisset
                            @isset($config['route-print-recap'])
                                <a class="btn btn-primary ml-2" href="{{ route($config['route-print-recap'])  }}"
                                   style="color: white">Print Rekap <i class="fas fa-print"></i>
                                </a>
                            @endisset
                        </div>
                    </div>
                    <div class="card-header-action ml-0 mt-3 mb-3">
                        <form action="{{ route($config['route-search'], request()->all()) }}" method="get" id="search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" name="search">
                                <div class="input-group-btn ml-1">
                                    <button class="btn btn-danger"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @isset($config['route-multiple-print'])
                        <form action="{{ route($config['route-multiple-print']) }}" id="checked-form" method="get">
                            @endisset
                            <div class="table-responsive">
                                @if(isset($data))
                                @if($data->count() > 0)
                                    <table class="table table-bordered table-md">
                                        <tbody>
                                        <tr>
                                            @isset($config['route-multiple-print'])
                                                <th>
                                                    <input type="checkbox" id="checked_all">
                                                </th>
                                            @endisset
                                            @if( isset($config['route-edit']) || isset($config['route-delete']) || isset($config['route-view']) || isset($config['route-confirm']) || isset($config['route-approve-topup']) || isset($config['route-reject-topup']) )
                                                <th width="180px">Action</th>
                                            @endif
                                            @foreach ($columns as $column)
                                                <th style="overflow:hidden; white-space:nowrap">{{ capitalize($column['title']) }}</th>
                                            @endforeach
                                        </tr>
                                        @foreach($data as $row)
                                            <tr>
                                                @if( isset($config['route-edit']) || isset($config['route-delete']) || isset($config['route-view']) || isset($config['route-multiple-print']) || isset($config['route-confirm']) || isset($config['route-approve-topup']) || isset($config['route-reject-topup']) )
                                                    @isset($config['route-multiple-print'])
                                                        <td>
                                                            <input type="checkbox" name="id[]" class="custom-checkbox"
                                                                   value="{{ $row->id }}">
                                                        </td>
                                                    @endisset
                                                    <td>
                                                        @isset($row['status'])
                                                            @isset($config['route-view'])
                                                                <a href="{{ route($config['route-view'], ['id' => $row->id]) }}"
                                                                   class="badge badge-primary"
                                                                   title="View">
                                                                    View
                                                                </a>
                                                            @endisset
                                                            @isset($config['route-action-return'])
                                                                @if ($row['status'] == 7)
                                                                    <a href="{{ route($config['route-action-return'], ['id' => $row->id]) }}"
                                                                    class="badge badge-warning"
                                                                    title="Action Return">
                                                                        Action Return
                                                                    </a>
                                                                @endif
                                                            @endisset
                                                            @isset ($config['route-reject-topup'] )
                                                            @isset ($config['route-approve-topup'])
                                                                @if ($row['status'] == 1)
                                                                    <a
                                                                        href="{{ route($config['route-approve-topup'], ['id' => $row->id]) }}"
                                                                        class="badge badge-primary"
                                                                        title="Approve">
                                                                        Approve
                                                                    </a>
                                                                    <a
                                                                        href="{{ route($config['route-reject-topup'], ['id' => $row->id]) }}"
                                                                        class="badge badge-danger"
                                                                        title="Reject">
                                                                        Reject
                                                                    </a>
                                                                @endif
                                                            @endisset
                                                            @endisset
                                                            @if($row['status'] == 1 && $row['is_printed'] == 0)
                                                                @isset($config['route-edit'])
                                                                    <a
                                                                        href="{{ route($config['route-edit'], ['id' => $row->id]) }}"
                                                                        class="badge badge-warning"
                                                                        title="Edit">
                                                                        Edit
                                                                    </a>
                                                                @endisset
                                                                @isset($config['route-delete'])
                                                                    <a href="{{ route($config['route-delete'], ['id' => $row->id]) }}"
                                                                       class="badge badge-danger"
                                                                       title="Delete">
                                                                        Delete
                                                                    </a>
                                                                @endisset
                                                            @endif
                                                        @else
                                                            @isset($config['route-view'])
                                                                <a href="{{ route($config['route-view'], ['id' => $row->id]) }}"
                                                                   class="badge badge-primary"
                                                                   title="View">
                                                                    View
                                                                </a>
                                                            @endisset
                                                            @isset($config['confirm-button'])
                                                                {!! $config['confirm-button'] !!}
                                                            @endisset
                                                            @isset($config['route-edit'])
                                                                <a
                                                                    href="{{ route($config['route-edit'], ['id' => $row->id]) }}"
                                                                    class="badge badge-warning"
                                                                    title="Edit">
                                                                    Edit
                                                                </a>
                                                            @endisset
                                                            @isset($config['route-delete'])
                                                                <a href="{{ route($config['route-delete'], ['id' => $row->id]) }}"
                                                                   class="badge badge-danger"
                                                                   title="Delete">
                                                                    Delete
                                                                </a>
                                                            @endisset
                                                            @isset($config['route-confirm'])
                                                                <a href="{{ route($config['route-confirm'], ['id' => $row->id]) }}"
                                                                   class="badge badge-warning"
                                                                   title="Confirm">
                                                                    Confirm
                                                                </a>
                                                            @endisset
                                                        @endisset
                                                    </td>
                                                @endif
                                                @foreach($columns as $column)
                                                    @if($column['field'] === 'status_name')
                                                        <td>{!! $row[$column['field']] !!}</td>
                                                    @elseif($column['field']  === 'file')
                                                        <td>
                                                            <image-modal file-url="{{ $row['file_url'] }}"
                                                                        file-name="{{ $row[$column['field']] }}">
                                                            </image-modal>
                                                        </td>
                                                    @elseif($column['field'] === 'description' || $column['field'] === 'remarks' )
                                                        <td>{{ $row[$column['field']] }}</td>
                                                    @elseif(isset($column['type']) ? $column['type'] === 'price': '')
                                                        <td>{{ format_price($row[$column['field']]) }}</td>
                                                    @else
                                                        <td style="overflow:hidden; white-space:nowrap">{{ $row[$column['field']] }}</td>
                                                    @endif
                                                @endforeach

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                        <div class="text-center p-3 text-muted">
                                            <h5>No Results</h5>
                                            <p>Looks like you have not added any {{ $config['title'] }} yet!</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                            @isset($config['route-multiple-print'])
                        </form>
                    @endisset
                </div>
                @if (isset($data))
                @if($data->count() > 0)
                    <div class="card-footer text-right">
                        <nav class="d-inline-block">
                            {{ $data->links() }}
                        </nav>
                    </div>
                @endif
                @endif
            </div>
        </div>
    </div>
@endsection
@isset($config['route-multiple-print'])
    @push('js')
        <script>
            $('#checked_all').on('click', function (e) {
                if ($(this).is(':checked', true)) {
                    $(".custom-checkbox").prop('checked', true);
                } else {
                    $(".custom-checkbox").prop('checked', false);
                }
            });
        </script>
    @endpush
@endisset
@push('js')
    <script src="https://demo.getstisla.com/assets/modules/bootstrap-daterangepicker/daterangepicker.js">
@endpush
