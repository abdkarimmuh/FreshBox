@extends('layouts.admin-master')

@section('title')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                {{--                <div class="card-header">--}}
                {{--                    <h4></h4>--}}
                {{--                    <div class="card-header-action">--}}

                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="card-header">
                    <div class="col-lg-9">
                        <div class="row">
                            <h4>{{ $config['title'] }}</h4>
                            <a href="{{ route($config['route-add']) }}" class="btn btn-primary">Add <i
                                    class="fas fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="card-header-action">
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card-body p-0">

                    <div class="table-responsive">
                        @if($data->count() > 0)
                            <table class="table table-bordered table-md">
                                <tbody>
                                <tr>
                                    <th width="140px">Action</th>
                                    @foreach ($columns as $column)
                                        <th>{{ capitalize($column['title']) }}</th>
                                    @endforeach
                                </tr>
                                @foreach($data as $row)
                                    <tr>
                                        <td>
                                            @isset($row['status'])
                                                @isset($config['route-view'])
                                                    <a href="{{ route($config['route-view'], ['id' => $row->id]) }}"
                                                       class="badge badge-primary"
                                                       title="View">
                                                        View
                                                    </a>
                                                @endisset
                                                @if($row['status'] == 1)
                                                    @isset($config['route-edit'])
                                                        <a
                                                            href="{{ route($config['route-edit'], ['id' => $row->id]) }}"
                                                            class="badge badge-warning"
                                                            title="Edit">
                                                            Edit
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
                                            @endisset

                                        </td>
                                        @foreach($columns as $column)
                                            @if($column['field'] === 'status_name')
                                                <td>{!! $row[$column['field']] !!}</td>
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
