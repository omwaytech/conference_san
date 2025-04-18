@extends('layouts.dash')

@section('title')
    Trainers
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Trainers of {{ $workshop->title }}</h4>
                        <div class="ml-auto">
                            <a href="{{ route('workshop.index') }}" class="btn btn-danger"> Go Back</a>
                            @if ($workshop->user_id == $authUser->id)
                                <a href="{{ route('workshop-trainer.create', $workshop->slug) }}" class="btn btn-primary">
                                    Add</a>
                            @endif
                            <a href="{{ route('workshop-trainer.generatePass', $workshop->id) }}"
                                class="btn btn-primary ml-2" target="_blank"><i class="nav-icon i-File"></i> Generate
                                Pass</a>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <form action="{{ route('workshop-trainer.dummyPass') }}" method="POST">
                            @csrf
                            <div class="row mb-4">
                                <input type="hidden" name="workshop_id" value="{{ $workshop->id }}">
                                <div class="col-md-6">
                                    <label for="registrant_type">Enter Number<code>*</code></label>
                                    <input class="form-control" type="number" name="number">
                                </div>
                                <div class="col-md-3 form-group mt-4">
                                    <button id="calculatePrice" class="btn btn-primary">Generate Dummy Data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Trainer Name</th>
                                    <th scope="col">Affiliation</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">CV</th>
                                    <th scope="col">Certificate</th>
                                    @if ($workshop->user_id == $authUser->id)
                                        <th scope="col">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainers as $trainer)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $trainer->name }}</td>
                                        <td>{{ $trainer->affiliation }}</td>
                                        <td><a href="{{ asset('storage/workshop/trainers/image/' . $trainer->image) }}"
                                                target="_blank"><img
                                                    src="{{ asset('storage/workshop/trainers/image/' . $trainer->image) }}"
                                                    height="30" width="25" alt="cv"></a></td>
                                        <td>
                                            @if (!empty($trainer->cv))
                                                <a href="{{ asset('storage/workshop/trainers/cv/' . $trainer->cv) }}"
                                                    target="_blank"><img src="{{ asset('default-images/pdf.png') }}"
                                                        height="30" width="25" alt="cv"></a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('workshop-trainer.generateCertificate', $trainer->id) }}">
                                                <button type="submit" class="btn btn-primary">Generate
                                                    Certificate</button>
                                            </a>
                                        </td>
                                        @if ($workshop->user_id == $authUser->id)
                                            <td>
                                                <form action="{{ route('workshop-trainer.destroy', $trainer->id) }}">
                                                    @csrf
                                                    <a href="{{ route('workshop-trainer.edit', [$workshop->slug, $trainer->id]) }}"
                                                        class="btn btn-success btn-sm" title="Edit Data"><i
                                                            class="nav-icon i-Pen-2"></i></a>
                                                    <button title="Delete Data" class="btn btn-danger btn-sm delete"
                                                        type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
