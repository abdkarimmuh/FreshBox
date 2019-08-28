@extends('layouts.admin-master')

@section('title')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $title }}</h4>
                    <div class="card-header-action">
                        <a href="" class="btn btn-primary">Add <i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive table-invoice">
                        @if($data->count() > 0)
                            <table class="table table-striped">
                                <tbody>
                                <tr>
                                    @foreach ($columns as $column)
                                        <th>{{ capitalize($column['title']) }}</th>
                                    @endforeach
                                    <th></th>
                                </tr>
                                @foreach($data as $row)
                                    <tr>
                                        @foreach($columns as $column)
                                            <td>{{ $row[$column['field']] }}</td>
                                        @endforeach
                                        <td class="text-right">
                                            <button class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
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
