@extends('layouts.dash')

@section('title')
    {{isset($download) ? 'Edit' : 'Add'}} Download
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($download) ? 'Edit' : 'Add'}} Download</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($download) ? route('download.update', $download->id) : route('download.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($download)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="title">Title <code>*</code></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{isset($download) ? $download->title : old('title')}}" />
                                @error('title')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="file">File <code>* (Only: JPG/PDF/MS-Word & Max File Size: 8MB)</code></label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror" name="file" id="image" />
                                @error('file')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                    @if (isset($download))
                                        <div class="col-3 mt-2">
                                            @php
                                                $fileName = explode('.', $download->file);
                                            @endphp
                                            @if ($fileName[1] == 'pdf')
                                                <img src="{{asset('default-images/pdf.png')}}" height="50" alt="pdf">
                                            @elseif ($fileName[1] == 'doc' || $fileName[1] == 'docx')
                                                <img src="{{asset('default-images/word.png')}}" height="50" alt="word file">
                                            @else
                                                <img src="{{asset('storage/downloads/'.$download->file)}}" height="50" alt="image">
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($download) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('download.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
