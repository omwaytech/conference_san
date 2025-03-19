<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTitle">Invite {{$sponsor->name}} For Conference</h5>
    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>
<div class="modal-body">
    <form id="dataForm">
        @csrf
        <div class="row">
            <input type="hidden" id="sponsorId" name="id" value="{{$sponsor->id}}">
            <div class="col-md-6 form-group mb-3">
                <label for="no_of_people">No of people <code>*</code></label>
                <input type="text" name="no_of_people" id="no_of_people" class="form-control @error('no_of_people') is-invalid @enderror" placeholder="input no. of people">
                <p class="text-danger no_of_people"></p>
            </div>
            <div class="col-md-12">
                <button type="submit" id="submitForm" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<script>
    $("#submitForm").on('click', function (e) {
        e.preventDefault();
        var data = new FormData($('#dataForm')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{route('sponsor.inviteForConference')}}',
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
                    $('#'+key).on('change', function(){
                        $('.'+key).html('');
                        $('#'+key).removeClass('border-danger');
                    });
                });
                $('#submitForm').attr('disabled', false);
                $('#submitForm').text('Submit');
            }
        });
    });
</script>
