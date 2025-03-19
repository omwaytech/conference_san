@extends('layouts.dash')

@section('title')
    Committees
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Committees</h4>
                        <div class="ml-auto"> 
                            <a href="{{ route('committee.create') }}" class="btn btn-primary"> Add</a>
                               <a href="{{ route('committeStatus.payment') }}" class="btn btn-primary ml-2 export-excel-btn"
                                    >
                                    <i class="nav-icon i-File"></i> Export Committee status of payment
                                </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Committee Name</th>
                                    <th scope="col">Focal Person</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Members</th>
                                    <th scope="col" style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($committees as $committee)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$committee->committee_name}}</td>
                                        <td>{{$committee->focal_person}}</td>
                                        <td>{{$committee->email}}</td>
                                        <td>{{$committee->phone}}</td>
                                        <td>
                                            @if ($committee->committeeMembers->isNotEmpty())
                                                @foreach ($committee->committeeMembers->where('conference_id', $latestConference->id)->where('status', 1) as $member)
                                                    @if ($member->user)
                                                    {{$member->user->fullName($member, 'user')}}{{!($loop->last) ? ', ' : ''}}
                                                     @else
                                                     ''   
                                                    @endif
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td> 
                                        <td>
                                            <form action="{{route('committee.destroy', $committee->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{route('committee.edit', $committee->id)}}" class="btn btn-sm btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#modal{{$committee->id}}"><i class="nav-icon i-Eye"></i></button>
                                                {{-- <button title="Delete Data" class="btn btn-sm btn-danger delete" type="submit"><i class="nav-icon i-Close-Window"></i></button> --}}
                                                <a href="{{route('committeeMember.index', $committee->slug)}}" class="btn btn-sm btn-primary mt-1">Committee Members</a>
                                            </form>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal{{$committee->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Committee Name</p><span>{{$committee->committee_name}}</span>
                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Focal Person</p><span>{{$committee->focal_person}}</span>
                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Email</p><span>{{$committee->email}}</span>
                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Phone</p><span>{{$committee->phone}}</span>
                                                        </div>
                                                    </div>
                                                    @if (!empty($committee->description))
                                                        <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Description</p>
                                                        <p>{!! $committee->description !!}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
