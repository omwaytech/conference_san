@extends('layouts.dash')

@section('title')
    Member Type
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Member Type</h4>
                        <div class="ml-auto">
                            <a href="{{ route('member-type.create') }}" class="btn btn-primary ml-2"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Delegate</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $type)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$type->delegate}}</td>
                                        <td>{{$type->type}}</td>
                                        <td>
                                            <a href="{{route('member-type.edit', $type->id)}}" class="btn btn-success btn-sm" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
