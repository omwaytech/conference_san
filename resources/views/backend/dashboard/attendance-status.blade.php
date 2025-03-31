@extends('layouts.dash')

@section('title')
    Attendance Status
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">
                            Atttendance Status
                        </h4>
                        <div class="ml-auto">
                            <a href="{{ route('conference.openConferencePortal', $conference->slug) }}"
                                class="btn btn-danger"> Back</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Applicant Name</th>
                                    <th scope="col">Delegate</th>
                                    <th scope="col">Membership Type</th>
                                    <th scope="col">Attendance</th>
                                    <th scope="col">Meal</th>

                                    {{-- <th scope="col">Dinner</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrants as $registrant)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        @php
                                            $middleName = !empty($registrant->m_name) ? $registrant->m_name . ' ' : '';
                                            $name = $registrant->f_name . ' ' . $middleName . $registrant->l_name;
                                            $attendances = DB::table('attendances')
                                                ->where('conference_registration_id', $registrant->id)
                                                ->get();
                                            $meals = DB::table('meals')
                                                ->where('conference_registration_id', $registrant->id)
                                                ->get();
                                        @endphp
                                        <td>{{ $name }}</td>
                                        <td>{{ $registrant->delegate }}</td>
                                        <td>{{ $registrant->type }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($attendances as $attendance)
                                                    <li>{{ Carbon\Carbon::parse($attendance->created_at)->format('d M') }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            @if ($meals->isNotEmpty())
                                                <ul>
                                                    @foreach ($meals as $meal)
                                                        @php
                                                            $totalLunchRemaining = $registrant->total_attendee;
                                                            $totalDinnerRemaining = $registrant->total_attendee;
                                                            $checkMeal = DB::table('meals')
                                                                ->where('conference_registration_id', $registrant->id)
                                                                ->where('created_at', $meal->created_at)
                                                                ->first();
                                                            // dd($checkMeal);

                                                            if (!empty($checkMeal)) {
                                                                $totalLunchRemaining =
                                                                    $registrant->total_attendee -
                                                                    $checkMeal->lunch_taken;
                                                                $totalDinnerRemaining =
                                                                    $registrant->total_attendee -
                                                                    $checkMeal->dinner_taken;
                                                            }
                                                        @endphp
                                                        <li>{{ Carbon\Carbon::parse($meal->created_at)->format('d M') }}
                                                            <ul>
                                                                <li>Launch:
                                                                    {{ $meal->lunch_taken == 1 ? 'Taken' : 'Not Taken' }}
                                                                    (Remaining:{{ $totalLunchRemaining }})
                                                                </li>
                                                                <li>Dinner:
                                                                    {{ $meal->dinner_taken == 1 ? 'Taken' : 'Not Taken' }}
                                                                    (Remaining:{{ $totalDinnerRemaining }})
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                Not Taken Yet
                                            @endif
                                        </td>
                                        {{-- <td>
                                            Attendance: @if ($registrant->attendance_status_2 == 0) <span class="badge bg-warning">Not Taken</span> @else <span class="badge bg-success">Taken</span> @endif <br>
                                            Lunch/Dinner: @if ($registrant->remaining_dinner_2 == 0) <span class="badge bg-success">Taken</span> @else Remaining-{{$registrant->remaining_dinner_2}} @endif <br>
                                        </td> --}}
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
