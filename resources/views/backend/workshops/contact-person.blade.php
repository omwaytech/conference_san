@extends('layouts.dash')

@section('title')
    Applied Workshops
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Applied Workshops</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Coordinator Name</th>
                                    <th scope="col">Preferred Date</th>
                                    <th scope="col">No of Days</th>
                                    <th scope="col">Request Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workshops as $workshop)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$workshop->title}}</td>
                                        <td>{{$workshop->chair_person}}</td>
                                        <td>{{\Carbon\Carbon::parse($workshop->start_date)->format('d M, Y')}}</td>
                                        <td>{{$workshop->no_of_days}}</td>
                                        <td>
                                            @if ($workshop->approved_status == 0)
                                                <span class="badge badge-secondary">Pending</span>
                                            @elseif ($workshop->approved_status == 1)
                                                <span class="badge badge-success">Accepted</span>
                                            @elseif ($workshop->approved_status == 2)
                                                <span class="badge badge-danger">Rejected</span>
                                            @elseif ($workshop->approved_status == 3)
                                                <span class="badge badge-warning">Correction</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{route('apply-workshop.destroy', $workshop->id)}}" method="POST">
                                                @method('delete')
                                                @csrf
                                                @if ($workshop->approved_status == 0 || $workshop->approved_status == 3)
                                                    <a href="{{route('apply-workshop.edit', $workshop->id)}}" class="btn btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                @endif
                                                <button class="btn btn-info viewData" type="button" data-id="{{$workshop->id}}" data-toggle="modal" data-target="#openModal"><i class="nav-icon i-Eye"></i></button>
                                                @if ($workshop->approved_status == 0 || $workshop->approved_status == 3)
                                                    <button title="Delete Data" class="btn btn-danger delete" type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                                @endif
                                                <a href="{{route('apply-workshop.trainers', $workshop->slug)}}" class="btn btn-sm btn-info mt-1">Trainers</a>
                                                @if ($workshop->discussions->isNotEmpty())
                                                    <a href="{{route('workshop-apply.viewDiscussion', $workshop->slug)}}" class="btn btn-sm btn-info mt-1">View Discussions</a>
                                                @endif
                                                <a href="{{route('workshop.exportAttendees', $workshop->id)}}" class="btn btn-sm btn-success mt-1">Export Attendees</a>
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

        $(".makeDecision").click(function (e) {
            e.preventDefault();
            var url = '{{route('decideWorkshopRequest')}}';
            var _token = '{{csrf_token()}}';
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#modalContent').html(response);
            });
        });

        $(document).on("change", "#approved_status", function (e) {
            e.preventDefault();
            if ($(this).val() == 1) {
                $("#remarksDiv").attr('hidden', true);
            } else if ($(this).val() == 2) {
                $("#remarksDiv").attr('hidden', false);
            }
        });

        $(".viewData").click(function (e) {
            e.preventDefault();
            var url = '{{route('workshop.viewData')}}';
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
