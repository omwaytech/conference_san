<div class="modal-content" id="hello">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Committee: {{$committee->committee_name}}</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <form id="membersForm">
            <input type="hidden" name="committee_id" value="{{$committee->id}}">
            <div id="dynamic_field">
                <div class="row">
                    {{-- <div class="col-md-12 form-group mb-3">
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
                    </div> --}}
                    <div class="col-md-6 form-group mb-3">
                        <label for="user_id">Committee Members</label>
                        <select name="user_id[]" class="form-control select2">
                            <option value="" hidden>-- Select Committee Member --</option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->fullName($user)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 form-group mb-3">
                        <label for="designation_id[]">Designation</label>
                        <select name="designation_id[]" class="form-control">
                            <option value="" hidden>-- Select Designation --</option>
                            @foreach ($designations as $designation)
                                <option value="{{$designation->id}}">{{$designation->designation}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1 form-group mb-3">
                        <label for="">Add</label><br>
                        <button type="button" id="add" class="btn btn-success btn-sm">+</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" id="submitData">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('.select2').select2({
      dropdownParent: $('#hello')
    });

    var i=1;
    var users = @json($users);
    var designations = @json($designations);
    $('#add').click(function(){
        i++;
        var userOptions = '';
        users.forEach(function(user) {
            userOptions += '<option value="' + user.id + '">' + user.f_name + ' ' + (user.m_name ? user.m_name + ' ' : '') + user.l_name + '</option>';
        });
        var designationOptions = '';
        designations.forEach(function(designation) {
            designationOptions += '<option value="' + designation.id + '">' + designation.designation + '</option>';
        });
        $('#dynamic_field').append('<div id="row'+i+'" class="row dynamic-added">' +
            '<div class="col-md-6 form-group mb-3"><select name="user_id[]" class="form-control select2">' +
                '<option>-- Select Committee Member --</option>' +
                userOptions +
            '</select>' +
            '</div>' +
            '<div class="col-md-5 form-group mb-3"><select name="designation_id[]" class="form-control">' +
                '<option>-- Select Designation --</option>' +
                designationOptions +
            '</select></div>' +
            '<div class="col-md-1 form-group mb-3">'+
                    '<button type="button" id="'+i+'" class="btn btn-danger btn-sm btn_remove">X</button>' +
                '</div></div>');
        $('#row' + i + ' .select2').select2({
            dropdownParent: $('#hello')
        });
    });

    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id");
        $('#row'+button_id+'').remove();
    });

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
