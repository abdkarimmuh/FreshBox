@extends('layouts.admin-master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="text-danger">{{ $config['title'] }}</h4>
                <div class="card-header-action">
                    <a href="{{ route($config['back-button']) }}" class="btn btn-primary">Back</a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="row mb-4">
                        @foreach ($columns as $item)
                        @if ($item['field'] === 'remarks')
                        <div class="col-md-12 mt-4">
                            <h6><small class="text-muted">{{ $item['title']}}</small></h6>
                            <h5>{{ $data[$item['field']] }}</h5>
                        </div>
                        @else
                        <div class="col-md-6 mt-4">
                            @if($item['field'] === 'status_name')
                            <h6><small class="text-muted">{{ $item['title']}}</small></h6>
                            <div>{!! $data[$item['field']] !!}</div>
                            @else
                            <h6><small class="text-muted">{{ $item['title']}}</small></h6>
                            <h5>{{ $data[$item['field']] }}</h5>
                            @endif
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @if($detail->count() > 0)
                    <div class="row mb-4 mt-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr>
                                        @foreach ($detailColumns as $column)
                                        <th style="overflow:hidden; white-space:nowrap">
                                            {{ capitalize($column['title']) }}
                                        </th>
                                        @endforeach
                                    </tr>
                                    @foreach ($detail as $item)
                                    <tr>
                                        @foreach($detailColumns as $column)
                                        @if ($column['field'] === 'status_name')
                                        <td>{!! $item[$column['field']] !!}</td>
                                        @else
                                        <td style="overflow:hidden; white-space:nowrap">{{ $item[$column['field']] }}
                                        </td>
                                        @endif
                                        @endforeach
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
