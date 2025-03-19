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

        .modal .select2-container {
            width: 100% !important;
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
                        <div class="ml-auto">
                            <a href="{{ route('submission.create') }}" class="btn btn-primary"> Add</a>
                            @if (auth()->user()->role == 1 ||
                                    (auth()->user()->role == 2 &&
                                        !empty($checkScientificCommitee) &&
                                        @$checkScientificCommitee->designation->designation == 'Scientific Committee Chairperson'))
                                <a href="{{ route('submission.exportExcel') }}" class="btn btn-primary ml-2"><i
                                        class="nav-icon i-File"></i> Export Excel</a>
                            @endif

                        </div>
                    </div>

                    @if (auth()->user()->role == 1 ||
                            (auth()->user()->role == 2 &&
                                !empty($checkScientificCommitee) &&
                                @$checkScientificCommitee->designation->designation == 'Scientific Committee Chairperson') ||
                            !empty($authUser->expert))
                        <div class="mb-0 mx-auto my-4 pb-4">
                            <form action="{{ route('submission.bulkWordExport') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <label class="pb-2 text-danger">Choose below field to export in word</label>
                                <div class="row">

                                    <div class="col-2 form-group mb-2">
                                        <select name="selected_presentation_type" class="form-control">
                                            <option value="" hidden>-- Select Presentation Type --</option>
                                            <option value="2">Oral</option>
                                            <option value="1">Poster</option>
                                        </select>
                                    </div>
                                    <div class="col-2 mb-2">
                                        <select name="selected_request_status" class="form-control">
                                            <option value="" hidden>-- Select Request Status --</option>
                                            <option value="1">Accepted</option>
                                            <option value="0">Pending</option>
                                            <option value="2">Correction</option>
                                            <option value="3">Rejected</option>
                                        </select>
                                    </div>

                                    <div class="col-2">
                                        <button type="button" onclick="window.location.reload();"
                                            class="btn btn-sm btn-danger">Reset</button>
                                        <button type="submit" class="btn btn-sm btn-primary">Export Word File</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    @if ($authUser->role == 1)
                                        <th scope="col">Speaker Name</th>
                                    @elseif (
                                        $authUser->role == 2 &&
                                            !empty($checkScientificCommitee) &&
                                            @$checkScientificCommitee->designation->designation == 'Scientific Committee Chairperson')
                                        <th scope="col">Speaker Name</th>
                                    @endif
                                    @if (
                                        $authUser->role == 1 ||
                                            ($authUser->role == 2 &&
                                                !empty($checkScientificCommitee) &&
                                                optional($checkScientificCommitee->designation)->designation == 'Scientific Committee Chairperson'))
                                        <th scope="col">Membership Type</th>
                                    @endif

                                    <th scope="col">Topic</th>
                                    <th scope="col">Presentation Type</th>
                                    <th scope="col">Request Status</th>
                                    @if ($authUser->role == 1)
                                        <th scope="col">Assign to Expert ?</th>
                                    @elseif (
                                        $authUser->role == 2 &&
                                            !empty($checkScientificCommitee) &&
                                            @$checkScientificCommitee->designation->designation == 'Scientific Committee Chairperson')
                                        <th scope="col">Assign to Expert ?</th>
                                    @endif
                                    <th scope="col" style="max-width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($submissions as $submission)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        @if ($authUser->role == 1)
                                            @if ($submission->user)
                                                <td>{{ !empty($submission->user->m_name) ? $submission->user->f_name . ' ' . $submission->user->m_name . ' ' . $submission->user->l_name : $submission->user->f_name . ' ' . $submission->user->l_name }}
                                                </td>
                                            @else
                                                <td>

                                                    ''
                                                </td>
                                            @endif
                                        @elseif (
                                            $authUser->role == 2 &&
                                                !empty($checkScientificCommitee) &&
                                                @$checkScientificCommitee->designation->designation == 'Scientific Committee Chairperson')
                                            @if ($submission->presenter)
                                                <td>{{ $submission->presenter->fullName($submission, 'presenter') ?? null }}
                                                </td>
                                            @else
                                                ''
                                            @endif
                                        @endif
                                        @if (
                                            $authUser->role == 1 ||
                                                ($authUser->role == 2 &&
                                                    !empty($checkScientificCommitee) &&
                                                    optional($checkScientificCommitee->designation)->designation == 'Scientific Committee Chairperson'))
                                            @if ($submission->user)
                                                <td>{{ $submission->user->userDetail->memberType->type ?? null }}</td>
                                            @else
                                                <td>''</td>
                                            @endif
                                        @endif
                                        <td>{{ $submission->topic }}</td>
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
                                                @if (
                                                    $submission->expert_id == $authUser->id ||
                                                        @$checkScientificCommitee->designation->designation == 'Scientific Committee Chairperson' ||
                                                        $authUser->role == 1)
                                                    <button class="btn btn-sm btn-primary makeDecision"
                                                        data-id="{{ $submission->id }}" data-toggle="modal"
                                                        data-target="#openModal">Pending</button>
                                                @else
                                                    <span class="badge bg-primary text-white">Pending</span>
                                                @endif
                                            @elseif ($submission->request_status == 1)
                                                <span class="badge bg-success">Accepted</span>
                                            @elseif ($submission->request_status == 3)
                                                <span class="badge bg-danger">Rejected</span>
                                            @elseif ($submission->request_status == 2)
                                                @if (
                                                    $submission->expert_id == $authUser->id ||
                                                        @$checkScientificCommitee->designation->designation == 'Scientific Committee Chairperson' ||
                                                        $authUser->role == 1)
                                                    <button class="btn btn-sm btn-warning makeDecision"
                                                        data-id="{{ $submission->id }}" data-toggle="modal"
                                                        data-target="#openModal">Correction</button>
                                                @else
                                                    <span class="badge bg-warning">Correction</span>
                                                @endif
                                            @endif
                                            @if ($authUser->role == 2 && $submission->expert_id == $authUser->id)
                                                <br>
                                                <span class="badge bg-info text-white">For Review</span>
                                            @endif
                                        </td>
                                        @if ($authUser->role == 1)
                                            <td>
                                                @if (empty($submission->expert_id))
                                                    <button class="btn btn-sm btn-primary expertForward"
                                                        data-id="{{ $submission->id }}" data-toggle="modal"
                                                        data-target="#openModal">Not Assigned</button>
                                                @else
                                                    <button class="btn btn-sm btn-success expertForward"
                                                        data-id="{{ $submission->id }}" data-toggle="modal"
                                                        data-target="#openModal">Assigned</button>
                                                @endif
                                            </td>
                                        @elseif (
                                            $authUser->role == 2 &&
                                                !empty($checkScientificCommitee) &&
                                                @$checkScientificCommitee->designation->designation == 'Scientific Committee Chairperson')
                                            <td>
                                                @if (empty($submission->expert_id))
                                                    <button class="btn btn-sm btn-primary expertForward"
                                                        data-id="{{ $submission->id }}" data-toggle="modal"
                                                        data-target="#openModal">Not Assigned</button>
                                                @else
                                                    <button class="btn btn-sm btn-success expertForward"
                                                        data-id="{{ $submission->id }}" data-toggle="modal"
                                                        data-target="#openModal">Assigned</button>
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            <form action="{{ route('submission.destroy', $submission->id) }}"
                                                method="POST">
                                                @method('delete')
                                                @csrf
                                                @if ($authUser->role == 2 && $submission->user_id == $authUser->id)
                                                    @if ($submission->request_status == 0 || $submission->request_status == 2)
                                                        <a href="{{ route('submission.edit', $submission->id) }}"
                                                            class="btn btn-sm btn-success" title="Update File"><i
                                                                class="nav-icon i-Pen-2"></i></a>
                                                    @endif
                                                @endif
                                                <button class="btn btn-sm btn-info viewData" type="button"
                                                    title="View Data" data-id="{{ $submission->id }}" data-toggle="modal"
                                                    data-target="#openModal"><i class="nav-icon i-Eye"></i></button>
                                                @if ($authUser->role == 2 && $submission->user_id == $authUser->id && $submission->request_status != 1)
                                                    <button title="Delete Data" class="btn btn-sm btn-danger delete"
                                                        type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                                @endif
                                                @php
                                                    $discussions = DB::table('submission_discussions')
                                                        ->where('submission_id', $submission->id)
                                                        ->get();
                                                @endphp
                                                @if ($discussions->isNotEmpty())
                                                    <span class="mt-1">
                                                        <a href="{{ route('submission.viewDiscussion', $submission->id) }}"
                                                            class="btn btn-sm btn-info">Discussion</a>
                                                    </span>
                                                @endif
                                                <a href="{{ route('author.index', $submission->id) }}"
                                                    class="btn btn-sm btn-success">Authors</a>
                                                {{-- @if ($userRole[0] == 2 || $userRole[0] == 4)
                                                    @if ($submission->request_status == 'Accepted')
                                                        <a href="{{route('submission.wordExport', $submission->id)}}" class="btn btn-success">Word File Export</a>
                                                    @endif
                                                @endif --}}
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="openModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
        $(document).ready(function() {

            $(document).off("click", ".expertForward");
            $(document).on("click", ".expertForward", function() {
                var url = '{{ route('submission.expertForwardForm') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                var data = {
                    _token: _token,
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#openModal .modal-dialog').removeClass('custom-modal-width');
                    $('#modalContent').html(response);
                });
            });

            $(document).off("click", ".makeDecision");
            $(document).on("click", ".makeDecision", function() {
                var url = '{{ route('submission.decideRequestForm') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                var data = {
                    _token: _token,
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#openModal .modal-dialog').removeClass('custom-modal-width');
                    $('#modalContent').html(response);
                });
            });

            $(document).off("click", ".viewData");
            $(document).on("click", ".viewData", function(e) {
                e.preventDefault();
                var url = '{{ route('submission.viewData') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                var data = {
                    _token: _token,
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#openModal .modal-dialog').removeClass('custom-modal-width');
                    $('#modalContent').html(response);
                });
            });

            $('select[name="selected_presentation_type"], select[name="selected_request_status"]')
                .on('change', function() {
                    var presentationType = $('select[name="selected_presentation_type"]').val();
                    var requestStatus = $('select[name="selected_request_status"]').val();


                    $.ajax({
                        url: "{{ route('submission.index') }}",
                        type: "GET",
                        data: {
                            presentation_type: presentationType,
                            request_status: requestStatus,
                        },
                        beforeSend: function() {
                            $('#zero_configuration_table tbody').empty();
                        },
                        success: function(data) {
                            $('#zero_configuration_table tbody').html($(data).find(
                                '#zero_configuration_table tbody').html());
                        }
                    });
                });

        });
    </script>
@endsection
