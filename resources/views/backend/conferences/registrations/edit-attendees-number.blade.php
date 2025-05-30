<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Total Number Of Attendees <span class="text-danger">(Registrant Name: {{$registration->user->name}})</span></h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <form id="verifyForm">
        @csrf
        <div class="row">
            <input type="hidden" id="registrationId" name="id" value="{{$registration->id}}">
            <div class="col-md-6 form-group mb-3">
                <label for="total_attendee">Decide Request <code>*</code></label>
                <input type="number" name="total_attendee" id="total_attendee" class="form-control @error('total_attendee') is-invalid @enderror" value="{{$registration->total_attendee}}">
                <p class="text-danger total_attendee"></p>
            </div>
            <div class="col-md-12">
                <button type="submit" id="verifyRegistrant" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<script>

    $(document).on("change", "#verified_status", function (e) {
        e.preventDefault();
        if ($(this).val() === '1') {
            $("#remarksDiv").attr('hidden', true);
        } else if ($(this).val() === '2') {
            $("#remarksDiv").attr('hidden', false);
        }
    });

    $("#verifyRegistrant").on('click', function (e) {
        e.preventDefault();
        var data = new FormData($('#verifyForm')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{route('conferenceRegistration.editAttendeesNumberSubmit')}}',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#verifyRegistrant').attr('disabled', true);
                $('#verifyRegistrant').append('<span class="spinner spinner-danger ml-2" style="height: 17px; width: 17px;"></span>');
            },
            success: function (response) {
                $('#verifyRegistrant').attr('disabled', false);
                $('#verifyRegistrant').text('Submit');
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
                $('#verifyRegistrant').attr('disabled', false);
                $('#verifyRegistrant').text('Submit');
            }
        });
    });
</script>
