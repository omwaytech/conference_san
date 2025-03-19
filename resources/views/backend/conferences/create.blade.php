@extends('layouts.dash')

@section('title')
    {{isset($conference) ? 'Edit' : 'Add'}} Conference
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($conference) ? 'Edit' : 'Add'}} Conference</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($conference) ? route('conference.update', $conference->id) : route('conference.store')}}" method="POST" enctype="multipart/form-data" id="conferenceForm">
                        @csrf
                        @isset($conference)
                            @method('patch')
                        @endisset
                        <div class="text-center">
                            <h3>Conference Details</h3>
                        </div>
                        <div class="p-4" style="border: 2px solid #ff3636;">
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="conference_theme">Conference Theme <code>*</code></label>
                                    <input type="text" class="form-control @error('conference_theme') is-invalid @enderror" name="conference_theme" id="conference_theme" value="{{isset($conference) ? $conference->conference_theme : old('conference_theme')}}" placeholder="Enter conference theme" />
                                    @error('conference_theme')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="conference_logo">Conference Logo <code>(Only JPG/PNG) (Max: 2MB)</code></label>
                                    <input type="file" class="form-control @error('conference_logo') is-invalid @enderror" name="conference_logo" id="image" />
                                    @error('conference_logo')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="row" id="imgPreview">
                                        @if (isset($conference))
                                            <div class="col-3 mt-2">
                                                <img src="{{asset('storage/conference/'.$conference->conference_logo)}}" alt="logo" class="img-fluid">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="start_date">Start Date <code>*</code></label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" id="start_date" value="{{isset($conference) ? $conference->start_date : old('start_date')}}" />
                                    @error('start_date')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="end_date">End Date <code>*</code></label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" id="end_date" value="{{isset($conference) ? $conference->end_date : old('end_date')}}" />
                                    @error('end_date')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="start_time">Start Time <code>*</code></label>
                                    <input type="text" class="form-control @error('start_time') is-invalid @enderror timepicker" name="start_time" id="start_time" value="{{isset($conference) ? $conference->start_time : old('start_time')}}" placeholder="Select start time" />
                                    @error('start_time')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="early_bird_registration_deadline">Early Bird Registration Deadline <code>*</code></label>
                                    <input type="date" class="form-control @error('early_bird_registration_deadline') is-invalid @enderror" name="early_bird_registration_deadline" id="early_bird_registration_deadline" value="{{isset($conference) ? $conference->early_bird_registration_deadline : old('early_bird_registration_deadline')}}" />
                                    @error('early_bird_registration_deadline')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-3 form-group mb-3">
                                    <label for="regular_registration_deadline">Regular Registration Deadline <code>*</code></label>
                                    <input type="date" class="form-control @error('regular_registration_deadline') is-invalid @enderror" name="regular_registration_deadline" id="regular_registration_deadline" value="{{isset($conference) ? $conference->regular_registration_deadline : old('regular_registration_deadline')}}" />
                                    @error('regular_registration_deadline')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <h3>Venue Details</h3>
                        </div>
                        <div class="p-4" style="border: 2px solid #ff3636;">
                            <div class="row">
                                <div class="col-md-4 form-group mb-3">
                                    <label for="venue_name">Venue Name <code>*</code></label>
                                    <input type="text" class="form-control @error('venue_name') is-invalid @enderror" name="venue_name" id="venue_name" value="{{isset($conference) ? $conference->venue_name : old('venue_name')}}" placeholder="Enter venue name" />
                                    @error('venue_name')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="venue_address">Venue Address <code>*</code></label>
                                    <input type="text" class="form-control @error('venue_address') is-invalid @enderror" name="venue_address" id="venue_address" value="{{isset($conference) ? $conference->venue_address : old('venue_address')}}" placeholder="Enter venue address" />
                                    @error('venue_address')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="venue_contact">Venue Contact <code>*</code></label>
                                    <input type="text" class="form-control @error('venue_contact') is-invalid @enderror" name="venue_contact" id="venue_contact" value="{{isset($conference) ? $conference->venue_contact : old('venue_contact')}}" placeholder="Enter venue contact" />
                                    @error('venue_contact')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group mb-3">
                                    <label for="location_map">Location Map <code>*</code></label>
                                    <input type="text" class="form-control @error('location_map') is-invalid @enderror" name="location_map" id="location_map" value="{{isset($conference) ? $conference->location_map : old('location_map')}}" placeholder="Enter location map" />
                                    @error('location_map')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <h3>Organizer Details</h3>
                        </div>
                        <div class="p-4" style="border: 2px solid #ff3636;">
                            <div class="row">
                                <div class="col-md-4 form-group mb-3">
                                    <label for="organizer_name">Organizer Name <code>*</code></label>
                                    <input type="text" class="form-control @error('organizer_name') is-invalid @enderror" name="organizer_name" id="organizer_name" value="{{isset($conference) ? $conference->organizer_name : old('organizer_name')}}" placeholder="Enter organizer name" />
                                    @error('organizer_name')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="organizer_logo">Organizer Logo <code>(Only JPG/PNG) (Max: 2MB)</code></label>
                                    <input type="file" class="form-control @error('organizer_logo') is-invalid @enderror" name="organizer_logo" id="image2" />
                                    @error('organizer_logo')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <div class="row" id="imgPreview2">
                                        @if (isset($conference))
                                            <div class="col-3 mt-2">
                                                <img src="{{asset('storage/conference/organizer/'.$conference->organizer_logo)}}" alt="logo" class="img-fluid">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="contact_person">Contact Person <code>*</code></label>
                                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror" name="contact_person" id="contact_person" value="{{isset($conference) ? $conference->contact_person : old('contact_person')}}" placeholder="Enter contact person name" />
                                    @error('contact_person')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="organizer_email">Organizer Email <code>*</code></label>
                                    <input type="email" class="form-control @error('organizer_email') is-invalid @enderror" name="organizer_email" id="organizer_email" value="{{isset($conference) ? $conference->organizer_email : old('organizer_email')}}" placeholder="Enter organizer email" />
                                    @error('organizer_email')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="organizer_phone">Organizer Phone <code>*</code></label>
                                    <input type="text" class="form-control @error('organizer_phone') is-invalid @enderror" name="organizer_phone" id="organizer_phone" value="{{isset($conference) ? $conference->organizer_phone : old('organizer_phone')}}" placeholder="Enter organizer phone" />
                                    @error('organizer_phone')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group mb-3">
                                    <label for="description">Description <code>*</code></label>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{isset($conference) ? $conference->description : old('description')}}</textarea>
                                    @error('description')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <button type="submit" id="submitButton" class="btn btn-primary">{{isset($conference) ? 'Update' : 'Submit'}}</button>
                            <a href="{{route('conference.index')}}" class="btn btn-danger">Cancel</a>
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
            $(".timepicker").timepicker({
                step: 15,
                minTime: '06:00am',
            });

            $("#submitButton").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#conferenceForm").submit();
            });
        });
    </script>
@endsection
