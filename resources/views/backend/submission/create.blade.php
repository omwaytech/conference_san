@extends('layouts.dash')

@section('title')
    Presentation Submission
@endsection

@section('styles')
    <style>
        .tags-input {
            display: inline-block;
            position: relative;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
            box-shadow: 2px 2px 5px #00000033;
            width: 50%;
        }

        .tags-input ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tags-input li {
            display: inline-block;
            background-color: #f2f2f2;
            color: #333;
            border-radius: 20px;
            padding: 5px 10px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .tags-input input[type="text"] {
            border: none;
            outline: none;
            padding: 5px;
            font-size: 14px;
        }

        .tags-input input[type="text"]:focus {
            outline: none;
        }

        .tags-input .delete-button {
            background-color: transparent;
            border: none;
            color: #999;
            cursor: pointer;
            margin-left: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Presentation Submission</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form
                        action="{{ isset($submission) ? route('submission.update', $submission->id) : route('submission.store') }}"
                        method="POST" enctype="multipart/form-data" id="submissionForm">
                        @csrf
                        @isset($submission)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="has_presented_before">Has Presented Before? <code>*</code></label>
                                <select name="has_presented_before" class="form-control"
                                    id="has_presented_before">
                                    <option value="" hidden>-- Select Yes/No --</option>
                                    <option value="1"
                                        @if (isset($submission)) {{ $submission->has_presented_before == '1' ? 'selected' : '' }} @else @selected(old('has_presented_before') == '1') @endif>
                                        Yes</option>
                                    <option value="0"
                                        @if (isset($submission)) {{ $submission->has_presented_before == '0' ? 'selected' : '' }} @else @selected(old('has_presented_before') == '0') @endif>
                                        No</option>
                                </select>
                                @error('has_presented_before')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3 placeOfPresentationDiv">
                                <label for="presentation_place">Place of Presentation
                                    <code>*</code></label>
                                <input type="text"
                                    class="form-control @error('presentation_place') is-invalid @enderror"
                                    name="presentation_place" id="presentation_place"
                                    value="{{ isset($submission) ? $submission->presentation_place : old('presentation_place') }}"
                                    placeholder="Enter place of presentation" />
                                @error('presentation_place')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="topic">Topic <code>*</code></label>
                                <input type="text" class="form-control @error('topic') is-invalid @enderror" name="topic" id="topic" value="{{!empty(old('topic')) ? old('topic') : @$submission->topic}}" placeholder="Enter topic" />
                                @error('topic')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="presentation_type">Presentation Type <code>*</code></label>
                                <select name="presentation_type" class="form-control @error('presentation_type') is-invalid @enderror" id="presentationType">
                                    <option value="" hidden>-- Select Presentation Type -- </option>
                                    @if (!empty($submission->presentation_type))
                                        <option value="1" {{ $submission->presentation_type == 1 ? 'selected' : 'hidden' }}>Poster</option>
                                        <option value="2" {{ $submission->presentation_type == 2 ? 'selected' : 'hidden' }}>Oral(Abstract)</option>
                                        {{-- <option value="3" {{ $submission->presentation_type == 3 ? 'selected' : 'hidden' }}>Full Text</option> --}}
                                    @else
                                        <option value="1" @selected(old('presentation_type') == '1')>Poster</option>
                                        <option value="2" @selected(old('presentation_type') == '2')>Oral(Abstract)</option>
                                        {{-- <option value="3" @selected(old('presentation_type') == '3')>Full Text</option> --}}
                                    @endif
                                </select>
                                @error('presentation_type')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3 tags-input" hidden id="keywordsSection">
                            <label for="keywords">Keywords <code>(NOTE: Total number of Keywords limitation is {{@$setting->keyword_word_limit ? @$setting->keyword_word_limit : 'infinity'}}) <span class="text-info">(Press enter after typing complete word/words to represent it as a keyword.)</span></code></label>
                                <ul id="tags">
                                    @if (!empty(old('keywords')) || !empty($submission->keywords))
                                        @php
                                            if (!empty(old('keywords'))) {
                                                $explodeKeywords = explode(',', old('keywords'));
                                            } else {
                                                $explodeKeywords = explode(',', $submission->keywords);
                                            }
                                        @endphp
                                        @foreach ($explodeKeywords as $item)
                                            <li>{{$item}}<button class="delete-button">X</button></li>
                                        @endforeach
                                    @endif
                                </ul>
                                <input type="text" class="form-control @error('keywords') is-invalid @enderror"id="input-tag" placeholder="Enter keywords" />
                                <input type="hidden" name="keywords" id="hiddenKeywords" value="{{!empty(old('keywords')) ? old('keywords') : @$submission->keywords}}" />
                                @error('keywords')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- <div class="col-md-12 form-group mb-3">
                                <label for="cover_letter">Cover Letter <code>*</code></label>
                                <textarea class="form-control" name="cover_letter" id="description" cols="30" rows="5">{{ !empty(old('cover_letter')) ? old('cover_letter') : @$submission->cover_letter}}</textarea>
                                @error('cover_letter')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div> --}}
                            <div class="col-md-12 form-group mb-3">
                                <label for="abstract_content">Abstract Content <code>* <span>(NOTE: Total number of Abstract Words limitation is {{@$setting->abstract_word_limit ? @$setting->abstract_word_limit : 'infinity'}})</span></code></label>
                                <textarea class="form-control" name="abstract_content" id="description2" cols="30" rows="5">{{ !empty(old('abstract_content')) ? old('abstract_content') : @$submission->abstract_content}}</textarea>
                                @error('abstract_content')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- <div class="col-md-6 form-group mb-3" id="presentationFile" hidden>
                                <label for="presentation_file">Presentation File <code>* <span id="presentationFileMessage">(Supported Format: PDF/Power Point,
                                        Max: 1 MB)</span></code></label>
                                <input type="file" class="form-control @error('presentation_file') is-invalid @enderror"
                                    name="presentation_file" id="image" />
                                @error('presentation_file')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                    @if (isset($submission) && !empty($submission->presentation_file))
                                        <div class="col-3 mt-2">
                                            @php
                                                $extension = explode('.', $submission->presentation_file);
                                            @endphp
                                            @if ($extension[1] == 'pdf')
                                                <a href="{{ asset('storage/submission/presentation-file/' . $submission->presentation_file) }}"
                                                    target="_blank"><img src="{{ asset('default-images/pdf.png') }}"
                                                        height="70" alt="presentation file"></a>
                                            @elseif ($extension[1] == 'doc' || $extension[1] == 'docx')
                                                <a href="{{ asset('storage/submission/presentation-file/' . $submission->presentation_file) }}"
                                                    target="_blank"><img src="{{ asset('default-images/word.png') }}"
                                                        height="70" alt="presentation file"></a>
                                            @else
                                                <a href="{{ asset('storage/submission/presentation-file/' . $submission->presentation_file) }}"
                                                    target="_blank"><img src="{{ asset('default-images/ppt.png') }}"
                                                        height="70" alt="presentation file"></a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-md-12">
                            <button type="submit"
                                class="btn btn-primary" id="submitButton">{{ isset($submission)  ? 'Update' : 'Submit' }}</button>
                            <a href="{{ route('submission.index') }}" class="btn btn-danger">Cancel</a>
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

        $("#presentationType").change(function (e) {
            e.preventDefault();
            var type = $(this).val();
            if (type == 1) {
                $("#presentationFile").attr('hidden', false);
                $("#presentationFileMessage").text('(Supported Format: PDF/Power Point, Max: 1 MB)');
                $("#abstractContent").attr('hidden', true);
                $("#keywordsSection").attr('hidden', true);
            } else if (type == 2) {
                $("#presentationFile").attr('hidden', true);
                $("#abstractContent").attr('hidden', false);
                $("#keywordsSection").attr('hidden', false);
            } else if(type == 3) {
                $("#presentationFile").attr('hidden', false);
                $("#presentationFileMessage").text('(Supported Format: MS Word, Max: 5 MB)');
                $("#abstractContent").attr('hidden', false);
                $("#keywordsSection").attr('hidden', false);
            }
        });
        $("#presentationType").trigger("change");

        //============================== keyword tags start ==============================
        // Add an event listener for keydown on the input element
        const keywordLimit = {{@$setting->keyword_word_limit ? @$setting->keyword_word_limit : 'Infinity'}};
        $('#input-tag').on('keydown', function (event) {
            // Check if the key pressed is 'Enter'
            if (event.key === 'Enter') {
                // Prevent the default action of the keypress event (submitting the form)
                event.preventDefault();

                // Get the trimmed value of the input element
                const tagContent = $(this).val().trim();

                // If the trimmed value is not an empty string
                if (tagContent !== '') {
                    // Check if the keyword limit is reached
                    const currentKeywordsCount = $('#tags li').length;
                    if (currentKeywordsCount >= keywordLimit) {
                        // Display an error message indicating the keyword limit is reached
                        return; // Stop further execution
                    }

                    // Append the tag content to the tags list with 'X' button
                    $('#tags').append('<li>' + tagContent + '<button class="delete-button">X</button></li>');

                    // Clear the input element's value
                    $(this).val('');

                    // Update the hidden input field with keywords
                    updateHiddenInput();
                }
            }
        });

        // Function to update hidden input field with keywords
        function updateHiddenInput() {
            const keywordsArray = [];
            $('#tags li').each(function () {
                const tagText = $(this).text().trim().replace('X', '').trim(); // Remove 'X' from displayed text
                keywordsArray.push(tagText);
            });

            const keywordsString = keywordsArray.join(', ');
            $('#hiddenKeywords').val(keywordsString);
        }

        // Add an event listener for click on the delete button
        $('#tags').on('click', '.delete-button', function (event) {
            // Prevent the click event from propagating to the list item
            event.stopPropagation();

            // Remove the parent list item (the tag)
            $(this).parent().remove();

            // Update the hidden input field after tag deletion
            updateHiddenInput();
        });
        //============================== keyword tags end ==============================

        // $('#description2').on('input', function() {
        //     var text = $(this).val();
        //     var words = text.trim().split(/\s+/);
        //     var wordCount = words.length > 0 ? words.length : 0;
        //     $('#wordCount').text(wordCount);
        // });

        CKEDITOR.replace('description2', {
            filebrowserUploadUrl: '{{ route('ckeditor.fileUpload', ['_token' => csrf_token()]) }}',
            filebrowserUploadMethod: "form",
            extraPlugins: 'wordcount',
            wordcount: {
                showWordCount: true,
                maxWordCount: {{@$setting->abstract_word_limit ? @$setting->abstract_word_limit : 'Infinity'}},
            }
        });

        $("#submitButton").click(function (e) {
            e.preventDefault();
            $(this).attr('disabled', true);
            $("#submissionForm").submit();
        });

        // $('#description2').trigger('input');

        $("#has_presented_before").change(function(e) {
            e.preventDefault();
            if ($(this).val() == 1) {
                $(".placeOfPresentationDiv").attr('hidden', false);
            } else {
                $(".placeOfPresentationDiv").attr('hidden', true);
            }
        });
        $("#has_presented_before").trigger("change");
    });

</script>
@endsection
