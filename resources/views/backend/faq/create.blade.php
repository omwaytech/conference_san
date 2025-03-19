@extends('layouts.dash')

@section('title')
    {{isset($faq) ? 'Edit' : 'Add'}} FAQ
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($faq) ? 'Edit' : 'Add'}} FAQ</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($faq) ? route('faq.update', $faq->id) : route('faq.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($faq)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="question">Question <code>*</code></label>
                                <input type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{isset($faq) ? $faq->question : old('question')}}" placeholder="Enter question" />
                                @error('question')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="answer">Answer <code>*</code></label>
                                <textarea name="answer" class="form-control @error('answer') is-invalid @enderror" id="description" cols="30" rows="10">{{isset($faq) ? $faq->answer : old('answer')}}</textarea>
                                @error('answer')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($faq) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('faq.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
