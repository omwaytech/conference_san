<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Committee: {{$committee->committee_name}}</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <form id="membersForm">
            <div class="row">
                <input type="hidden" name="committee_id" value="{{$committee->id}}">
                <div class="col-md-12 form-group mb-3">
                    <label for="user_id">Select Committee Members <code>*</code></label>
                    <select name="user_id[]" id="multipleUsers" class="form-control" multiple>
                        @foreach ($users as $user)
                            @php
                                $isSelected = false;
                            @endphp
                            @foreach ($members as $member)
                                @if ($member['user_id'] == $user->id)
                                    @php
                                        $isSelected = true;
                                        break;
                                    @endphp
                                @endif
                            @endforeach
                            <option value="{{$user->id}}" {{$isSelected ? 'selected' : ''}}>{{$user->fullName($user)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" id="submitData">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('#multipleUsers').select2();

    $("#submitData").on('click', function (e) {
        e.preventDefault();
        var data = new FormData($('#membersForm')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{route('committeeMember.submitData')}}',
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
