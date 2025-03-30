@extends('layouts.dash')

@section('title')
    Poll
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Poll</h4>
                        <div class="ml-auto">
                            {{-- <a href="{{ route('scientific-session.exportExcel') }}" class="btn btn-info">Export</a> --}}
                            <a href="{{ route('poll.create', $id) }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Question</th>
                                    <th scope="col" style="width: 12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($polls as $poll)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $poll->question_text }}
                                        </td>

                                        <td>
                                            <form action="{{ route('poll.destroy', $poll->id) }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <a href="{{ route('poll.edit', $poll->id) }}" class="btn btn-sm btn-success"
                                                    title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>

                                                <button title="Delete Data" class="btn btn-sm btn-danger delete"
                                                    type="submit"><i class="nav-icon i-Close-Window"></i></button>
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
