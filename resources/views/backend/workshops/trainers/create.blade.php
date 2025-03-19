@extends('layouts.dash')

@section('title')
    {{isset($trainer) ? 'Edit' : 'Add'}} Trainer
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($trainer) ? 'Edit' : 'Add'}} Trainer for {{$workshop->title}}</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($trainer) ? route('workshop-trainer.update', $trainer->id) : route('workshop-trainer.store')}}" method="POST" enctype="multipart/form-data" id="trainerForm">
                        @csrf
                        @isset($trainer)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <input type="hidden" name="workshop_id" value="{{$workshop->id}}">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">Trainer Name <code>*</code></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{isset($trainer) ? $trainer->name : old('name')}}" placeholder="Enter trainer name" />
                                @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="affiliation">Affiliation <code>*</code></label>
                                <input type="text" class="form-control" name="affiliation" id="affiliation" value="{{isset($trainer) ? $trainer->affiliation : ''}}" placeholder="Enter trainer affiliation">
                                @error('affiliation')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="image">Image <code>* (Only JPG/PNG, less than 500 KB)</code></label>
                                <input type="file" name="image" class="form-control" id="image3"/>
                                @error('image')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview3">
                                    @if (isset($trainer))
                                        <div class="col-3 mt-2">
                                            <a href="{{asset('storage/workshop/trainers/image/'.$trainer->image)}}" target="_blank"><img src="{{asset('storage/workshop/trainers/image/'.$trainer->image)}}" class="img-fluid" alt="image"></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="cv">CV <code>(Only PDF, less than 250 KB)</code></label>
                                <input type="file" class="form-control @error('cv') is-invalid @enderror" name="cv" id="image" />
                                @error('cv')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                    @if (isset($trainer) && !empty($trainer->cv))
                                        <div class="col-3 mt-2">
                                            <a href="{{asset('storage/workshop/trainers/cv/'.$trainer->cv)}}" target="_blank"><img src="{{asset('default-images/pdf.png')}}" height="60" width="50" alt="cv"></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" id="submitButton">{{isset($trainer) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('workshop-trainer.index', $workshop->slug)}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).ready(function () {
                $("#submitButton").click(function(e) {
                    e.preventDefault();
                    $(this).attr('disabled', true);
                    $("#trainerForm").submit();
                });
            });
        });
    </script>
@endsection
