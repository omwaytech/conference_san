@extends('layouts.dash')

@section('title')
    Hotels
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Hotels</h4>
                        <div class="ml-auto">
                            <a href="{{ route('hotel.create') }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Hotel Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Contact Person</th>
                                    <th scope="col">Contact Number</th>
                                    <th scope="col">Is Featured ?</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotels as $hotel)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$hotel->name}}</td>
                                        <td>{{$hotel->address}}</td>
                                        <td>{{$hotel->contact_person}}</td>
                                        <td>{{$hotel->phone}}</td>
                                        <td>
                                            @if ($hotel->visible_status == 1)
                                                <a href="{{route('hotel.changeStatus', $hotel->id)}}" class="btn btn-sm btn-success ml-2" title="Unfeature Hotel"><i class="nav-icon i-Yes"></i></a>
                                            @else
                                                <a href="{{route('hotel.changeStatus', $hotel->id)}}" class="btn btn-sm btn-warning ml-2" title="Feature Hotel"><i class="nav-icon i-Close-Window"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{route('hotel.destroy', $hotel->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{route('hotel.edit', $hotel->id)}}" class="btn btn-sm btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#modal{{$hotel->id}}"><i class="nav-icon i-Eye"></i></button>
                                                <button title="Delete Data" class="btn btn-sm btn-danger delete" type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal{{$hotel->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">View Data</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Hotel Name</p><span>{{$hotel->name}}</span>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Address</p><span>{{$hotel->address}}</span>
                                                        </div>
                                                        @if (!empty($hotel->contact_person))
                                                            <div class="col-md-4 mb-4">
                                                                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Contact Person</p><span>{{$hotel->contact_person}}</span>
                                                            </div>
                                                        @endif
                                                        @if (!empty($hotel->phone))
                                                            <div class="col-md-4 mb-4">
                                                                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Phone</p><span>{{$hotel->phone}}</span>
                                                            </div>
                                                        @endif
                                                        @if (!empty($hotel->email))
                                                            <div class="col-md-4 mb-4">
                                                                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Email</p><span>{{$hotel->email}}</span>
                                                            </div>
                                                        @endif
                                                        @if (!empty($hotel->rating))
                                                            <div class="col-md-4 mb-4">
                                                                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Rating</p><span>{{$hotel->rating}}</span>
                                                            </div>
                                                        @endif
                                                        @if (!empty($hotel->price))
                                                            <div class="col-md-4 mb-4">
                                                                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Price</p><span>{{$hotel->price}}</span>
                                                            </div>
                                                        @endif
                                                        @if (!empty($hotel->price))
                                                            <div class="col-md-4 mb-4">
                                                                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Website</p><span>{{$hotel->website}}</span>
                                                            </div>
                                                        @endif
                                                        @if (!empty($hotel->logo))
                                                            <div class="col-md-4 mb-4">
                                                                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Logo</p><span><img src="{{asset('storage/hotel/featured-image/'.$hotel->featured_image)}}" height="100" width="100" alt="image"></span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if (!empty($hotel->images))
                                                        <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Images</p>
                                                        <div class="row">
                                                            @foreach ($hotel->images as $img)
                                                                <div class="col-2 mt-1">
                                                                    <img src="{{asset('storage/hotel/images/thumbnail/'.$img['fileName'])}}" height="100" alt="img">
                                                                    <p class="text-center">{{$img['room_type']}}</p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    @if (!empty($hotel->description))
                                                        <div class="my-2">
                                                            <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1 mt-1"></i>Description</p>
                                                            <p>{!! $hotel->description !!}</p>
                                                        </div>
                                                    @endif
                                                    @if (!empty($hotel->facility))
                                                        <div class="my-2">
                                                            <p class="text-primary mb-1"><i class="i-Letter-Open text-16 mr-1 mt-1"></i>Facility</p>
                                                            <p>{!! $hotel->facility !!}</p>
                                                        </div>
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
