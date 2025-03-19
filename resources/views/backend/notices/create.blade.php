@extends('layouts.dash')

@section('title')
    {{isset($notice) ? 'Edit' : 'Add'}} News/Notice
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($notice) ? 'Edit' : 'Add'}} News/Notice</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($notice) ? route('notice.update', $notice->id) : route('notice.store')}}" method="POST" enctype="multipart/form-data" id="noticeForm">
                        @csrf
                        @isset($notice)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="title">Title <code>*</code></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{isset($notice) ? $notice->title : old('title')}}" placeholder="Enter notice title" />
                                @error('title')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="date">Date <code>*</code></label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date" value="{{isset($notice) ? $notice->date : old('date')}}" />
                                @error('date')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="image">Image/Logo <code>* (JPG/PNG, less than 500 KB)</code></label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" value="{{isset($notice) ? $notice->image : old('image')}}" />
                                @error('image')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                    @if (isset($notice))
                                        <div class="col-3 mt-2">
                                            <a href="{{asset('storage/notice/'.$notice->image)}}" target="_blank"><img src="{{asset('storage/notice/'.$notice->image)}}" class="img-fluid" alt="image"></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="description">Description <code>*</code></label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{isset($notice) ? $notice->description : old('description')}}</textarea>
                                @error('description')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" id="submitButton">{{isset($notice) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('notice.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#submitButton").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#noticeForm").submit();
            });
        });
    </script>
@endsection
