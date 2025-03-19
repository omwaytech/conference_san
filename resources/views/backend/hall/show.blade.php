@extends('layouts.dash')

@section('title')
    Schedule Plan
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Schedule Plan</h4>
                        <div class="ml-auto">
                            <a href="{{ route('hall.create') }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Hall</th>
                                    <th scope="col">Created Date</th>
                                    <th scope="col" style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($halls as $hall)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$hall->hall_name}}</td>
                                        <td>{{Carbon\Carbon::parse($hall->created_at)->format('d M, Y')}}</td>
                                        <td>
                                            <form action="{{route('hall.destroy', $hall->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{route('hall.edit', $hall->id)}}" class="btn btn-sm btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
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
