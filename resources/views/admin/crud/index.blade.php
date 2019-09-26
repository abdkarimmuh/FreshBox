@extends('layouts.admin-master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-lg-9">
                        <div class="row">
                            <h4 class="text-danger">{{ $config['title'] }}</h4>
                            @if(isset($config['route-add']))
                                <a href="{{ route($config['route-add']) }}" class="btn btn-danger ml-2">Add <i
                                        class="fas fa-plus"></i></a>
                            @endif
                            @isset($config['route-multiple-print'])
                                <a class="btn btn-info ml-2" onclick="document.getElementById('checked-form').submit()"
                                   style="color: white">Print <i class="fas fa-print"></i></a>
                            @endisset
                            @isset($config['route-print-recap'])
                                <a class="btn btn-primary ml-2" href="{{ route($config['route-print-recap'])  }}"
                                   style="color: white">Print Rekap <i class="fas fa-print"></i></a>
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
                                @if($data->count() > 0)
                                    <table class="table table-bordered table-md">
                                        <tbody>
                                        <tr>
                                            @isset($config['route-multiple-print'])
                                                <th>
                                                    <input type="checkbox" id="checked_all">
                                                </th>
                                            @endisset
                                            <th width="150px">Action</th>
                                            @foreach ($columns as $column)
                                                <th>{{ capitalize($column['title']) }}</th>
                                            @endforeach
                                        </tr>
                                        @foreach($data as $row)
                                            <tr>
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
                                                @foreach($columns as $column)
                                                    @if($column['field'] === 'status_name')
                                                        <td>{!! $row[$column['field']] !!}</td>
                                                    @elseif($column['field']  === 'file')
                                                        <td>
                                                            <a href="{{ route('admin.marketing.sales_order.download', $row[$column['field']]) }}">Download</a>
                                                        </td>
                                                    @else
                                                        <td>{{ $row[$column['field']] }}</td>
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
                            </div>
                            @isset($config['route-multiple-print'])
                        </form>
                    @endisset
                </div>
                @if($data->count() > 0)
                    <div class="card-footer text-right">
                        <nav class="d-inline-block">
                            {{ $data->links() }}
                        </nav>
                    </div>
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

