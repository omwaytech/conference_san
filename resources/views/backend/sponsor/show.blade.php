@extends('layouts.dash')

@section('title')
    Sponsors
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Sponsors</h4>
                        <div class="ml-auto">
                            <a href="{{ route('sponsor.create') }}" class="btn btn-primary"> Add</a>
                            <a href="{{ route('sponsor.generatePass') }}" target="_blank" class="btn btn-primary ml-2"><i class="nav-icon i-File"></i> Generate Pass</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr> 
                                    <th scope="col">#</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Publish ?</th>
                                    <th scope="col">Need To Add Participants ?</th>
                                    <th scope="col" style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sponsors as $sponsor)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$sponsor->category->category_name}}</td>
                                        <td>{{$sponsor->name}}</td>
                                        <td>{{$sponsor->amount}}</td>
                                        <td>
                                            @if ($sponsor->visible_status == 1)
                                                <a href="{{route('sponsor.changeStatus', $sponsor->id)}}" class="btn btn-success ml-2" title="Unpublish Executive"><i class="nav-icon i-Yes"></i></a>
                                            @else
                                                <a href="{{route('sponsor.changeStatus', $sponsor->id)}}" class="btn btn-danger ml-2" title="Publish Executive"><i class="nav-icon i-Close-Window"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            Total Participants: {{$sponsor->total_attendee}} <br>
                                            <button class="btn btn-sm btn-primary addParticipant" data-id="{{$sponsor->id}}" data-toggle="modal" data-target="#openModal">Add Participant's Number</button>
                                        </td>
                                        <td>
                                            <form action="{{route('sponsor.destroy', $sponsor->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{route('sponsor.edit', $sponsor->id)}}" class="btn btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal{{$sponsor->id}}"><i class="nav-icon i-Eye"></i></button>
                                                <button title="Delete Data" class="btn btn-danger delete" type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                                @if (empty($sponsor->invitation))
                                                    <button class="btn btn-primary btn-sm inviteForConference mt-1" data-id="{{$sponsor->id}}" data-toggle="modal" data-target="#openModal">Invite For Conference</button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal{{$sponsor->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">View Data</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Sponsor Category</p><span>{{$sponsor->category->category_name}}</span>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Name</p><span>{{$sponsor->name}}</span>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Amount</p><span>{{$sponsor->amount}}</span>
                                                        </div>
                                                        @if (!empty($sponsor->logo))
                                                            <div class="col-md-4 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Logo</p><span><img src="{{asset('storage/sponsors/'.$sponsor->logo)}}" height="70" alt="image"></span>
                                                            </div>
                                                        @endif
                                                        @if (!empty($sponsor->address))
                                                            <div class="col-md-4 mb-4">
                                                                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Address</p><span>{{$sponsor->address}}</span>
                                                            </div>
                                                        @endif
                                                        @if (!empty($sponsor->contact_person))
                                                            <div class="col-md-4 mb-4">
                                                                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Contact Person</p><span>{{$sponsor->contact_person}}</span>
                                                            </div>
                                                        @endif
                                                        @if (!empty($sponsor->email))
                                                            <div class="col-md-4 mb-4">
                                                                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Email</p><span>{{$sponsor->email}}</span>
                                                            </div>
                                                        @endif
                                                        <div class="col-md-4 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Phone</p><span>{{$sponsor->phone}}</span>
                                                        </div>
                                                    </div>
                                                    @if (!empty($sponsor->description))
                                                        <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Description</p>
                                                        <p>{!! $sponsor->description !!}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" id="modalContent">
                                {{-- modal body goes here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".inviteForConference").click(function (e) {
            e.preventDefault();
            var url = '{{route('sponsor.inviteForConferenceForm')}}';
            var _token = '{{csrf_token()}}'; 
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#modalContent').html(response);
            });
        });

        $(document).on("click", ".addParticipant", function (e) {
            e.preventDefault();
            var url = '{{route('sponsor.addParticipant')}}';
            var _token = '{{csrf_token()}}';
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#modalContent').html(response);
            });
        });
    });
</script>
@endsection
