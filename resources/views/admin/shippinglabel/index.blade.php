@extends('layouts.admin-master')

@section('title')
    Shipping Label
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">

                        <div class="card">
                            <div class="card-header">
                                <div class="card-header">
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <h4 class="text-danger">Shipping Label</h4>
                                            <a href= "{{route('admin.warehouseIn.shippinglable.printall') }}" class="btn btn-danger" style="color: white;">Print All ({{$total}}) <i class="fas fa-print"></i></a> &nbsp;
                                            <a type="button" href="{{route('admin.warehouseIn.shippinglable.printsome', ['date' => request('date'), 'page'=>request('page')])}}" id="printcheckbox" style="color: white; display:none;" class="btn btn-primary">Print <i class="fas fa-print"></i></a>
                                            {{-- <button type="submit" class="btn btn-primary" ></button> --}}

                                        </div>

                                    </div>
                                    <div class="card-header-action ml-0 mt-3 mb-3">
                                        <form action="#" method="get" id="search">
                                            <div class="input-group">
                                                <input type="text" class="form-control daterange-cus">
                                                <input type="text" placeholder="Search" name="search" class="form-control">
                                                <div class="input-group-btn ml-1">
                                                    <button class="btn btn-danger"><i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                  <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                            <thead>
                                                <tr>
                                                    <th>
                                                    <div class="custom-checkbox custom-control">
                                                         <input  type="checkbox" id="select_all">

                                                    </div>

                                                    </th>
                                                    <th>Barcode</th>
                                                    <th>Customer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $row)
                                                    <tr>
                                                        <td>
                                                            <div class="custom-checkbox">
                                                                <input  type="checkbox" class="checkbox" name="idcheckbox[]" value="{{ $row->delivery_order_no }}">
                                                            </div>
                                                          </td>
                                                        <td>
                                                            {!!DNS1D::getBarcodeSVG($row->delivery_order_no, 'C39')!!}
                                                        </td>
                                                        <td>{{$row->customer->name}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-left">
                                    <p>{{$tableinfo}}</p>
                                  </div>
                                  <div class="float-right">
                                    <nav>
                                      <ul class="pagination">
                                        {{$data->links()}}
                                      </ul>
                                    </nav>
                                  </div>
                            </div>
                        </div>

                </div>
            </div>

        </div>
    </section>
@endsection
