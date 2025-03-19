@extends('layouts.dash')

@section('title')
    Authors
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Authors of {{$submission->topic}}</h4>
                        <div class="ml-auto">
                            <a href="{{route('submission.index')}}" class="btn btn-danger">Go Back</a>
                            @if ($submission->user_id == auth()->user()->id)
                                <button data-toggle="modal" data-target="#modal{{$submission->id}}" id="addAuthor" data-topic-id="{{$submission->id}}" class="btn btn-primary">Add</button>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Designation</th>
                                    <th scope="col">Phone</th>
                                    @if ($authUser->role == 2)
                                        <th scope="col" style="width: 12%">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($submission->authors->where('status', 1) as $author)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$author->name}}{!! $author->main_author == 1 ? ' <span class="badge bg-success">Main</span>' : '' !!}</td>
                                        <td>{{$author->email}}</td>
                                        <td>{{$author->designation}}</td>
                                        <td>{{!empty($author->phone) ? $author->phone : '-'}}</td>
                                        @if ($authUser->role == 2)
                                            <td>
                                                <form action="{{route('author.destroy', $author->id)}}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <a href="#" data-toggle="modal" data-target="#modal{{$submission->id}}" data-author-id="{{$author->id}}" class="btn btn-success editAuthor" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                    @if ($loop->iteration != 1)
                                                        <button title="Delete Data" class="btn btn-danger delete" type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                                    @endif
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="modal fade" id="modal{{$submission->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    {{-- modal body goes here --}}
                                </div>
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

            $('#addAuthor').on('click', function(){
                var url = '{{route('author.form')}}';
                var _token = '{{csrf_token()}}';
                var topicId = $(this).data('topic-id');
                var data = {_token:_token, topicId:topicId};
                $.post(url, data, function(response){
                    $('.modal-content').html(response);
                });
            });

            $('.editAuthor').on('click', function(){
                var url = '{{route('author.form')}}';
                var _token = '{{csrf_token()}}';
                var topicId = $("#addAuthor").data('topic-id');
                var authorId = $(this).data('author-id');
                var data = {_token:_token, topicId:topicId, authorId:authorId};
                $.post(url, data, function(response){
                    $('.modal-content').html(response);
                });
            });

        });
    </script>
@endsection
