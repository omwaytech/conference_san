<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">View Data</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-14 mr-1"></i>Applicant Name</p><span>{{$registrant->user->fullName($registrant, 'user')}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-14 mr-1"></i>Email</p><span>{{$registrant->user->email}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-14 mr-1"></i>Phone</p><span>{{$registrant->user->userDetail->phone}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-14 mr-1"></i>Institute Name</p><span>{{$registrant->user->userDetail->institute_name}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-14 mr-1"></i>Institute Address</p><span>{{$registrant->user->userDetail->address}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-14 mr-1"></i>Affiliation</p><span>{{$registrant->user->userDetail->affiliation}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-14 mr-1"></i>Delegate</p><span>{{$registrant->user->userDetail->memberType->delegate}} {{!empty($registrant->user->userDetail->country_id) ? '(' . $registrant->user->userDetail->country->country_name . ')' : ''}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-14 mr-1"></i>Membership Type</p><span>{{$registrant->user->userDetail->memberType->type}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-14 mr-1"></i>Council Number</p><span>{{$registrant->user->userDetail->council_number}}</span>
            </div>
            @if (!empty($registrant->user->userDetail->image))
                <div class="col-md-4 mb-4">
                    <p class="text-primary mb-1"><i class="i-ID-2 text-14 mr-1"></i>Image</p><span><img src="{{asset('storage/users/'.$registrant->user->userDetail->image)}}" alt="image" height="70"></span>
                </div>
            @endif
            @if (!empty($registrant->remarks))
                <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Remarks</p>
                <p>{!! $registrant->remarks !!}</p>
            @endif
        </div>
        @if (!empty($registrant->description))
            <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Description</p>
            <p>{!! $registrant->description !!}</p>
        @endif
        @if ($registrant->accompanyPersons->where('status', 1)->isNotEmpty())
            <div>
                <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Accompany Persons</p>
                <p>
                    <ol>
                        @foreach ($registrant->accompanyPersons->where('status', 1) as $accompanyPerson)
                            <li>{{$accompanyPerson->person_name}}</li>
                        @endforeach
                    </ol>
                </p>
            </div>
        @endif
    </div>
</div>
