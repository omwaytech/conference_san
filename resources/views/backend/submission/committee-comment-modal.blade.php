<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Comment on Expert's Review.</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <form id="commentForm">
        @csrf
        <div class="row">
            <input type="hidden" id="discussionId" name="id" value="{{ $discussion->id }}">
            @if (!empty($discussion->submission->expert_id))
                <div class="col-md-3 form-group mb-3 ml-3">
                    <input type="checkbox" class="form-check-input" name="expert_visible" id="expert_visible" value="1" @if(old('expert_visible') == 1 || @$discussion->expert_visible == 1) checked @endif />
                    <label for="expert_visible" class="form-check-label">Show To Expert ? </label>
                    @error('expert_visible')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
            @endif
            <div class="col-md-4 form-group mb-3" {{$discussion->presenter_visible == 1 ? 'hidden' : ''}}>
                <input type="checkbox" class="form-check-input" name="presenter_visible" id="presenter_visible" value="1" @if(old('presenter_visible') == 1 || @$discussion->presenter_visible == 1) checked @endif />
                <label for="presenter_visible" class="form-check-label">Forward & Show To Presenter ? </label>
                @error('presenter_visible')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="col-md-12 form-group mb-3">
                <label for="committee_remarks">Committee Remarks <code>*</code></label>
                <textarea class="form-control" name="committee_remarks" id="committee_remarks" cols="30" rows="5">{{ isset($discussion) ? $discussion->committee_remarks : old('committee_remarks') }}</textarea>
                <p class="text-danger committee_remarks"></p>
            </div>
            <div class="col-md-12">
                <button type="submit" id="submitComment" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
</div>

<script>
    $("#submitComment").on('click', function (e) {
        e.preventDefault();
        var data = new FormData($('#commentForm')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{route('submission.submitComment')}}',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#submitComment').attr('disabled', true);
                $('#submitComment').append('<span class="spinner spinner-danger ml-2" style="height: 17px; width: 17px;"></span>');
            },
            success: function (response) {
                $(".modal").modal("hide");
                toastr.success(response.message);
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            },
            error: function (response) {
                var errors =  response.responseJSON.errors;
                $.each(errors, function (key, val) {
                    $('.'+key).html('');
                    $('.'+key).append(val);
                    $('#'+key).addClass('border-danger');
                    $('#'+key).on('input', function(){
                        $('.'+key).html('');
                        $('#'+key).removeClass('border-danger');
                        $('#submitComment').attr('disabled', false);
                        $('#submitComment').text('Update');
                    });
                });
            }
        });
    });
</script>
