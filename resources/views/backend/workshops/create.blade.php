@extends('layouts.dash')

@section('title')
    {{isset($workshop) ? 'Edit' : 'Add'}} Workshop
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($workshop) ? 'Edit' : 'Add'}} Workshop</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($workshop) ? route('workshop.update', $workshop->id) : route('workshop.store')}}" method="POST" enctype="multipart/form-data" id="workshopForm">
                        @csrf
                        @isset($workshop)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="title">Title <code>*</code></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{isset($workshop) ? $workshop->title : old('title')}}" placeholder="Enter workshop title" />
                                @error('title')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="venue">Venue <code>*</code></label>
                                <input type="text" class="form-control @error('venue') is-invalid @enderror" name="venue" id="venue" value="{{isset($workshop) ? $workshop->venue : old('venue')}}" placeholder="Enter workshop venue" />
                                @error('venue')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="start_date">Start Date <code>*</code></label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" value="{{isset($workshop) ? $workshop->start_date : old('start_date')}}" />
                                @error('start_date')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="end_date">End Date </label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{isset($workshop) ? $workshop->end_date : old('end_date')}}" />
                                @error('end_date')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="no_of_days">No. Of Days <code>*</code></label>
                                <input type="text" class="form-control @error('no_of_days') is-invalid @enderror integerValue" name="no_of_days" id="no_of_days" value="{{isset($workshop) ? $workshop->no_of_days : old('no_of_days')}}" />
                                @error('no_of_days')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="time">Time <code>*</code></label>
                                <input type="text" class="form-control @error('time') is-invalid @enderror timepicker" name="time" id="time" value="{{isset($workshop) ? $workshop->time : old('time')}}" placeholder="Enter workshop time" />
                                @error('time')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="chair_person_name">Chairperson Name <code>*</code></label>
                                <input type="text" class="form-control @error('chair_person_name') is-invalid @enderror" name="chair_person_name" id="chair_person_name" value="{{isset($workshop) ? $workshop->chair_person_name : old('chair_person_name')}}" placeholder="Enter chair person name" />
                                @error('chair_person_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="chair_person_affiliation">Chairperson/ Coordinator Affiliation <code>*</code></label>
                                <input type="text" class="form-control @error('chair_person_affiliation') is-invalid @enderror" name="chair_person_affiliation" id="chair_person_affiliation" value="{{isset($workshop) ? $workshop->chair_person_affiliation : old('chair_person_affiliation')}}" placeholder="Enter chair coordinator affiliation" />
                                @error('chair_person_affiliation')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="chair_person_image">Chariperson Image <code>* (JPG/PNG, less than 500 KB)</code></label>
                                <input type="file" class="form-control @error('chair_person_image') is-invalid @enderror" name="chair_person_image" id="image3" value="{{isset($workshop) ? $workshop->chair_person_image : old('chair_person_image')}}" />
                                @error('chair_person_image')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview3">
                                    @if (isset($workshop))
                                        <div class="col-3 mt-2">
                                            <a href="{{asset('storage/workshop/chairperson/image/'.$workshop->chair_person_image)}}" target="_blank"><img src="{{asset('storage/workshop/chairperson/image/'.$workshop->chair_person_image)}}" class="img-fluid" alt="image"></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="chair_person_cv">Chairperson CV <code>* (Only PDF, less than 250 KB)</code></label>
                                <input type="file" class="form-control @error('chair_person_cv') is-invalid @enderror" name="chair_person_cv" id="image2" value="{{isset($workshop) ? $workshop->chair_person_cv : old('chair_person_cv')}}" />
                                @error('chair_person_cv')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview2">
                                    @if (isset($workshop))
                                        <div class="col-3 mt-2">
                                            <a href="{{asset('storage/workshop/chairperson/cv/'.$workshop->chair_person_cv)}}" target="_blank"><img src="{{asset('default-images/pdf.png')}}" class="img-fluid" alt="presentation format"></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="contact_person_name">Contact Person Name <code>*</code></label>
                                <input type="text" class="form-control @error('contact_person_name') is-invalid @enderror" name="contact_person_name" id="contact_person_name" value="{{isset($workshop) ? $workshop->contact_person_name : old('contact_person_name')}}" placeholder="Enter contact person name" />
                                @error('contact_person_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="contact_person_email">Contact Person Email <code>*</code></label>
                                <input type="email" class="form-control @error('contact_person_email') is-invalid @enderror" name="contact_person_email" id="contact_person_email" value="{{isset($workshop) ? $workshop->contact_person_email : old('contact_person_email')}}" placeholder="Enter contact person email" />
                                @error('contact_person_email')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="contact_person_phone">Contact Person Phone <code>*</code></label>
                                <input type="text" class="form-control @error('contact_person_phone') is-invalid @enderror" name="contact_person_phone" id="contact_person_phone" value="{{isset($workshop) ? $workshop->contact_person_phone : old('contact_person_phone')}}" placeholder="Enter contact person phone" />
                                @error('contact_person_phone')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            @if ($authUser->role == 1)
                                <div class="col-md-3 form-group mb-3">
                                    <label for="cpd_point">CPD Point </label>
                                    <input type="text" class="form-control @error('cpd_point') is-invalid @enderror integerValue" name="cpd_point" id="cpd_point" value="{{isset($workshop) ? $workshop->cpd_point : old('cpd_point')}}" placeholder="Enter cpd point" />
                                    @error('cpd_point')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            @endif
                            <div class="col-md-3 form-group mb-3">
                                <label for="no_of_participants">No. Of Participants <code>*</code></label>
                                <input type="text" class="form-control @error('no_of_participants') is-invalid @enderror integerValue" name="no_of_participants" id="no_of_participants" value="{{isset($workshop) ? $workshop->no_of_participants : old('no_of_participants')}}" />
                                @error('no_of_participants')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="registration_deadline">Registeration Deadline <code>*</code></label>
                                <input type="date" class="form-control @error('registration_deadline') is-invalid @enderror" name="registration_deadline" id="registration_deadline" value="{{isset($workshop) ? $workshop->registration_deadline : old('registration_deadline')}}" />
                                @error('registration_deadline')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            {{-- <div class="col-md-3 form-group mb-3">
                                <label for="estimated_budget">Estimated Budget</label>
                                <input type="text" class="form-control @error('estimated_budget') is-invalid @enderror" name="estimated_budget" id="estimated_budget" value="{{isset($workshop) ? $workshop->estimated_budget : old('estimated_budget')}}" />
                                @error('estimated_budget')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div> --}}
                            <div class="col-md-12 form-group mb-3">
                                <label for="description">Description </label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{isset($workshop) ? $workshop->description : old('description')}}</textarea>
                                @error('description')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" id="submitButton">{{isset($workshop) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('workshop.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".timepicker").timepicker({
                step: 15,
                minTime: '06:00am',
            });

            $(".integerValue").on("keydown", function(event) {
            // Allow backspace, delete, tab, escape, and enter keys
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
                    // Allow Ctrl+A
                    (event.keyCode == 65 && event.ctrlKey === true) ||
                    // Allow home, end, left, right
                    (event.keyCode >= 35 && event.keyCode <= 39) ||
                    // Allow numbers from the main keyboard (0-9) and the numpad (96-105)
                    (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)) {
                return;
                } else {
                    event.preventDefault();
                }
            });

            $("#submitButton").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#workshopForm").submit();
            });
        });
    </script>
@endsection
