@extends('layouts.dash')

@section('title')
    Conferences
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Conferences</h4>
                        <div class="ml-auto">
                            <a href="{{ route('conference.create') }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Conference Theme</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">Venue Name</th>
                                    <th scope="col">Organizer Name</th>
                                    <th scope="col" style="width: 10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($conferences as $conference)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$conference->conference_theme}}</td>
                                        <td>{{$conference->start_date}}</td>
                                        <td>{{$conference->venue_name}}</td>
                                        <td>{{$conference->organizer_name}}</td>
                                        <td>
                                            <a href="{{route('conference.edit', $conference->id)}}" class="btn btn-sm btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                            <button class="btn btn-sm btn-info viewData" type="button" data-id="{{$conference->id}}" data-toggle="modal" data-target="#openModal"><i class="nav-icon i-Eye"></i></button>
                                            <a href="{{route('conference.openConferencePortal', $conference->slug)}}" class="btn btn-info btn-sm mt-1">Open Portal</a>
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
        $(document).on("click", ".viewData", function (e) {
            e.preventDefault();
            var url = '{{route('conference.show')}}';
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
