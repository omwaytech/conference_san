@extends('layouts.dash')

@section('title')
    Sub-Schedule
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Sub-Schedule (Schedule: {{$schedule->agenda}})</h4>
                        <div class="ml-auto">
                            <a href="{{ route('schedule.index') }}" class="btn btn-danger"> Back</a>
                            <a href="{{ route('sub-schedule.create', $schedule->slug) }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Agenda</th>
                                    <th scope="col">Halls</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col" style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedule->subSchedules->where('status', 1) as $data)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$data->agenda}}</td>
                                        <td>
                                            @if (!empty($data->hall_id))
                                                @foreach (json_decode($data->hall_id) as $hallId)
                                                    @php
                                                        $hall = DB::table('halls')->whereId($hallId)->first();
                                                    @endphp
                                                    {{$hall->hall_name}}{{$loop->last ? '' : ', ' }}
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{$data->time}}</td>
                                        <td>{{$data->duration}}</td>
                                        <td>
                                            <form action="{{route('sub-schedule.destroy', $data->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{route('sub-schedule.edit', $data->id)}}" class="btn btn-sm btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                <button title="Delete Data" class="btn btn-sm btn-danger delete" type="submit"><i class="nav-icon i-Close-Window"></i></button>
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
