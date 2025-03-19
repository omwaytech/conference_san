<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">View Data</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Conference Theme</p><span>{{$conference->conference_theme}}</span>
            </div>
            @if (!empty($conference->conference_logo))
                <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Conference Logo</p><span><img src="{{asset('storage/conference/'.$conference->conference_logo)}}" height="100" width="100" alt="conference logo"></span>
                </div>
            @endif
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Date/Time</p><span>{{\Carbon\Carbon::parse($conference->start_date)->format('d M, Y')}} - {{\Carbon\Carbon::parse($conference->end_date)->format('d M, Y')}} ({{$conference->start_time}})</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Venue Name</p><span>{{$conference->venue_name}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Venue Address</p><span>{{$conference->venue_address}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Venue Contact</p><span>{{$conference->venue_contact}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Organizer Name</p><span>{{$conference->organizer_name}}</span>
            </div>
            @if (!empty($conference->organizer_logo))
                <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Organizer Logo</p><span><img src="{{asset('storage/conference/organizer/'.$conference->organizer_logo)}}" height="100" width="100" alt="organizer logo"></span>
                </div>
            @endif
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Contact Person</p><span>{{$conference->contact_person}}</span>
            </div>
            @if (!empty($conference->organizer_email))
                <div class="col-md-4 mb-4">
                    <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Organizer Email</p><span>{{$conference->organizer_email}}</span>
                </div>
            @endif
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Organizer Phone</p><span>{{$conference->organizer_phone}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Early Bird Registration Deadline</p><span>{{\Carbon\Carbon::parse($conference->early_bird_registration_deadline)->format('d M, Y')}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Regular Registration Deadline</p><span>{{\Carbon\Carbon::parse($conference->regular_registration_deadline)->format('d M, Y')}}</span>
            </div>
        </div>
        @if (!empty($conference->description))
            <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Description</p>
            <p>{!! $conference->description !!}</p>
        @endif
    </div>
</div>
