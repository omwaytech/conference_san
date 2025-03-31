@extends('layouts.dash')

@section('title')
    Workshops
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Workshops</h4>
                        <div class="ml-auto">
                            <a href="{{ route('workshop.create') }}" class="btn btn-primary"> Add</a>
                            <a href="{{ route('workshop.coordinatorPass') }}" class="btn btn-primary ml-2" target="_blank"><i
                                    class="nav-icon i-File"></i> Generate
                                Pass For Coordinator</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Date/Days</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Deadline</th>
                                    <th scope="col">Approved Status</th>
                                    <th scope="col">No. Of Attendees</th>
                                    <th scope="col" style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workshops as $workshop)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            {{ $workshop->title }} <br>
                                            @if ($authUser->role == 1)
                                                {{ $workshop->is_applied == 1 ? '(' . $workshop->organizer->fullName($workshop, 'organizer') . ')' : '' }}
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($workshop->start_date)->format('d M, Y') }}
                                            {{ !empty($workshop->end_date) ? ' - ' . \Carbon\Carbon::parse($workshop->end_date)->format('d M, Y') : '' }}
                                            ({{ $workshop->no_of_days }} days)
                                        </td>
                                        <td>{{ !empty($workshop->time) ? $workshop->time : '-' }}</td>
                                        <td>{{ !empty($workshop->registration_deadline) ? \Carbon\Carbon::parse($workshop->registration_deadline)->format('d M, Y') : '-' }}
                                        </td>
                                        <td>
                                            @if ($workshop->is_applied == 0)
                                                <span class="badge bg-success">Original</span>
                                            @else
                                                @if ($workshop->approved_status == 0)
                                                    @if ($authUser->role == 1)
                                                        <a href="#" class="makeDecision"
                                                            data-id="{{ $workshop->id }}" data-toggle="modal"
                                                            data-target="#openModal"><span
                                                                class="badge bg-primary text-white">Pending</span></a>
                                                    @else
                                                        <span class="badge bg-primary text-white">Pending</span>
                                                    @endif
                                                @elseif ($workshop->approved_status == 1)
                                                    <span class="badge bg-success">Accepted</span>
                                                @elseif ($workshop->approved_status == 3)
                                                    <span class="badge bg-danger">Rejected</span>
                                                @elseif ($workshop->approved_status == 2)
                                                    @if ($authUser->role == 1)
                                                        <a href="#" class="makeDecision"
                                                            data-id="{{ $workshop->id }}" data-toggle="modal"
                                                            data-target="#openModal"><span
                                                                class="badge bg-warning">Pending</span></a>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{ $workshop->registrations->where('verified_status', 1)->where('status', 1)->count() }}
                                        </td>
                                        <td>
                                            <form action="{{ route('workshop.destroy', $workshop->id) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                @if ($authUser->role == 1 && $workshop->is_applied == 0)
                                                    <a href="{{ route('workshop.edit', $workshop->id) }}"
                                                        class="btn btn-sm btn-success mb-1" title="Edit Data"><i
                                                            class="nav-icon i-Pen-2"></i></a>
                                                @elseif($authUser->role == 2)
                                                    @if ($workshop->approved_status == 0 || $workshop->approved_status == 2)
                                                        <a href="{{ route('workshop.edit', $workshop->id) }}"
                                                            class="btn btn-sm btn-success mb-1" title="Edit Data"><i
                                                                class="nav-icon i-Pen-2"></i></a>
                                                    @endif
                                                @endif
                                                <button class="btn btn-sm btn-info viewData mb-1" type="button"
                                                    data-id="{{ $workshop->id }}" data-toggle="modal"
                                                    data-target="#openModal"><i class="nav-icon i-Eye"></i></button>
                                                @if ($authUser->role == 1 && $workshop->is_applied == 0)
                                                    <button title="Delete Data" class="btn btn-sm btn-danger delete mb-1"
                                                        type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                                @elseif($authUser->role == 2)
                                                    @if ($workshop->approved_status == 0 || $workshop->approved_status == 2)
                                                        <button title="Delete Data"
                                                            class="btn btn-sm btn-danger delete mb-1" type="submit"><i
                                                                class="nav-icon i-Close-Window"></i></button>
                                                    @endif
                                                @endif
                                                <br>
                                                <a href="{{ route('workshop-trainer.index', $workshop->slug) }}"
                                                    class="btn btn-sm btn-info mb-1">Trainers</a>
                                                <button class="btn btn-sm btn-primary allocatePrice mb-1" type="button"
                                                    data-id="{{ $workshop->id }}" data-toggle="modal"
                                                    data-target="#openModal">Allocate Price</button>
                                                @if ($workshop->registrations->where('status', 1)->isNotEmpty())
                                                    <a href="{{ route('workshop-registration.registrants', $workshop->slug) }}"
                                                        class="btn btn-sm btn-success mb-1">Workshop Registrations</a>
                                                    <a href="{{ route('workshop-registration.excelExport', $workshop->id) }}"
                                                        class="btn btn-sm btn-primary mb-1"><i class="nav-icon i-File"></i>
                                                        Export Registrants</a>
                                                @endif
                                                @if ($workshop->trainers->where('status', 1)->isNotEmpty())
                                                    <a href="{{ route('workshop-trainer.excelExport', $workshop->id) }}"
                                                        class="btn btn-sm btn-primary mb-1"><i class="nav-icon i-File"></i>
                                                        Export Trainer
                                                    </a>
                                                @endif
                                                @if ($workshop->discussions->isNotEmpty())
                                                    <a href="{{ route('workshop.discussions', $workshop->slug) }}"
                                                        class="btn btn-sm btn-primary mb-1">Workshop Discussions</a>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="openModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg custom-modal-width">
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
            $(document).on("click", ".viewData", function(e) {
                e.preventDefault();
                $(".modal-dialog").removeClass('custom-modal-width');
                var url = '{{ route('workshop.show') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                var data = {
                    _token: _token,
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#modalContent').html(response);
                });
            });

            $(document).on("click", ".sendBulkMail", function(e) {
                e.preventDefault();
                $(".modal-dialog").addClass('custom-modal-width');
                var url = '{{ route('workshop.sendBulkMailForm') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                var data = {
                    _token: _token,
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#modalContent').html(response);
                });
            });

            $(document).on("click", ".allocatePrice", function(e) {
                e.preventDefault();
                $(".modal-dialog").removeClass('custom-modal-width');
                var url = '{{ route('workshop.allocatePriceForm') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                var data = {
                    _token: _token,
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#modalContent').html(response);
                });
            });

            $(document).on("click", ".makeDecision", function(e) {
                e.preventDefault();
                var url = '{{ route('workshop.makeDecisionForm') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                var data = {
                    _token: _token,
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#modalContent').html(response);
                });
            });
        });
    </script>
@endsection
