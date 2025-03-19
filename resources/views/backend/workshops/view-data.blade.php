<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">View Data</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Workshop Title</p><span>{{$workshop->title}}</span>
        </div>
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Date/Time/Days</p><span>{{\Carbon\Carbon::parse($workshop->start_date)->format('d M, Y')}} {{!empty($workshop->end_date) ? ' - '.\Carbon\Carbon::parse($workshop->end_date)->format('d M, Y') : ''}} ({{!empty($workshop->time) ? $workshop->time : '-'}}) ({{$workshop->no_of_days}} days)</span>
        </div>
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Venue</p><span>{{$workshop->venue}}</span>
        </div>
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Chairperson Name</p><span>{{$workshop->chair_person_name}}</span>
        </div>
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Chairperson Affiliation</p><span>{{$workshop->chair_person_affiliation}}</span>
        </div>
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Chairperson Image</p><span><a href="{{asset('storage/workshop/chairperson/image/'.$workshop->chair_person_image)}}" target="_blank"><img src="{{asset('storage/workshop/chairperson/image/'.$workshop->chair_person_image)}}" height="100" width="100" alt="chairperson image"></a></span>
        </div>
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Chairperson CV</p><span><a href="{{asset('storage/workshop/chairperson/cv/'.$workshop->chair_person_cv)}}" target="_blank"><img src="{{asset('default-images/pdf.png')}}" height="100" width="100" alt="chairperson cv"></a></span>
        </div>
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Contact Person Name</p><span>{{$workshop->contact_person_name}}</span>
        </div>
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Contact Person Email</p><span>{{$workshop->contact_person_email}}</span>
        </div>
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Contact Person Phone</p><span>{{$workshop->contact_person_phone}}</span>
        </div>
        @if (!empty($workshop->cpd_point))
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>CPD Point</p><span>{{$workshop->cpd_point}}</span>
            </div>
        @endif
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>No. Of Participants</p><span>{{$workshop->no_of_participants}}</span>
        </div>
        @if (!empty($workshop->registration_deadline))
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Registeration Deadline</p><span>{{\Carbon\Carbon::parse($workshop->registration_deadline)->format('d M, Y')}}</span>
            </div>
        @endif
    </div>
    @if (!empty($workshop->description))
        <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Description</p>
        <p>{!! $workshop->description !!}</p>
    @endif
    @if (!empty($workshop->remarks))
        <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Remarks</p>
        <p>{!! $workshop->remarks !!}</p>
    @endif
</div>
