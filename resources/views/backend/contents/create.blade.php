@extends('layouts.dash')

@section('title')
    {{isset($content) ? 'Edit' : 'Add'}} Content
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($content) ? 'Edit' : 'Add'}} Content <code>(NOTE: Either File or Description is mandatory.)</code></h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($content) ? route('content.update', $content->id) : route('content.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($content)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="title">Title <code>*</code></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{isset($content) ? $content->title : old('title')}}" />
                                @error('title')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="file">File <code>(Only: PDF & Max File Size: 5MB)</code></label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" id="image" />
                                @error('file')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                    @if (isset($content) && !empty($content->file))
                                        <div class="col-3 mt-2">
                                            @php
                                                $fileName = explode('.', $content->file);
                                            @endphp
                                            @if ($fileName[1] == 'pdf')
                                                <img src="{{asset('default-images/pdf.png')}}" height="50" alt="pdf">
                                            @elseif ($fileName[1] == 'doc' || $fileName[1] == 'docx')
                                                <img src="{{asset('default-images/word.png')}}" height="50" alt="word file">
                                            @else
                                                <img src="{{asset('storage/contents/'.$content->file)}}" height="50" alt="image">
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="description">Description </label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="10">{{isset($content) ? $content->description : old('description')}}</textarea>
                                @error('description')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($content) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('content.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
