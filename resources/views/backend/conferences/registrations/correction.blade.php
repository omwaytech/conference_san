<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Send Correction Mail <span class="text-danger">(Registrant Name: {{$registration->user->name}})</span></h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <form id="verifyForm">
        @csrf
        <div class="row">
            <input type="hidden" id="registrationId" name="id" value="{{$registration->id}}">
            <div class="col-md-12 form-group mb-3">
                <label for="remarks">Remarks <code>*</code></label>
                <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="5">{{old('remarks')}}</textarea>
                <p class="text-danger remarks"></p>
            </div>
            <div class="col-md-12">
                <button type="submit" id="sendCorrectionMailSubmit" class="btn btn-primary">Send</button>
            </div>
        </div>
    </form>
</div>

<script>
    $("#sendCorrectionMailSubmit").on('click', function (e) {
        e.preventDefault();
        var data = new FormData($('#verifyForm')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{route('conferenceRegistration.sendCorrectionMailSubmit')}}',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#sendCorrectionMailSubmit').attr('disabled', true);
                $('#sendCorrectionMailSubmit').append('<span class="spinner spinner-danger ml-2" style="height: 17px; width: 17px;"></span>');
            },
            success: function (response) {
                $('#sendCorrectionMailSubmit').attr('disabled', false);
                $('#sendCorrectionMailSubmit').text('Submit');
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
                $('#sendCorrectionMailSubmit').attr('disabled', false);
                $('#sendCorrectionMailSubmit').text('Submit');
            }
        });
    });
</script>
