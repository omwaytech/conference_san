@extends('layouts.dash')

@section('title')
    Discussions
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Discussions of {{$workshop->title}}</h4>
                        <div class="ml-auto">
                            <a href="{{ route('workshop.index')}}" class="btn btn-danger"> Go Back</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Reviewer</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workshop->discussions as $discussion)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$discussion->reviewer->fullName($discussion, 'reviewer')}}</td>
                                        <td>{{$discussion->remarks}}</td>
                                        <td>
                                            @if (!empty($discussion->attachment))
                                                <a href="{{asset('storage/workshop/discussion/attachment/'.$discussion->attachment)}}" target="_blank"><img src="{{asset('default-images/pdf.png')}}" height="30" width="25" alt="cv"></a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
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
