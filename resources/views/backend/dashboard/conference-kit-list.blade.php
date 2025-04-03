@extends('layouts.dash')

@section('title')
    Conference Kit List
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Attendance List of {{ $memberType }} ({{ $day }})</h4>
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
                                @foreach ($attendenceTaken as $attendee)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $attendee->user->fullname($attendee, 'user') }}</td>
                                        <td>{{ $attendee->registration_id }}</td>
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
