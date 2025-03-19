<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Invite For Conference <span class="text-danger">(User: {{$user->fullName($user)}})</span></h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <form id="verifyForm">
        @csrf
        <div class="row">
            <input type="hidden" id="userId" name="user_id" value="{{$user->id}}">
            <div class="col-md-6 form-group mb-3">
                <label for="registrant_type">Registrant Type <code>*</code></label>
                <select name="registrant_type" class="form-control" id="registrant_type">
                    <option value="" hidden>-- Select Registrant Type --</option>
                    <option value="1">Attendee</option>
                    <option value="2">Presenter/Speaker</option>
                </select>
                <p class="text-danger registrant_type"></p>
            </div>
            <div class="col-md-12">
                <button type="submit" id="submitData" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<script>

    $("#submitData").on('click', function (e) {
        e.preventDefault();
        var data = new FormData($('#verifyForm')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{route('admin.inviteUserForConferenceSubmit')}}',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#submitData').attr('disabled', true);
                $('#submitData').append('<span class="spinner spinner-danger ml-2" style="height: 17px; width: 17px;"></span>');
            },
            success: function (response) {
                $('#submitData').attr('disabled', false);
                $('#submitData').text('Submit');
                if (response.type == 'success') {
                    $(".modal").modal("hide");
                    toastr.success(response.message);
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message);
                }
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
                    });
                });
                $('#submitData').attr('disabled', false);
                $('#submitData').text('Submit');
            }
        });
    });
</script>
