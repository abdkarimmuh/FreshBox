@extends('layouts.admin-master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $config['title'] }}</h4>
                </div>
                <form action="{{ route($config['action']) }}" class="form-group"
                      method="{{ $config['method'] }}">
                    @csrf
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                @foreach($forms as $form)
                                    @if($form['type'] === 'textarea')
                                        <div class="form-group">
                                            <label>{{ $form['label'] }}</label>
                                            <textarea v-model="remark" class="form-control" id="Remarks"
                                                      name="{{ $form['name'] }}" rows="4"
                                                      cols="50">{{ $form['place_holder'] ? $form['place_holder'] : '' }}</textarea>
                                        </div>
                                    @elseif($form['type'] === 'text')
                                        <div class="form-group">
                                            <label>{{ $form['label'] }}</label>
                                            <div>
                                                <input type="{{ $form['type'] }}" name="{{ $form['name'] }}"
                                                       placeholder="{{ isset($form['place_holder']) ? $form['place_holder'] : '' }}"
                                                       class="form-control">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-12">
                                <div class="card-body">
                                    <button class="btn btn-primary">Submit</button>
                                    <a href="{{ route($config['back-button']) }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
