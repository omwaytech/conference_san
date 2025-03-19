@extends('layouts.dash')

@section('title')
    {{isset($scientificSessionCategory) ? 'Edit' : 'Add'}} Scientific Session Category
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($scientificSessionCategory) ? 'Edit' : 'Add'}} Scientific Session Category</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($scientificSessionCategory) ? route('scientific-session-category.update', $scientificSessionCategory->id) : route('scientific-session-category.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($scientificSessionCategory)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="category_name">Category Name <code>*</code></label>
                                <input type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{isset($scientificSessionCategory) ? $scientificSessionCategory->category_name : old('category_name')}}" placeholder="Enter category name" />
                                @error('category_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($scientificSessionCategory) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('scientific-session-category.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
