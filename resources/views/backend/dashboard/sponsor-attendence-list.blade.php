@extends('layouts.dash')

@section('title')
    Attendance List
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Attendance List of Sponsor ({{ $day }})</h4>
                        <div class="ml-auto">
                            <a href="{{ route('home') }}" class="btn btn-danger"> Back</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Pass Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendences as $sponsor)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $sponsor->sponsor->name }}</td>
                                        <td>{{ $sponsor->sponsor->registration_id }}</td>
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
