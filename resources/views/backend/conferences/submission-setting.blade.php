@extends('layouts.dash')

@section('title')
    Submission Setting
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Submission Setting</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{route('conference.submissionSettingSubmit')}}" method="POST" enctype="multipart/form-data" id="submissionSettingForm">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="conference_id" value="{{$conference->id}}">
                            <input type="hidden" name="id" value="{{!empty($conference->submissionSetting) ? $conference->submissionSetting->id : ''}}">
                            <div class="col-md-4 form-group mb-3">
                                <label for="deadline">Submission Deadline</label>
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror deadline" name="deadline" id="deadline" value="{{!empty($conference->submissionSetting) ? $conference->submissionSetting->deadline : ''}}" />
                                @error('deadline')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="abstract_word_limit">Abstract Word Limit <code>(In Number)</code></label>
                                <input type="number" class="form-control @error('abstract_word_limit') is-invalid @enderror numericValue abstract_word_limit" name="abstract_word_limit" id="abstract_word_limit" value="{{!empty($conference->submissionSetting) ? $conference->submissionSetting->abstract_word_limit : ''}}" />
                                @error('abstract_word_limit')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="keyword_word_limit">Keyword Word Limit <code>(In Number)</code></label>
                                <input type="number" class="form-control @error('keyword_word_limit') is-invalid @enderror numericValue keyword_word_limit" name="keyword_word_limit" id="keyword_word_limit" value="{{!empty($conference->submissionSetting) ? $conference->submissionSetting->keyword_word_limit : ''}}" />
                                @error('keyword_word_limit')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="authors_limit">Authors Limit <code>(In Number)</code></label>
                                <input type="number" class="form-control @error('authors_limit') is-invalid @enderror numericValue authors_limit" name="authors_limit" id="authors_limit" value="{{!empty($conference->submissionSetting) ? $conference->submissionSetting->authors_limit : ''}}" />
                                @error('authors_limit')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="abstract_guidelines">Abstract Guidelines </label>
                                <textarea name="abstract_guidelines" class="form-control @error('abstract_guidelines') is-invalid @enderror" id="description" cols="30" rows="10">{{!empty($conference->submissionSetting) ? $conference->submissionSetting->abstract_guidelines : ''}}</textarea>
                                @error('abstract_guidelines')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="poster_guidelines">Poster Guidelines </label>
                                <textarea name="poster_guidelines" class="form-control @error('poster_guidelines') is-invalid @enderror" id="description2" cols="30" rows="10">{{!empty($conference->submissionSetting) ? $conference->submissionSetting->poster_guidelines : ''}}</textarea>
                                @error('poster_guidelines')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" id="submitData">{{empty($conference->submissionSetting) ? 'Save' : 'Update'}}</button>
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
            $(".numericValue").on("keydown", function(event) {
                // Allow backspace, delete, tab, escape, and enter keys
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
                    // Allow Ctrl+A
                    (event.keyCode == 65 && event.ctrlKey === true) ||
                    // Allow home, end, left, right
                    (event.keyCode >= 35 && event.keyCode <= 39) ||
                    // Allow numbers from the main keyboard (0-9) and the numpad (96-105)
                    (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)) {
                return;
                } else {
                    event.preventDefault();
                }
            });

            $(".timepicker").timepicker({
                step: 15,
                minTime: '06:00am',
            });

            $("#submitData").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#submissionSettingForm").submit();
            });

            CKEDITOR.replace('description2', {
                filebrowserUploadUrl: '{{ route('ckeditor.fileUpload', ['_token' => csrf_token()]) }}',
                filebrowserUploadMethod: "form"
            });
        });
    </script>
@endsection
