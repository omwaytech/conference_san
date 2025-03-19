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
                            <a href="{{ route('schedule.create') }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Agenda</th>
                                    <th scope="col">Halls</th>
                                    <th scope="col">Schedule Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col" style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$schedule->agenda}}</td>
                                        <td>
                                            @if (!empty($schedule->hall_id))
                                                @foreach (json_decode($schedule->hall_id) as $hallId)
                                                    @php
                                                        $hall = DB::table('halls')->whereId($hallId)->first();
                                                    @endphp
                                                    {{$hall->hall_name}}{{$loop->last ? '' : ', ' }}
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{Carbon\Carbon::parse($schedule->date)->format('d M, Y')}}</td>
                                        <td>{{$schedule->time}}</td>
                                        <td>{{$schedule->duration}}</td>
                                        <td>
                                            <form action="{{route('schedule.destroy', $schedule->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{route('schedule.edit', $schedule->id)}}" class="btn btn-sm btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                <button title="Delete Data" class="btn btn-sm btn-danger delete" type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                                <a href="{{route('sub-schedule.index', $schedule->slug)}}" class="btn btn-sm btn-primary mt-1">Sub-Schedule</a>
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
