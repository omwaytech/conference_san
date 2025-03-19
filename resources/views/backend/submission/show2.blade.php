@extends('layouts.dash')

@section('title')
    Presentation Submission
@endsection

@section('styles')
    <style>
        /* Increase modal width */
        .custom-modal-width {
            max-width: 90%;
        }
    </style>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Presentation Submission</h4>
                        @if (in_array(4, $userRole) || in_array(3, $userRole))
                            <div class="ml-auto">
                                <a href="{{ route('submission.test') }}" class="btn btn-primary"> Add</a>
                            </div>
                        @elseif ($userRole[0] == 1)
                            <div class="ml-auto">
                                <a href="{{ route('home') }}" class="btn btn-danger"> Back</a>
                            </div>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Presenter</th>
                                    <th scope="col">Topic</th>
                                    <th scope="col">Presentation Type</th>
                                    <th scope="col">Request Status</th>
                                    <th scope="col" style="max-width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($submissions as $submission)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$submission->user_id == auth()->user()->id ? 'Self' : 'Others For Review'}}</td>
                                        <td>{{$submission->topic}}</td>
                                        <td>
                                            @if ($submission->presentation_type == 1)
                                                Poster
                                            @elseif($submission->presentation_type == 2)
                                                Oral(Abstract)
                                            @else
                                                Full Text
                                            @endif
                                        </td>
                                        <td>
                                            @if ($submission->request_status == 0)
                                                @if ($submission->user_id == auth()->user()->id)
                                                    <span class="badge bg-primary text-white">Pending</span>
                                                @else
                                                    <button class="btn btn-sm btn-primary makeDecision" data-id="{{$submission->id}}" data-toggle="modal" data-target="#openModal">Pending</button>
                                                @endif
                                            @elseif ($submission->request_status == 1)
                                                <span class="badge bg-success">Accepted</span>
                                            @elseif ($submission->request_status == 3)
                                                <span class="badge bg-danger">Rejected</span>
                                            @elseif ($submission->request_status == 2)
                                                @if ($submission->expert_id == auth()->user()->id)
                                                    <button class="btn btn-sm btn-warning makeDecision" data-id="{{$submission->id}}" data-toggle="modal" data-target="#openModal">Correction</button>
                                                @else
                                                    <span class="badge bg-warning">Correction</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{route('submission.destroy', $submission->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                @if ($submission->user_id == auth()->user()->id)
                                                    <a href="{{route('submission.edit', $submission->id)}}" class="btn btn-success" title="Update File"><i class="nav-icon i-Pen-2"></i></a>
                                                @endif
                                                <button class="btn btn-info viewData" type="button" title="View Data" data-id="{{$submission->id}}" data-toggle="modal" data-target="#openModal"><i class="nav-icon i-Eye"></i></button>
                                                @if ($submission->user_id == auth()->user()->id)
                                                    <button title="Delete Data" class="btn btn-danger delete" type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                                @endif
                                                @php
                                                    $discussions = DB::table('submission_discussions')->where('submission_id', $submission->id)->get();
                                                @endphp
                                                @if ($discussions->isNotEmpty())
                                                    <span class="mt-1">
                                                        <a href="{{route('submission.viewDiscussion', $submission->id)}}" class="btn btn-info">Discussion</a>
                                                    </span>
                                                @endif
                                                <a href="{{route('author.index', $submission->id)}}" class="btn btn-success">Authors</a>
                                                @if ($userRole[0] == 2 || $userRole[0] == 4)
                                                    @if ($submission->request_status == 'Accepted')
                                                        <a href="{{route('submission.wordExport', $submission->id)}}" class="btn btn-success">Word File Export</a>
                                                    @endif
                                                @endif
                                            </form>
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

@section('scripts')
<script>
    $(document).ready(function () {

        $(document).on("click", ".expertForward", function () {
            var url = '{{route('submission.expertForwardForm')}}';
            var _token = '{{csrf_token()}}';
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#openModal .modal-dialog').removeClass('custom-modal-width');
                $('#modalContent').html(response);
            });
        });

        $(document).on("click", ".makeDecision", function () {
            var url = '{{route('submission.decideRequestForm')}}';
            var _token = '{{csrf_token()}}';
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#modalContent').html(response);
            });
        });

        $(document).on("click", ".viewData", function (e) {
            e.preventDefault();
            var url = '{{route('submission.viewData')}}';
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
