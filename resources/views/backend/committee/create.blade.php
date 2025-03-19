@extends('layouts.dash')

@section('title')
    {{isset($committee) ? 'Edit' : 'Add'}} Committee
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($committee) ? 'Edit' : 'Add'}} Committee</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($committee) ? route('committee.update', $committee->id) : route('committee.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($committee)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="committee_name">Committee Name <code>*</code></label>
                                <input type="text" class="form-control @error('committee_name') is-invalid @enderror" name="committee_name" id="committee_name" value="{{isset($committee) ? $committee->committee_name : old('committee_name')}}" placeholder="Enter committee name" />
                                @error('committee_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="focal_person">Focal Person Name <code>*</code></label>
                                <input type="text" class="form-control @error('focal_person') is-invalid @enderror" name="focal_person" id="focal_person" value="{{isset($committee) ? $committee->focal_person : old('focal_person')}}" placeholder="Enter focal person name" />
                                @error('focal_person')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="email">Email <code>*</code></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{isset($committee) ? $committee->email : old('email')}}" placeholder="Enter email" />
                                @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="phone">Phone <code>*</code></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{isset($committee) ? $committee->phone : old('phone')}}" placeholder="Enter phone" />
                                @error('phone')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="description">Description </label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5" placeholder="Enter description">{{isset($committee) ? $committee->description : old('description')}}</textarea>
                                @error('description')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($committee) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('committee.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
