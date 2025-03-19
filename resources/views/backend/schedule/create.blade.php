@extends('layouts.dash')

@section('title')
    {{isset($schedule) ? 'Edit' : 'Add'}} Schedule Plan
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($schedule) ? 'Edit' : 'Add'}} Schedule Plan</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($schedule) ? route('schedule.update', $schedule->id) : route('schedule.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($schedule)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="agenda">Agenda <code>*</code></label>
                                <input type="text" class="form-control @error('agenda') is-invalid @enderror" name="agenda" value="{{isset($schedule) ? $schedule->agenda : old('agenda')}}" placeholder="Enter activity topic" />
                                @error('agenda')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="hall_id">Hall </label>
                                <select name="hall_id[]" id="hall_id" class="form-control @error('hall_id') is-invalid @enderror" multiple>
                                    @foreach ($halls as $hall)
                                        @php
                                            $hallIds = [];
                                            $isSelected = false;
                                        @endphp
                                        @if (!isset($schedule))
                                            @if (old())
                                                @php
                                                    $hallIds = old('hall_id');
                                                @endphp
                                            @endif
                                        @else
                                            @php
                                                $hallIds = json_decode($schedule->hall_id);
                                            @endphp
                                        @endif
                                        @if (!empty($hallIds))
                                            @foreach ($hallIds as $hallId)
                                                @if ($hallId == $hall->id)
                                                    @php
                                                        $isSelected = true;
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                        <option value="{{$hall->id}}" {{$isSelected ? 'selected' : ''}}>{{$hall->hall_name}}</option>
                                    @endforeach
                                </select>
                                @error('hall_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="date">Date <code>*</code></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date" value="{{isset($schedule) ? $schedule->date : old('date')}}"/>
                                @error('date')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="time">Time <code>*</code></label>
                                <input type="text" class="form-control @error('time') is-invalid @enderror timepicker" name="time" id="time" value="{{isset($schedule) ? $schedule->time : old('time')}}" placeholder="Select schedule time" />
                                @error('time')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="duration">Duration <code>*</code></label>
                                <input type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" id="duration" value="{{isset($schedule) ? $schedule->duration : old('duration')}}" placeholder="Enter duration" />
                                @error('duration')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($schedule) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('schedule.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $("#hall_id").select2();

            $(".timepicker").timepicker({
                step: 15,
                minTime: '06:00am',
            });
        });
    </script>
@endsection
