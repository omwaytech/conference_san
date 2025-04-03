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
                        <h4 class="card-title">{{ $mealType }} List of Sponsor ({{ $day }})</h4>
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
                                @foreach ($meals as $meal)
                                    {{-- @dd($sponsor) --}}
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $meal->sponsor->name }}</td>
                                        <td>

                                            {{ $meal->sponsor->registration_id }}
                                            @if ($mealType == 'lunch')
                                                (Taken:{{ $meal->lunch_taken }})
                                            @endif
                                            @if ($mealType == 'dinner')
                                                (Taken:{{ $meal->dinner_taken }})
                                            @endif
                                        </td>
                                        <td>
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
