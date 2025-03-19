@extends('layouts.dash')

@section('title')
    Designation
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Designation</h4>
                        <div class="ml-auto">
                            <a href="{{ route('designation.order') }}" class="btn btn-info"> Order</a>
                            <a href="{{ route('designation.create') }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Created Date</th>
                                    <th scope="col" style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($designations as $designation)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$designation->designation}}</td>
                                        <td>{{Carbon\Carbon::parse($designation->created_at)->format('d M, Y')}}</td>
                                        <td>
                                            <form action="{{route('designation.destroy', $designation->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{route('designation.edit', $designation->id)}}" class="btn btn-sm btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                {{-- <button title="Delete Data" class="btn btn-sm btn-danger delete" type="submit"><i class="nav-icon i-Close-Window"></i></button> --}}
                                            </form>
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
