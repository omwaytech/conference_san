<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Add Payment Voucher <span class="text-danger">(Registrant Name: {{$registration->user->name}})</span></h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <form id="verifyForm">
        @csrf
        <div class="row">
            <input type="hidden" id="registrationId" name="id" value="{{$registration->id}}">
            <div class="col-md-6 form-group mb-3 hideDiv">
                <label for="payment_voucher">Payment Voucher <code>(Only JPG/PNG/PDF) (Max: 250 KB)</code></label>
                <input type="file" class="form-control @error('payment_voucher') is-invalid @enderror"
                    name="payment_voucher" id="image2" />
                <p class="text-danger payment_voucher"></p>
                <div class="row" id="imgPreview2"></div>
            </div>
            <div class="col-md-12">
                <button type="submit" id="addPaymentVoucherButton" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<script>

    $("#image2").change(function() {
        let reader = new FileReader();

        $("#imgPreview2").html('');

        reader.onload = function(e) {
            let fileExtension2 = $("#image2").val().split('.').pop().toLowerCase();

            if (fileExtension2 === 'pdf') {
                $("#imgPreview2").append('<div class="col-3 mt-2"><img src="{{asset('default-images/pdf.png')}}" class="img-fluid" /></div>');
            } else if (fileExtension2 === 'ppt' || fileExtension2 === 'pptx' || fileExtension2 === 'pptm') {
                $("#imgPreview2").append('<div class="col-3 mt-2"><img src="{{asset('default-images/ppt.png')}}" class="img-fluid" /></div>');
            } else if (fileExtension2 === 'doc' || fileExtension2 === 'docx') {
                $("#imgPreview2").append('<div class="col-3 mt-2"><img src="{{asset('default-images/word.png')}}" class="img-fluid" /></div>');
            } else {
                $("#imgPreview2").append('<div class="col-3 mt-2"><img src="' + e.target.result +
                    '" class="img-fluid" /></div>');
            }
        };

        reader.readAsDataURL(this.files[0]);
    });

    $(document).on("change", "#verified_status", function (e) {
        e.preventDefault();
        if ($(this).val() === '1') {
            $("#remarksDiv").attr('hidden', true);
        } else if ($(this).val() === '2') {
            $("#remarksDiv").attr('hidden', false);
        }
    });

    $("#addPaymentVoucherButton").on('click', function (e) {
        e.preventDefault();
        var data = new FormData($('#verifyForm')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{route('conferenceRegistration.addPaymentVoucherSubmit')}}',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#addPaymentVoucherButton').attr('disabled', true);
                $('#addPaymentVoucherButton').append('<span class="spinner spinner-danger ml-2" style="height: 17px; width: 17px;"></span>');
            },
            success: function (response) {
                $('#addPaymentVoucherButton').attr('disabled', false);
                $('#addPaymentVoucherButton').text('Submit');
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
                $('#addPaymentVoucherButton').attr('disabled', false);
                $('#addPaymentVoucherButton').text('Submit');
            }
        });
    });
</script>
