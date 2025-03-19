@extends('layouts.dash')

@section('title')
    {{isset($background) ? 'Edit' : 'Add'}} Certificate Background Theme
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($background) ? 'Edit' : 'Add'}} Certificate Background Theme</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($background) ? route('background.update', $background->id) : route('background.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($background)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="background_theme">Background Theme <code>*</code></label>
                                <input type="file" class="form-control @error('background_theme') is-invalid @enderror" name="background_theme" id="image" />
                                @error('background_theme')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                    @if (isset($background))
                                        <div class="col-3 mt-2">
                                            <img src="{{asset('storage/certificates/background-theme/'.$background->background_theme)}}" alt="image" class="img-fluid">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($background) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('background.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
