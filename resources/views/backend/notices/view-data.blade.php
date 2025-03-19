<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">View Data</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Title</p><span>{{$notice->title}}</span>
        </div>
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Date</p><span>{{\Carbon\Carbon::parse($notice->date)->format('d M, Y')}} {{!empty($notice->end_date) ? ' - '.\Carbon\Carbon::parse($notice->end_date)->format('d M, Y') : ''}} ({{!empty($notice->time) ? $notice->time : '-'}}) ({{$notice->no_of_days}} days)</span>
        </div>
        <div class="col-md-4 mb-4">
            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Image/Logo</p><span><a href="{{asset('storage/notice/'.$notice->image)}}" target="_blank"><img src="{{asset('storage/notice/'.$notice->image)}}" height="100" width="100" alt="image"></a></span>
        </div>
    </div>
    @if (!empty($notice->description))
        <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Description</p>
        <p>{!! $notice->description !!}</p>
    @endif
</div>
