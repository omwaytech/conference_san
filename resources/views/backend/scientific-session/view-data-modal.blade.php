<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">View Data</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Day</p>
                <span>
                    @foreach ($dates as $date)
                        @if ($scientific_session->day == $date)
                            Day {{$loop->iteration}}
                        @endif
                    @endforeach
                </span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Time</p><span>{{$scientific_session->time}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Duration</p><span>{{$scientific_session->duration}}</span>
            </div>
            @if (!empty($scientific_session->topic))
                <div class="col-md-4 mb-4">
                    <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Topic</p><span>{{$scientific_session->topic}}</span>
                </div>
            @endif
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Category</p><span>{{$scientific_session->category->category_name}}</span>
            </div>
            <div class="col-md-4 mb-4">
                <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Session Type</p>
                <span>
                    @if ($scientific_session->type == 1)
                        Oral Presentation
                    @elseif ($scientific_session->type == 2)
                        Poster Presentation
                    @elseif ($scientific_session->type == 3)
                        Panel Discussion
                    @elseif ($scientific_session->type == 4)
                        Debate
                    @elseif ($scientific_session->type == 5)
                        General Activity
                    @elseif ($scientific_session->type == 6)
                        None
                    @endif
                </span>
            </div>
            @if (!empty($scientific_session->hall_id))
                <div class="col-md-4 mb-4">
                    <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>Hall</p>
                    <span>
                        {{$scientific_session->hall->hall_name}}
                        {{-- old code --}}
                        {{-- @php
                            $halls = DB::table('halls')->whereIn('id', json_decode($scientific_session->hall_id))->get();
                        @endphp
                        @foreach ($halls as $hall)
                            {{$hall->hall_name}}{{$loop->last ? '' : ','}}
                        @endforeach --}}
                    </span>
                </div>
            @endif
            @if (!empty($scientific_session->chairperson))
                <div class="col-md-4 mb-4">
                    <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>
                        @if ($scientific_session->type == 1 || $scientific_session->type == 2)
                            Chairperson
                        @elseif ($scientific_session->type == 3 || $scientific_session->type == 4)
                            Moderator
                        @endif
                    </p>
                    <span>
                        @php
                            $users = App\Models\User::whereIn('id', json_decode($scientific_session->chairperson))->get();
                        @endphp
                        @foreach ($users as $user)
                            {{$user->fullName($user)}}{{$loop->last ? '' : ','}}
                        @endforeach
                    </span>
                </div>
            @endif
            @if (!empty($scientific_session->co_chairperson))
                <div class="col-md-4 mb-4">
                    <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i> Co-Ordinator</p>
                    <span>
                        @php
                            $users2 = App\Models\User::whereIn('id', json_decode($scientific_session->co_chairperson))->get();
                        @endphp
                        @foreach ($users2 as $user2)
                            {{$user2->fullName($user2)}}{{$loop->last ? '' : ','}}
                        @endforeach
                    </span>
                </div>
            @endif
            @if (!empty($scientific_session->participants))
                <div class="col-md-4 mb-4">
                    <p class="text-primary mb-1"><i class="i-ID-2 text-16 mr-1"></i>
                        @if ($scientific_session->type == 1 || $scientific_session->type == 2)
                            Presenter
                        @elseif ($scientific_session->type == 3)
                            Panelists
                        @elseif ($scientific_session->type == 4)
                            Opponents
                        @endif
                    </p>
                    <span>
                        @php
                            $users3 = App\Models\User::whereIn('id', json_decode($scientific_session->participants))->get();
                        @endphp
                        @foreach ($users3 as $user3)
                            {{$user3->fullName($user3)}}{{$loop->last ? '' : ','}}
                        @endforeach
                    </span>
                </div>
            @endif
        </div>
    </div>
</div>
