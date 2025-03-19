@extends('layouts.dash')

@section('title')
    {{isset($signature) ? 'Edit' : 'Add'}} Certificate Signature
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($signature) ? 'Edit' : 'Add'}} Certificate Signature</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($signature) ? route('signature.update', $signature->id) : route('signature.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($signature)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">Signature Holder Name <code>*</code></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{isset($signature) ? $signature->name : old('name')}}" placeholder="Enter signature holder's name" />
                                @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="designation">Designation <code>*</code></label>
                                <input type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" id="designation" value="{{isset($signature) ? $signature->designation : old('designation')}}" placeholder="Enter designation" />
                                @error('designation')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="signature">Signature <code>*</code></label>
                                <input type="file" class="form-control @error('signature') is-invalid @enderror" name="signature" id="image" />
                                @error('signature')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                    @if (isset($signature))
                                        <div class="col-3 mt-2">
                                            <img src="{{asset('storage/certificates/signatures/'.$signature->signature)}}" alt="image" class="img-fluid">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($signature) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('signature.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
