<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">View Data</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <div class="row">
            @if ($authUser->role == 1 || !empty($checkScientificCommitee))
                <div class="col-md-4 mb-4">
                    <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Presenter Name</p><span>{{$submission->presenter->fullName($submission, 'presenter')}}</span>
                </div>
            @endif
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Presentation Type</p>
                <span>
                    @if ($submission->presentation_type == 1)
                        Poster
                    @elseif($submission->presentation_type == 2)
                        Oral(Abstract)
                    @else
                        Full Text
                    @endif
                </span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Topic</p><span>{{$submission->topic}}</span>
            </div>
            @if (!empty($submission->keywords))
                <div class="col-md-4 mb-4">
                    <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Keywords</p><span>{{$submission->keywords}}</span>
                </div>
            @endif
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Request Status</p>
                <span>
                    @if ($submission->request_status == 0)
                        <span class="badge bg-primary text-white">Pending</span>
                    @elseif ($submission->request_status == 1)
                        <span class="badge bg-success">Accepted</span>
                    @elseif ($submission->request_status == 3)
                        <span class="badge bg-danger">Rejected</span>
                    @elseif ($submission->request_status == 2)
                        <span class="badge bg-warning">Correction</span>
                    @endif
                </span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Has Presented Before?</p><span>{{ $submission->has_presented_before == '1' ? 'Yes' : 'No' }}</span>
            </div>
            @if (!empty($submission->presentation_place))
                <div class="col-md-4 mb-4">
                    <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Place of Presentation</p><span>{{ $submission->presentation_place }}</span>
                </div>
            @endif
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Presentation File</p>
                <span>
                    @if (!empty($submission->presentation_file))
                        @php
                            $extension = explode('.', $submission->presentation_file);
                        @endphp
                        @if ($extension[1] == 'pdf')
                            <a href="{{asset('storage/submission/presentation-file/'.$submission->presentation_file)}}" target="_blank"><img src="{{asset('default-images/pdf.png')}}" height="50" alt="presentation file"></a>
                        @elseif ($extension[1] == 'doc' || $extension[1] == 'docx')
                            <a href="{{asset('storage/submission/presentation-file/'.$submission->presentation_file)}}" target="_blank"><img src="{{asset('default-images/word.png')}}" height="50" alt="presentation file"></a>
                        @else
                            <a href="{{asset('storage/submission/presentation-file/'.$submission->presentation_file)}}" target="_blank"><img src="{{asset('default-images/ppt.png')}}" height="50" alt="presentation file"></a>
                        @endif
                    @else
                        File Not Submitted
                    @endif
                </span>
            </div>
            @if (!empty($submission->attachment))
                <div class="col-md-4 mb-4">
                    <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Attachment</p>
                    <span>
                        <a href="{{asset('storage/submission/discussion/'.$submission->attachment)}}" target="_blank"><img src="{{asset('default-images/pdf.png')}}" height="50" alt="attachment"></a>
                    </span>
                </div>
            @endif
            @if (!empty($submission->expert_id))
                @if ($authUser->role == 1)
                    <div class="col-md-4 mb-4">
                        <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Assigned Expert:</p><span>{{$submission->expert->fullName($submission, 'expert')}}</span>
                    </div>
                @elseif ($authUser->role == 2)
                    @if ($submission->user_id != $authUser->id && !empty($checkScientificCommitee))
                        <div class="col-md-4 mb-4">
                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Assigned Expert:</p><span>{{$submission->expert->fullName($submission, 'expert')}}</span>
                        </div>
                    @endif
                @endif
            @endif
        </div>
        @if (!empty($submission->cover_letter))
            <div>
                <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Cover Letter</p>
                <p>{!! $submission->cover_letter !!}</p>
            </div>
        @endif
        @if (!empty($submission->abstract_content))
            <div>
                <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Abstract Content</p>
                <p>{!! $submission->abstract_content !!}</p>
            </div>
        @endif
        @if (!empty($submission->remarks))
            <div>
                <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Remarks</p>
                <p>{!! $submission->remarks !!}</p>
            </div>
        @endif
    </div>
</div>
