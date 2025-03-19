@extends('layouts.dash')

@section('title')
    Sponsor Invitation
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Sponsor Invitation</h4>
                        <div class="ml-auto">
                            <a href="{{ route('sponsor-invitation.create') }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Image/Logo</th>
                                    <th scope="col">No. of people</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sponsors as $sponsor)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{empty($sponsor->sponsor_id) ? $sponsor->name : $sponsor->sponsor->name}}</td>
                                        <td>{{empty($sponsor->sponsor_id) ? $sponsor->email : $sponsor->sponsor->email}}</td>
                                        <td>{{empty($sponsor->sponsor_id) ? $sponsor->phone : $sponsor->sponsor->phone}}</td>
                                        <td>{{empty($sponsor->sponsor_id) ? $sponsor->address : $sponsor->sponsor->address}}</td>
                                        <td>
                                            @if (empty($sponsor->sponsor_id))
                                                <img src="{{asset('storage/sponsors/'.$sponsor->image)}}" alt="image" height="50" width="50">
                                            @else
                                                <img src="{{asset('storage/sponsors/'.$sponsor->sponsor->logo)}}" alt="image" height="50" width="50">
                                            @endif
                                        </td>
                                        <td>{{$sponsor->no_of_people}}</td>
                                        <td>
                                            <form action="{{route('sponsor-invitation.destroy', $sponsor->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                @if (empty($sponsor->sponsor_id))
                                                    <a href="{{route('sponsor-invitation.edit', $sponsor->id)}}" class="btn btn-sm btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                @endif
                                                <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#modal{{$sponsor->id}}"><i class="nav-icon i-Eye"></i></button>
                                                <button title="Delete Data" class="btn btn-sm btn-danger delete" type="submit"><i class="nav-icon i-Close-Window"></i></button>
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
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Name</p><span>{{empty($sponsor->sponsor_id) ? $sponsor->name : $sponsor->sponsor->name}}</span>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Email</p><span>{{empty($sponsor->sponsor_id) ? $sponsor->email : $sponsor->sponsor->email}}</span>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Phone</p><span>{{empty($sponsor->sponsor_id) ? $sponsor->phone : $sponsor->sponsor->phone}}</span>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Address</p><span>{{empty($sponsor->sponsor_id) ? $sponsor->address : $sponsor->sponsor->address}}</span>
                                                        </div>
                                                        @if (!empty($sponsor->image) || !empty($sponsor->sponsor->logo))
                                                            <div class="col-md-4 mb-4">
                                                                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Image/Logo</p>
                                                                <span>
                                                                    @if (empty($sponsor->sponsor_id))
                                                                        <img src="{{asset('storage/sponsors/'.$sponsor->image)}}" height="100" width="100" alt="image">
                                                                    @else
                                                                        <img src="{{asset('storage/sponsors/'.$sponsor->sponsor->logo)}}" height="100" width="100" alt="image">
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if (!empty($sponsor->description) || !empty($sponsor->sponsor->description))
                                                        <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1"></i>Description</p>
                                                        <p>{!! empty($sponsor->sponsor_id) ? $sponsor->description : $sponsor->sponsor->description !!}</p>
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
