<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Pass Designation <span class="text-danger">(User:
            {{ $user->user->fullName($user, 'user') }})</span></h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <form id="verifyForm">
        @csrf
        <div class="row">
            <input type="hidden" id="userId" name="user_id" value="{{ $user->id }}">
            <div class="col-md-4 form-group mb-3">
                <label for="pass_designation">Pass Designation <code>*</code></label>
                <input type="text" class="form-control @error('pass_designation') is-invalid @enderror"
                    name="pass_designation" id="pass_designation" value="{{ $user->pass_desingation ?? null }}"
                    placeholder="Enter pass designation" />
                @error('pass_designation')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-12">
                <button type="submit" id="submitData" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<script>
    $("#submitData").on('click', function(e) {
        e.preventDefault();
        var data = new FormData($('#verifyForm')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{ route('admin.passDesginationSubmit') }}',
            data: data,
            dataType: "json",
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#submitData').attr('disabled', true);
                $('#submitData').append(
                    '<span class="spinner spinner-danger ml-2" style="height: 17px; width: 17px;"></span>'
                );
            },
            success: function(response) {
                $('#submitData').attr('disabled', false);
                $('#submitData').text('Submit');
                if (response.type == 'success') {
                    $(".modal").modal("hide");
                    toastr.success(response.message);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(response) {
                var errors = response.responseJSON.errors;
                $.each(errors, function(key, val) {
                    $('.' + key).html('');
                    $('.' + key).append(val);
                    $('#' + key).addClass('border-danger');
                    $('#' + key).on('input', function() {
                        $('.' + key).html('');
                        $('#' + key).removeClass('border-danger');
                    });
                });
                $('#submitData').attr('disabled', false);
                $('#submitData').text('Submit');
            }
        });
    });
</script>
