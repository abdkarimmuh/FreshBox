@extends('layouts.admin-master')

@section('title')
    Manage Users
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Users</h1>
            <div class="section-header-breadcrumb">
                <form class="form-inline mr-auto" action="">
                    <div class="search-element">
                        <input class="form-control" value="{{ Request::get('query') }}" name="query" type="search"
                               placeholder="Search" aria-label="Search" data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        <div class="search-backdrop"></div>
                    </div>
                </form>
            </div>
        </div>
        <users-component></users-component>

    </section>
@endsection
