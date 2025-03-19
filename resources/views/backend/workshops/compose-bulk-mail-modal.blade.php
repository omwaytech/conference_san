<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Send mail to all attendees for workshop ({{$workshop->title}})</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <form id="dataForm">
        @csrf
        <div class="row">
            <input type="hidden" id="id" name="id" value="{{$workshop->id}}">
            <div class="col-md-12 form-group mb-3">
                <label for="subject">Subject <code>*</code></label>
                <input type="text" name="subject" class="form-control" id="subject" placeholder="Enter subject for mail">
                <p class="text-danger subject"></p>
            </div>
            <div class="col-md-12 form-group mb-3">
                <label for="message">Compose Mail Message <code>*</code></label>
                <textarea name="message" class="form-control" id="message" cols="30" rows="10"></textarea>
                <p class="text-danger message"></p>
            </div>
            <div class="col-md-12">
                <button type="submit" id="submitForm" class="btn btn-primary">Send</button>
            </div>
        </div>
    </form>
</div>

<script>
    CKEDITOR.replace('message', {
        filebrowserUploadUrl: '{{ route('ckeditor.fileUpload', ['_token' => csrf_token()]) }}',
        filebrowserUploadMethod: "form"
    });

    $("#submitForm").on('click', function (e) {
        e.preventDefault();
        var data = new FormData($('#dataForm')[0]);
        data.append('message',CKEDITOR.instances['message'].getData());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{route('workshop.sendBulkMail')}}',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#submitForm').attr('disabled', true);
                $('#submitForm').append('<span class="spinner spinner-danger ml-2" style="height: 17px; width: 17px;"></span>');
            },
            success: function (response) {
                $(".modal").modal("hide");
                toastr.success(response.successMessage);
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
                    $('#'+key).on('change', function(){
                        $('.'+key).html('');
                        $('#'+key).removeClass('border-danger');
                    });
                });
                $('#submitForm').attr('disabled', false);
                $('#submitForm').text('Send');
            }
        });
    });
</script>
