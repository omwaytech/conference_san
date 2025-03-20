@extends('layouts.dash')

@section('title')
    {{ isset($scientificSessionCategory) ? 'Edit' : 'Add' }} Scientific Session Category
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{ isset($scientificSessionCategory) ? 'Edit' : 'Add' }} Scientific Session Category</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form
                        action="{{ isset($scientificSessionCategory) ? route('scientific-session-category.update', $scientificSessionCategory->id) : route('scientific-session-category.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($scientificSessionCategory)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-8 form-group mb-3">
                                <label for="category_name">Category Name <code>*</code></label>
                                <input type="text" class="form-control @error('category_name') is-invalid @enderror"
                                    name="category_name"
                                    value="{{ isset($scientificSessionCategory) ? $scientificSessionCategory->category_name : old('category_name') }}"
                                    placeholder="Enter category name" />
                                @error('category_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="sub_heading">Sub Heading <code></code></label>
                                <input type="text" class="form-control @error('sub_heading') is-invalid @enderror"
                                    name="sub_heading" id="sub_heading"
                                    value="{{ isset($scientificSessionCategory) ? $scientificSessionCategory->sub_heading : old('sub_heading') }}"
                                    placeholder="Enter sub heading" />
                                @error('sub_heading')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="duration">Duration <code>*</code></label>
                                <input type="text" class="form-control @error('duration') is-invalid @enderror"
                                    name="duration" id="duration"
                                    value="{{ isset($scientificSessionCategory) ? $scientificSessionCategory->duration : old('duration') }}"
                                    placeholder="Enter duration" />
                                @error('duration')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="chairperson">Chairperson <code></code></label>
                                <input type="text" class="form-control @error('chairperson') is-invalid @enderror"
                                    name="chairperson" id="chairperson"
                                    value="{{ isset($scientificSessionCategory) ? $scientificSessionCategory->chairperson : old('chairperson') }}"
                                    placeholder="Enter chairperson" />
                                @error('chairperson')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="co_chairperson">Co-Chairperson <code></code></label>
                                <input type="text" class="form-control @error('co_chairperson') is-invalid @enderror"
                                    name="co_chairperson" id="co_chairperson"
                                    value="{{ isset($scientificSessionCategory) ? $scientificSessionCategory->co_chairperson : old('co_chairperson') }}"
                                    placeholder="Enter co-chairperson" />
                                @error('co_chairperson')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="moderator">Moderator <code></code></label>
                                <input type="text" class="form-control @error('moderator') is-invalid @enderror"
                                    name="moderator" id="moderator"
                                    value="{{ isset($scientificSessionCategory) ? $scientificSessionCategory->moderator : old('moderator') }}"
                                    placeholder="Enter moderator" />
                                @error('moderator')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit"
                                    class="btn btn-primary">{{ isset($scientificSessionCategory) ? 'Update' : 'Submit' }}</button>
                                <a href="{{ route('scientific-session-category.index') }}"
                                    class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
