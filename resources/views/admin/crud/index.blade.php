@extends('layouts.admin-master')

@section('title')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $config['title'] }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route($config['route-add']) }}" class="btn btn-primary">Add <i
                                class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-header">
                    <h4></h4>
                   <div class="card-header-form">
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

                    <div class="table-responsive table-invoice">
                        @if($data->count() > 0)
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    <th>Action</th>
                                    @foreach ($columns as $column)
                                        <th>{{ capitalize($column['title']) }}</th>
                                    @endforeach
                                </tr>
                                @foreach($data as $row)
                                    <tr>
                                        <td>
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
                                        </td>
                                        @foreach($columns as $column)
                                            <td>{{ $row[$column['field']] }}</td>
                                        @endforeach

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center p-3 text-muted">
                                <h5>No Results</h5>
                                <p>Looks like you have not added any {{ $title }} yet!</p>
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
