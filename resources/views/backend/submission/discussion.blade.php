@extends('layouts.dash')

@section('title')
    Discussion
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Discussion for topic {{$submission->topic}}</h4>
                        <div class="ml-auto">
                            <a href="{{ route('submission.index') }}" class="btn btn-danger">Go Back</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    @if ($authUser->role == 1)
                                        <th scope="col">Sender</th>
                                    @elseif ($authUser->role == 2 && !empty($checkScientificCommitee))
                                        <th scope="col">Sender</th>
                                    @endif
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Attachment</th>
                                    <th scope="col">Scientific Commitee Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($discussions as $discussion)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        @php
                                            $scientificCommittee = DB::table('committees')->where('committee_name', 'Scientific Committee')->first();
                                            $isSenderCommittee = DB::table('committee_members')->where(['user_id' => $discussion->sender_id, 'conference_id' => $latestConference->id, 'committee_id' => $scientificCommittee->id, 'status' => 1])->first();
                                        @endphp
                                        @if ($authUser->role == 1)
                                            <td>{{$discussion->sender->fullName($discussion, 'sender')}} ({{!empty($isSenderCommittee) ? 'Committee Member' : 'Expert'}})</td>
                                        @elseif ($authUser->role && !empty($checkScientificCommitee))
                                            <td>{{$discussion->sender->fullName($discussion, 'sender')}} ({{!empty($isSenderCommittee) ? 'Committee Member' : 'Expert'}})</td>
                                        @endif
                                        <td>{{$discussion->remarks}}</td>
                                        <td>
                                            @if (!empty($discussion->attachment))
                                                <a href="{{asset('storage/submission/discussion/'.$discussion->attachment)}}" target="_blank"><img src="{{asset('default-images/pdf.png')}}" alt="attachment" height="30"></a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($authUser->role == 2)
                                                @if (!empty($checkScientificCommitee))
                                                    <button type="button" class="btn btn-primary btn-sm openModal" data-id="{{$discussion->id}}" data-toggle="modal" data-target="#modal">Comment</button>
                                                @else
                                                    @if ($discussion->expert_visible && $discussion->submission->expert_id == $authUser->id)
                                                        {{$discussion->committee_remarks}}
                                                    @elseif ($discussion->presenter_visible && $discussion->submission->user_id == $authUser->id)
                                                        {{$discussion->committee_remarks}}
                                                    @else
                                                        -
                                                    @endif
                                                @endif
                                            @else
                                                {{ !empty($discussion->committee_remarks) ? $discussion->committee_remarks : '-' }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
            $(".openModal").click(function () {
                var url = '{{route('submission.committeeCommentForm')}}';
                var _token = '{{csrf_token()}}';
                var id = $(this).data('id');
                var data = {_token:_token, id:id};
                $.post(url, data, function(response){
                    $('.modal-content').html(response);
                });
            });
        });
    </script>
@endsection
