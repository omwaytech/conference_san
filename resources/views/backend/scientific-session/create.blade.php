@extends('layouts.dash')

@section('title')
    {{ isset($scientific_session) ? 'Edit' : 'Add' }} Scientific Session
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{ isset($scientific_session) ? 'Edit' : 'Add' }} Scientific Session</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form
                        action="{{ isset($scientific_session) ? route('scientific-session.update', $scientific_session->id) : route('scientific-session.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($scientific_session)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-3 form-group mb-3">
                                <label for="day">Day <code>*</code></label>
                                <select name="day" id="day"
                                    class="form-control @error('day') is-invalid @enderror">
                                    <option value="" hidden>-- Select Day --</option>
                                    @foreach ($dates as $date)
                                        <option value="{{ $date }}"
                                            @if (isset($scientific_session)) {{ $scientific_session->day == $date ? 'selected' : '' }} @else @selected(old('day') == $date) @endif>
                                            Day {{ $loop->iteration }}</option>
                                    @endforeach
                                </select>
                                @error('day')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="time">Time <code>*</code></label>
                                <input type="text" class="form-control @error('time') is-invalid @enderror timepicker"
                                    name="time" id="time"
                                    value="{{ isset($scientific_session) ? $scientific_session->time : old('time') }}"
                                    placeholder="Select schedule time" />
                                @error('time')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="duration">Duration <code>*</code></label>
                                <input type="text" class="form-control @error('duration') is-invalid @enderror"
                                    name="duration" id="duration"
                                    value="{{ isset($scientific_session) ? $scientific_session->duration : old('duration') }}"
                                    placeholder="Enter duration" />
                                @error('duration')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="category_id">Category <code>*</code></label>
                                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                    <option value="" hidden>-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', @$scientific_session->category_id) == $category->id)>
                                            {{ $category->category_name }} ( {{ $category->duration }} )</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="type">Session Type <code>*</code></label>
                                <select name="type" class="form-control" id="type">
                                    <option value="" hidden>-- Select Session Type --</option>
                                    <option value="1"
                                        @if (isset($scientific_session)) {{ $scientific_session->type == '1' ? 'selected' : '' }} @else @selected(old('type') == '1') @endif>
                                        Oral Presentation</option>
                                    <option value="2"
                                        @if (isset($scientific_session)) {{ $scientific_session->type == '2' ? 'selected' : '' }} @else @selected(old('type') == '2') @endif>
                                        Poster Presentation</option>
                                    <option value="3"
                                        @if (isset($scientific_session)) {{ $scientific_session->type == '3' ? 'selected' : '' }} @else @selected(old('type') == '3') @endif>
                                        Panel Discussion</option>
                                    <option value="4"
                                        @if (isset($scientific_session)) {{ $scientific_session->type == '4' ? 'selected' : '' }} @else @selected(old('type') == '4') @endif>
                                        Debate</option>
                                    <option value="5"
                                        @if (isset($scientific_session)) {{ $scientific_session->type == '5' ? 'selected' : '' }} @else @selected(old('type') == '5') @endif>
                                        General Activity</option>
                                    <option value="6"
                                        @if (isset($scientific_session)) {{ $scientific_session->type == '6' ? 'selected' : '' }} @else @selected(old('type') == '6') @endif>
                                        None</option>
                                </select>
                                @error('type')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3" id="topicDiv">
                                <label for="topic">Topic <code>*</code></label>
                                <input type="text" class="form-control @error('topic') is-invalid @enderror"
                                    name="topic" id="topic"
                                    value="{{ isset($scientific_session) ? $scientific_session->topic : old('topic') }}"
                                    placeholder="Enter topic" />
                                @error('topic')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="hall_id">Hall <code>*</code></label>
                                <select name="hall_id" id="hall_id"
                                    class="form-control @error('hall_id') is-invalid @enderror">
                                    <option value="" hidden>-- Select Hall --</option>
                                    @foreach ($halls as $hall)
                                        <option value="{{ $hall->id }}" @selected(old('hall_id', @$scientific_session->hall_id) == $hall->id)>
                                            {{ $hall->hall_name }}</option>
                                    @endforeach
                                </select>
                                {{-- old code --}}
                                {{-- <select name="hall_id[]" id="hall_id" class="form-control @error('hall_id') is-invalid @enderror select2" multiple>
                                    @foreach ($halls as $hall)
                                        @php
                                            $hallIds = [];
                                            $isSelected = false;
                                        @endphp
                                        @if (!isset($scientific_session))
                                            @if (old())
                                                @php
                                                    $hallIds = old('hall_id');
                                                @endphp
                                            @endif
                                        @else
                                            @php
                                                $hallIds = json_decode($scientific_session->hall_id);
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
                                </select> --}}
                                @error('hall_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3" id="screen-field" style="display: none;">
                                <label for="screen">Lobby Screen <code></code></label>
                                <select name="screen" class="form-control" id="screen">
                                    <option value="" hidden>-- Select Screen --</option>
                                    <option value="Screen 1"
                                        @if (isset($scientific_session)) {{ $scientific_session->screen == 'Screen 1' ? 'selected' : '' }} @else @selected(old('screen') == 'Screen 1') @endif>
                                        Screen 1</option>
                                    <option value="Screen 2"
                                        @if (isset($scientific_session)) {{ $scientific_session->screen == 'Screen 2' ? 'selected' : '' }} @else @selected(old('screen') == 'Screen 2') @endif>
                                        Screen 2</option>
                                    <option value="Screen 3"
                                        @if (isset($scientific_session)) {{ $scientific_session->screen == 'Screen 3' ? 'selected' : '' }} @else @selected(old('screen') == 'Screen 3') @endif>
                                        Screen 3</option>
                                    <option value="Screen 4"
                                        @if (isset($scientific_session)) {{ $scientific_session->screen == 'Screen 4' ? 'selected' : '' }} @else @selected(old('screen') == 'Screen 4') @endif>
                                        Screen 4</option>
                                    <option value="Screen 5"
                                        @if (isset($scientific_session)) {{ $scientific_session->screen == 'Screen 5' ? 'selected' : '' }} @else @selected(old('screen') == 'Screen 5') @endif>
                                        Screen 5</option>
                                    <option value="Screen 6"
                                        @if (isset($scientific_session)) {{ $scientific_session->screen == 'Screen 6' ? 'selected' : '' }} @else @selected(old('screen') == 'Screen 6') @endif>
                                        Screen 6</option>
                                </select>
                                @error('screen')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="chairperson">Chairperson <code></code></label>
                                <input type="text" class="form-control @error('chairperson') is-invalid @enderror"
                                    name="chairperson" id="chairperson"
                                    value="{{ isset($scientific_session) ? $scientific_session->chairperson : old('chairperson') }}"
                                    placeholder="Enter chairperson" />
                                @error('chairperson')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- old one --}}
                            {{-- <div class="col-md-3 form-group mb-3" id="chairpersonDiv">
                                <label for="chairperson" id="chairpersonLabel">Chairperson </label>
                                <select name="chairperson[]" id="chairperson"
                                    class="form-control @error('chairperson') is-invalid @enderror select2" multiple>
                                    @foreach ($users as $user)
                                        @php
                                            $usersId = [];
                                            $isSelected2 = false;
                                        @endphp
                                        @if (!isset($scientific_session))
                                            @if (old())
                                                @php
                                                    $usersId = old('chairperson');
                                                @endphp
                                            @endif
                                        @else
                                            @php
                                                $usersId = json_decode($scientific_session->chairperson);
                                            @endphp
                                        @endif
                                        @if (!empty($usersId))
                                            @foreach ($usersId as $userId)
                                                @if ($userId == $user->id)
                                                    @php
                                                        $isSelected2 = true;
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                        <option value="{{ $user->id }}" {{ $isSelected2 ? 'selected' : '' }}>
                                            {{ $user->fullName($user) }}</option>
                                    @endforeach
                                </select>
                                @error('chairperson')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div> --}}
                            <div class="col-md-3 form-group mb-3">
                                <label for="co_chairperson">Coordinator/Co-chairperson <code></code></label>
                                <input type="text" class="form-control @error('co_chairperson') is-invalid @enderror"
                                    name="co_chairperson" id="co_chairperson"
                                    value="{{ isset($scientific_session) ? $scientific_session->co_chairperson : old('co_chairperson') }}"
                                    placeholder="Enter coordinator" />
                                @error('co_chairperson')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- old one --}}
                            {{-- <div class="col-md-3 form-group mb-3" id="coChairpersonDiv">
                                <label for="co_chairperson">Co-Ordinator </label>
                                <select name="co_chairperson[]" id="co_chairperson"
                                    class="form-control @error('co_chairperson') is-invalid @enderror select2" multiple>
                                    @foreach ($users as $user2)
                                        @php
                                            $usersId2 = [];
                                            $isSelected3 = false;
                                        @endphp
                                        @if (!isset($scientific_session))
                                            @if (old())
                                                @php
                                                    $usersId2 = old('co_chairperson');
                                                @endphp
                                            @endif
                                        @else
                                            @php
                                                $usersId2 = json_decode($scientific_session->co_chairperson);
                                            @endphp
                                        @endif
                                        @if (!empty($usersId2))
                                            @foreach ($usersId2 as $userId2)
                                                @if ($userId2 == $user2->id)
                                                    @php
                                                        $isSelected3 = true;
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                        <option value="{{ $user2->id }}" {{ $isSelected3 ? 'selected' : '' }}>
                                            {{ $user2->fullName($user2) }}</option>
                                    @endforeach
                                </select>
                                @error('co_chairperson')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div> --}}
                            <div class="col-md-3 form-group mb-3">
                                <label for="participants">Presenter <code></code></label>
                                <input type="text" class="form-control @error('participants') is-invalid @enderror"
                                    name="participants" id="participants"
                                    value="{{ isset($scientific_session) ? $scientific_session->participants : old('participants') }}"
                                    placeholder="Enter presenter" />
                                @error('participants')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- old one --}}
                            {{-- <div class="col-md-3 form-group mb-3" id="presenterDiv">
                                <label for="participants" id="presenterLabel">Presenter </label>
                                <select name="participants[]" id="participants"
                                    class="form-control @error('participants') is-invalid @enderror select2" multiple>
                                    @foreach ($users as $user3)
                                        @php
                                            $usersId3 = [];
                                            $isSelected4 = false;
                                        @endphp
                                        @if (!isset($scientific_session))
                                            @if (old())
                                                @php
                                                    $usersId3 = old('participants');
                                                @endphp
                                            @endif
                                        @else
                                            @php
                                                $usersId3 = json_decode($scientific_session->participants);
                                            @endphp
                                        @endif
                                        @if (!empty($usersId3))
                                            @foreach ($usersId3 as $userId3)
                                                @if ($userId3 == $user3->id)
                                                    @php
                                                        $isSelected4 = true;
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                        <option value="{{ $user3->id }}" {{ $isSelected4 ? 'selected' : '' }}>
                                            {{ $user3->fullName($user3) }}</option>
                                    @endforeach
                                </select>
                                @error('participants')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div> --}}
                            <div class="col-md-12">
                                <button type="submit"
                                    class="btn btn-primary">{{ isset($scientific_session) ? 'Update' : 'Submit' }}</button>
                                <a href="{{ route('scientific-session.index') }}" class="btn btn-danger">Cancel</a>
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
        $(document).ready(function() {
            $(".select2").select2();

            $(".timepicker").timepicker({
                step: 15,
                minTime: '06:00am',
            });

            $("#type").change(function(e) {
                e.preventDefault();
                // $("#topicDiv").attr('hidden', true);
                $("#presenterDiv").attr('hidden', false);
                $("#chairpersonDiv").attr('hidden', false);
                if ($(this).val() == 1 || $(this).val() == 2) {
                    $("#chairpersonLabel").html('Chairperson');
                    $("#presenterLabel").html('Presenter');
                    $("#coChairpersonDiv").attr('hidden', false);
                } else if ($(this).val() == 3 || $(this).val() == 4) {
                    $("#chairpersonLabel").html('Moderator');
                    $("#coChairpersonDiv").attr('hidden', true);
                    if ($(this).val() == 3) {
                        $("#presenterLabel").html('Panelists');
                    } else if ($(this).val() == 4) {
                        $("#presenterLabel").html('Opponents');
                    }
                } else if ($(this).val() == 5) {
                    $("#topicDiv").attr('hidden', false);
                    $("#presenterDiv").attr('hidden', true);
                    $("#chairpersonDiv").attr('hidden', true);
                    $("#coChairpersonDiv").attr('hidden', true);
                }
            });
            $("#type").trigger("change");
            // toggle field for lobby screen
            function toggleScreenField() {
                if ($('#hall_id').val() == '6') {
                    $('#screen-field').show();
                } else {
                    $('#screen-field').hide();
                    $('#screen').val(''); // Reset value when hidden
                }
            }

            // Run on page load (if hall_id is already set)
            toggleScreenField();

            // Run on change
            $('#hall_id').change(function() {
                toggleScreenField();
            });
        });
    </script>
@endsection