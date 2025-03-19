<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Decide Presentation Request <span class="text-danger">(Topic: {{$submission->topic}})</span></h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <form id="decisionForm">
        @csrf
        <div class="row">
            <input type="hidden" id="submissionId" name="id" value="{{$submission->id}}">
            <div class="col-md-6 form-group mb-3" id="decisionDiv">
                <label for="request_status">Decide Request <code>*</code></label>
                <select name="request_status" id="request_status" class="form-control @error('request_status') is-invalid @enderror">
                    <option value="" hidden>-- Select Status --</option>
                    <option value="1" @selected(old('request_status') == 1)>Accept</option>
                    <option value="2" @selected(old('request_status') == 2)>Correction</option>
                    <option value="3" @selected(old('request_status') == 3)>Reject</option>
                </select>
                <p class="text-danger request_status"></p>
            </div>
            <div class="col-md-3 form-group mb-3 ifAcceptContents" hidden>
                <label for="day">Day <code>*</code></label>
                <select name="day" id="day" class="form-control @error('day') is-invalid @enderror">
                    <option value="" hidden>-- Select Day --</option>
                    @foreach ($dates as $date)
                        <option value="{{$date}}" @selected(old('day') == $date)>Day {{$loop->iteration}}</option>
                    @endforeach
                </select>
                <p class="text-danger day"></p>
            </div>
            <div class="col-md-3 form-group mb-3 ifAcceptContents" hidden>
                <label for="time">Time <code>*</code></label>
                <input type="text" class="form-control @error('time') is-invalid @enderror timepicker" name="time" id="time" value="{{old('time')}}" placeholder="Select schedule time" />
                <p class="text-danger time"></p>
            </div>
            <div class="col-md-3 form-group mb-3 ifAcceptContents" hidden>
                <label for="duration">Duration <code>*</code></label>
                <input type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" id="duration" value="{{old('duration')}}" placeholder="Enter duration" />
                <p class="text-danger duration"></p>
            </div>
            <div class="col-md-3 form-group mb-3 ifAcceptContents" hidden>
                <label for="category_id">Category <code>*</code></label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                    <option value="" hidden>-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" @selected(old('category_id') == $category->id)>{{$category->category_name}}</option>
                    @endforeach
                </select>
                <p class="text-danger category_id"></p>
            </div>
            <input type="hidden" name="type" value="{{$submission->presentation_type == 1 ? 2 : 1}}">
            <div class="col-md-3 form-group mb-3 ifAcceptContents" hidden>
                <label for="hall_id">Hall <code>*</code></label>
                <select name="hall_id" id="hall_id" class="form-control @error('hall_id') is-invalid @enderror">
                    <option value="" hidden>-- Select Hall --</option>
                    @foreach ($halls as $hall)
                        <option value="{{$hall->id}}" @selected(old('hall_id') == $hall->id)>{{$hall->hall_name}}</option>
                    @endforeach
                </select>
                <p class="text-danger hall_id"></p>
            </div>
            <div class="col-md-3 form-group mb-3 ifAcceptContents" hidden>
                <label for="chairperson" id="chairpersonLabel">Chairperson </label>
                <select name="chairperson[]" id="chairperson" class="form-control @error('chairperson') is-invalid @enderror select2" multiple>
                    @foreach ($users as $user)
                        @php
                            $usersId = [];
                            $isSelected2 = false;
                        @endphp
                        @if (old())
                            @php
                                $usersId = old('chairperson');
                            @endphp
                        @endif
                        @if (!empty($usersId))
                            @foreach ($usersId as $userId)
                                @if ($userId == $user->id)
                                    @php
                                        $isSelected2 = true;
                                        break;
                                    @endphp
                                @endif
                            @endforeach
                        @endif
                        <option value="{{$user->id}}" {{$isSelected2 ? 'selected' : ''}}>{{$user->fullName($user)}}</option>
                    @endforeach
                </select>
                <p class="text-danger chairperson"></p>
            </div>
            <div class="col-md-3 form-group mb-3 ifAcceptContents" hidden>
                <label for="co_chairperson">Co-Ordinator </label>
                <select name="co_chairperson[]" id="co_chairperson" class="form-control @error('co_chairperson') is-invalid @enderror select2" multiple>
                    @foreach ($users as $user2)
                        @php
                            $usersId2 = [];
                            $isSelected3 = false;
                        @endphp
                        @if (old())
                            @php
                                $usersId2 = old('co_chairperson');
                            @endphp
                        @endif
                        @if (!empty($usersId2))
                            @foreach ($usersId2 as $userId2)
                                @if ($userId2 == $user2->id)
                                    @php
                                        $isSelected3 = true;
                                        break;
                                    @endphp
                                @endif
                            @endforeach
                        @endif
                        <option value="{{$user2->id}}" {{$isSelected3 ? 'selected' : ''}}>{{$user2->fullName($user2)}}</option>
                    @endforeach
                </select>
                <p class="text-danger co_chairperson"></p>
            </div>
            <div class="col-md-6 form-group mb-3" id="attachmentDiv" hidden>
                <label for="attachment">Attachment <code>(Only: PDF)</code></label>
                <input type="file" class="form-control @error('attachment') is-invalid @enderror" name="attachment" id="image" value="{{isset($submission) ? $submission->attachment : old('attachment')}}" />
                <p class="text-danger attachment"></p>
                <div class="row" id="imgPreview"></div>
            </div>
            @if ($submission->presentation_type == 2 || $submission->presentation_type == 3)
                <div class="col-md-12 form-group mb-3" id="abstractContent" hidden>
                    <label for="abstract_content">Abstract Content <code>* <span>(NOTE: Total number of Abstract Words limitation is {{!empty(@$setting->abstract_word_limit) ? $setting->abstract_word_limit : 'infinity'}})</span></code></label>
                    <textarea class="form-control" name="abstract_content" id="description2" cols="30" rows="5">{{ !empty(old('abstract_content')) ? old('abstract_content') : $submission->abstract_content}}</textarea>
                    @error('abstract_content')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            @endif
            <div class="col-md-12 form-group mb-3" id="remarksDiv" hidden>
                <label for="remarks">Remarks <code>*</code></label>
                <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="5">{{isset($submission) ? $submission->remarks : old('remarks')}}</textarea>
                <p class="text-danger remarks"></p>
            </div>
            <div class="col-md-12">
                <button type="submit" id="decideRequest" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
</div>

<script>
    $(".timepicker").timepicker({
        step: 15,
        minTime: '06:00am',
    });

    $(".select2").select2({
        dropdownParent: $("#openModal")
    });

    var checkPresentationType = '{{$submission->presentation_type}}';

    if (checkPresentationType == 2 || checkPresentationType == 3) {
        CKEDITOR.replace('description2', {
            filebrowserUploadUrl: '{{ route('ckeditor.fileUpload', ['_token' => csrf_token()]) }}',
            filebrowserUploadMethod: "form",
            extraPlugins: 'wordcount',
            wordcount: {
                showWordCount: true,
                maxWordCount: {{@$setting->abstract_word_limit ? @$setting->abstract_word_limit : 'Infinity'}},
            }
        });
    }

    $(document).on("change", "#request_status", function (e) {
        e.preventDefault();
        if ($(this).val() === '2') {
            $(".ifAcceptContents").attr('hidden', true);
            $("#attachmentDiv").attr('hidden', false);
            $("#remarksDiv").attr('hidden', false);
            $("#abstractContent").attr('hidden', false);
            if (checkPresentationType == 2 || checkPresentationType == 3) {
                $('#openModal .modal-dialog').addClass('custom-modal-width');
            }
            $('#decisionDiv').removeClass('col-md-3');
            $('#decisionDiv').addClass('col-md-6');
        } else if ($(this).val() === '3') {
            $(".ifAcceptContents").attr('hidden', true);
            $("#attachmentDiv").attr('hidden', true);
            $("#remarksDiv").attr('hidden', false);
            $("#abstractContent").attr('hidden', true);
            $('#openModal .modal-dialog').removeClass('custom-modal-width');
            $('#decisionDiv').removeClass('col-md-3');
            $('#decisionDiv').addClass('col-md-6');
        } else if ($(this).val() === '1') {
            $(".ifAcceptContents").attr('hidden', false);
            $("#attachmentDiv").attr('hidden', true);
            $("#remarksDiv").attr('hidden', true);
            $("#abstractContent").attr('hidden', true);
            $('#openModal .modal-dialog').addClass('custom-modal-width');
            $('#decisionDiv').removeClass('col-md-6');
            $('#decisionDiv').addClass('col-md-3');
        }
    });

    $("#decideRequest").on('click', function (e) {
        e.preventDefault();
        var data = new FormData($('#decisionForm')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{route('submission.decideRequest')}}',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#decideRequest').attr('disabled', true);
                $('#decideRequest').append('<span class="spinner spinner-danger ml-2" style="height: 17px; width: 17px;"></span>');
            },
            success: function (response) {
                console.log('hello');
                $(".modal").modal("hide");
                toastr.success(response.message);
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            },
            error: function (response) {
                var errors =  response.responseJSON.errors;
                if (response.responseJSON.errors == undefined) {
                    toastr.error('Time Slot Already Consumed For This Hall.');
                } else {
                    $.each(errors, function (key, val) {
                        $('.'+key).html('');
                        $('.'+key).append(val);
                        $('#'+key).addClass('border-danger');
                        $('#'+key).on('input', function(){
                            $('.'+key).html('');
                            $('#'+key).removeClass('border-danger');
                        });
                    });
                }
                $('#decideRequest').attr('disabled', false);
                $('#decideRequest').text('Update');
            }
        });
    });
</script>
