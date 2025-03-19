<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Decide Workshop Request of ({{$workshop->title}})</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <form id="decisionForm">
        @csrf
        <div class="row">
            <input type="hidden" id="workshopId" name="id" value="{{$workshop->id}}">
            <div class="col-md-6 form-group mb-3">
                <label for="approved_status">Decide Request <code>*</code></label>
                <select name="approved_status" id="approved_status" class="form-control @error('approved_status') is-invalid @enderror">
                    <option value="" hidden>-- Select Status --</option>
                    <option value="1" @selected(old('approved_status') == 1)>Accept</option>
                    <option value="2" @selected(old('approved_status') == 2)>Correction</option>
                    <option value="3" @selected(old('approved_status') == 3)>Reject</option>
                </select>
                <p class="text-danger approved_status"></p>
            </div>
            <div class="col-md-6 form-group mb-3" id="cpdPoint" hidden>
                <label for="cpd_point">CPD Point </label>
                <input type="text" class="form-control @error('cpd_point') is-invalid @enderror integerValue" name="cpd_point" id="cpd_point" />
                <p class="text-danger cpd_point"></p>
            </div>
            <div class="col-md-6 form-group mb-3" id="attachmentDiv" hidden>
                <label for="attachment">Attachment <code>(Only: PDF) (Max: 1MB)</code></label>
                <input type="file" class="form-control @error('attachment') is-invalid @enderror" name="attachment" id="attachment" />
                <p class="text-danger attachment"></p>
                <div class="row" id="imgPreview"></div>
            </div>
            <div class="col-md-12 form-group mb-3" id="remarksDiv" hidden>
                <label for="remarks">Remarks <code>*</code></label>
                <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="5">{{old('remarks')}}</textarea>
                <p class="text-danger remarks"></p>
            </div>
            <div class="col-md-12">
                <button type="submit" id="decideRequest" class="btn btn-primary">Decide</button>
            </div>
        </div>
    </form>
</div>

<script>

    $(document).on("change", "#approved_status", function (e) {
        e.preventDefault();
        if ($(this).val() == 1) {
            $("#cpdPoint").attr('hidden', false);
            $("#remarksDiv").attr('hidden', true);
            $("#attachmentDiv").attr('hidden', true);
        } else if ($(this).val() == 3) {
            $("#cpdPoint").attr('hidden', true);
            $("#remarksDiv").attr('hidden', false);
            $("#attachmentDiv").attr('hidden', true);
        } else if ($(this).val() == 2) {
            $("#cpdPoint").attr('hidden', true);
            $("#remarksDiv").attr('hidden', false);
            $("#attachmentDiv").attr('hidden', false);
        }
    });

    $(".integerValue").on("keydown", function(event) {
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
            url: '{{route('workshop.decideRequest')}}',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#decideRequest').attr('disabled', true);
                $('#decideRequest').append('<span class="spinner spinner-danger ml-2" style="height: 17px; width: 17px;"></span>');
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
                $('#decideRequest').attr('disabled', false);
                $('#decideRequest').text('Decide');
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
        });
    });
</script>
