@extends('layouts.dash')

@section('title')
    Scientific Session
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Scientific Session</h4>
                        <div class="ml-auto">
                            <a href="{{ route('scientific-session.exportExcel') }}" class="btn btn-info">Export</a>
                            <a href="{{ route('scientific-session.create') }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Topic</th>
                                    <th scope="col">Hall</th>
                                    <th scope="col">Schedule Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col" style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sessions as $session)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ !empty($session->category->category_name) ? $session->category->category_name : '' }}
                                        </td>
                                        <td>
                                            {{ $session->topic }}

                                        </td>
                                        <td>
                                            @if (!empty($session->hall_id))
                                                {{ $session->hall->hall_name }}
                                                {{-- old code --}}
                                                {{-- @foreach (json_decode($session->hall_id) as $hallId)
                                                    @php
                                                        $hall = DB::table('halls')->whereId($hallId)->first();
                                                    @endphp
                                                    {{$hall->hall_name}}{{$loop->last ? '' : ', ' }}
                                                @endforeach --}}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($dates as $date)
                                                @if ($session->day == $date)
                                                    Day {{ $loop->iteration }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $session->time }}</td>
                                        <td>{{ $session->duration }}</td>
                                        <td>
                                            <form action="{{ route('scientific-session.destroy', $session->id) }}"
                                                method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{ route('scientific-session.edit', $session->id) }}"
                                                    class="btn btn-sm btn-success" title="Edit Data"><i
                                                        class="nav-icon i-Pen-2"></i></a>
                                                <button class="btn btn-sm btn-info viewData" type="button"
                                                    data-id="{{ $session->id }}" data-toggle="modal"
                                                    data-target="#openModal"><i class="nav-icon i-Eye"></i></button>
                                                @if (auth()->user()->id == 1)
                                                    <button title="Delete Data" class="btn btn-sm btn-danger delete"
                                                        type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                                @endif
                                                <a href="{{ route('poll.index', $session->id) }}"
                                                    class="btn btn-sm btn-warning" title="Edit Data">Poll</a>
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
            $(document).on("click", ".viewData", function(e) {
                e.preventDefault();
                var url = '{{ route('scientific-session.show') }}';
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
