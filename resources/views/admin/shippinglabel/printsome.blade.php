@extends('layouts.admin-master')

@section('title')
    Print Shipping Label
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
           <div class="row">
               @foreach ($data as $row)
                    <div class="col-md-4"> x</div>
               @endforeach

           </div>
        </div>
    </section>
@endsection
