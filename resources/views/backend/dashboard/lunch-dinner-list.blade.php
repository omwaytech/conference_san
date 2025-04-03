@extends('layouts.dash')

@section('title')
    Lunch/Dinner List
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">{{$mealType}} List of {{ $memberType }} ({{ $day }})</h4>
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
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mealTaken as $attendee)
                                    {{-- @dd($attendee) --}}
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $attendee->user->fullname($attendee, 'user') }}</td>
                                        <td>
                                            @php
                                                if ($mealType == 'lunch') {
                                                    $accompanyPersonsCount = $attendee->meal->lunch_taken;
                                                } elseif ($mealType == 'dinner') {
                                                    $accompanyPersonsCount = $attendee->meal->dinner_taken;
                                                }
                                            @endphp
                                            {{ $attendee->user->conferenceRegistration->registration_id }}
                                            (Taken:{{ $accompanyPersonsCount }})
                                        </td>
                                        <td>
                                            @php
                                                $meal = DB::table('meals')
                                                    ->where(
                                                        'conference_registration_id',
                                                        $attendee->user->conferenceRegistration->id,
                                                    )
                                                    ->first();
                                            @endphp
                                            {{ \Carbon\Carbon::parse($meal->created_at)->format('h:i A') }}
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
