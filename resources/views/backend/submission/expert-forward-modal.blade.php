<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Assign To Expert <span class="text-danger">(Topic: {{$submission->topic}})</span></h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <form id="dataForm">
        @csrf
        <div class="row">
            <input type="hidden" id="submissionId" name="id" value="{{$submission->id}}">
            <div class="col-md-6 form-group mb-3">
                <label for="expert_id">Expert <code>*</code></label>
                <select name="expert_id" class="form-control @error('expert_id') is-invalid @enderror">
                    <option value="" hidden>-- Select Expert --</option>
                    @foreach ($experts as $expert)
                        <option value="{{$expert->user_id}}" @selected(old('expert_id', @$submission->expert_id) == $expert->user_id)>{{$expert->expert->fullName($expert, 'expert')}}</option>
                    @endforeach
                </select>
                <p class="text-danger expert_id"></p>
            </div>
            <div class="col-md-12">
                <button type="submit" id="forwardRequest" class="btn btn-primary">{{$submission->forward_expert == 0 ? 'Submit' : 'Update'}}</button>
            </div>
        </div>
    </form>
</div>

<script>
    $("#forwardRequest").on('click', function (e) {
        e.preventDefault();
        var data = new FormData($('#dataForm')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{route('submission.expertForward')}}',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#forwardRequest').attr('disabled', true);
                $('#forwardRequest').append('<span class="spinner spinner-danger ml-2" style="height: 17px; width: 17px;"></span>');
            },
            success: function (response) {
                $('#forwardRequest').attr('disabled', false);
                $('#forwardRequest').text('Update');
                if (response.type == 'success') {
                    $(".modal").modal("hide");
                    toastr.success(response.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else if (response.type == 'error') {
                    toastr.error(response.message);
                }
            },
            error: function (response) {
                var errors =  response.responseJSON.errors;
                $.each(errors, function (key, val) {
                    $('.'+key).html('');
                    $('.'+key).append(val);
                    $('#'+key).addClass('border-danger');
                    $('#'+key).on('change', function(){
                        $('.'+key).html('');
                        $('#'+key).removeClass('border-danger');
                    });
                });
                $('#forwardRequest').attr('disabled', false);
                $('#forwardRequest').text('Update');
            }
        });
    });
</script>
