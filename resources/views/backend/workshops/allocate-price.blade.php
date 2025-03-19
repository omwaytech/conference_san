<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Allocate Price To Following Members For (Workshop: {{$workshop->title}})</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <form id="submissionSettingForm">
            <div class="row">
                @foreach ($memberTypes as $memberType)
                    <input type="hidden" name="workshop_id" value="{{$workshop->id}}">
                    <input type="hidden" name="member_type_id[]" value="{{$memberType->id}}">
                    <input type="hidden" name="price_id[]" value="{{$memberType->price_id}}">
                    <div class="col-md-6 form-group mb-3">
                        <label for="price[]">{{$memberType->type}} <code>(Price In Number) ({{$memberType->delegate == 'National' ? 'Rs.' : '$'}})</code></label>
                        <input type="text" class="form-control numericValue" name="price[]" value="{{$memberType->price}}" placeholder="Enter price"/>
                    </div>
                @endforeach
                @if ($workshop->user_id == auth()->user()->id)
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" id="submitData">{{empty($memberTypes[0]->price_id) ? 'Submit' : 'Update'}}</button>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>

<script>
    $(".numericValue").on("keydown", function(event) {
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

    $("#submitData").on('click', function (e) {
        e.preventDefault();
        var data = new FormData($('#submissionSettingForm')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{route('workshop.allocatePriceSubmit')}}',
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
                $('#submitData').text('Update');
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
                    $('#'+key).on('change', function(){
                        $('.'+key).html('');
                        $('#'+key).removeClass('border-danger');
                    });
                });
                $('#submitData').attr('disabled', false);
                $('#submitData').text('Update');
            }
        });
    });
</script>
