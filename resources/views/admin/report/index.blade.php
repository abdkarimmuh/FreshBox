@extends('layouts.admin-master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-lg-9">
                        <div class="row">
                            <h4 class="text-danger">{{ $config['title'] }}</h4>
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
                                
                                    <table class="table table-bordered table-md">
                                        <tbody>
                                        <tr>
                                            @isset($config['route-multiple-print'])
                                                <th>
                                                    <input type="checkbox" id="checked_all">
                                                </th>
                                            @endisset
                                            @if( isset($config['route-edit']) || isset($config['route-delete']) || isset($config['route-view']) || isset($config['route-confirm']) )
                                                <th width="150px">Action</th>
                                            @endif
                                            @foreach ($columns as $column)
                                                <th style="overflow:hidden; white-space:nowrap">{{ capitalize($column['title']) }}</th>
                                            @endforeach
                                        </tr>
                                      
                                        </tbody>
                                    </table>
                               
                                    <div class="text-center p-3 text-muted">
                                        <h5>No Results</h5>
                                        <p>Looks like you have not added any {{ $config['title'] }} yet!</p>
                                    </div>
                            </div>
                            @isset($config['route-multiple-print'])
                        </form>
                    @endisset
                </div>
               
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
    $('input[name="search"]').daterangepicker();
    </script>
    
@endpush
