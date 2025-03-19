@extends('layouts.dash')

@section('title')
    Update Profile
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Update Profile</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{route('home.editProfileUpdate')}}" method="POST" enctype="multipart/form-data" id="editProfileForm">
                        @csrf
                        @method('patch')
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <div class="row">
                            <div class="col-md-3 form-group mb-3">
                                <label for="gender">Select Gender <code>*</code></label><br>
                                <input type="radio" @if(old('gender') == 'M' || @$user->userDetail->gender == 'M') checked @endif id="male" name="gender" value="M">
                                <label for="html" class="mr-3">Male</label>
                                <input type="radio" @if(old('gender') == 'F' || @$user->userDetail->gender == 'F') checked @endif id="female" name="gender" value="F">
                                <label for="css" class="mr-3">Female</label>
                                <input type="radio" @if(old('gender') == 'O' || @$user->userDetail->gender == 'O') checked @endif id="other" name="gender" value="O">
                                <label for="css">Other</label>
                                @error('gender')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="name_prefix_id">Name Prefix <code>*</code></label>
                                <select class="form-control @error('name_prefix_id') is-invalid @enderror" name="name_prefix_id" id="name_prefix_id">
                                    @foreach ($prefixes as $prefix)
                                        <option value="{{$prefix->id}}" @if(!empty(old('name_prefix_id'))) @selected(old('name_prefix_id') == $prefix->id) @elseif(@$user->name_prefix_id == $prefix->id) selected @endif>{{$prefix->prefix}}</option>
                                    @endforeach
                                </select>
                                @error('name_prefix_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="f_name">First Name <code>*</code></label>
                                <input type="text" class="form-control @error('f_name') is-invalid @enderror" name="f_name" value="{{!empty(old('f_name')) ? old('f_name') : $user->f_name}}" required/>
                                @error('f_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="m_name">Middle Name</label>
                                <input type="text" class="form-control @error('m_name') is-invalid @enderror" name="m_name" value="{{!empty(old('m_name')) ? old('m_name') : $user->m_name}}" required/>
                                @error('m_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="l_name">Last Name <code>*</code></label>
                                <input type="text" class="form-control @error('l_name') is-invalid @enderror" name="l_name" value="{{!empty(old('l_name')) ? old('l_name') : $user->l_name}}" required/>
                                @error('l_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="email">Email <code>*</code></label>
                                <input type="email" class="form-control" name="email" id="email" value="{{!empty(old('email')) ? old('email') : $user->email}}" required>
                                @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="phone">Phone <code>*</code></label>
                                <input type="text" class="form-control" name="phone" id="phone" value="{{!empty(old('phone')) ? old('phone') : @$user->userDetail->phone}}" required>
                                @error('phone')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="council_number">Medical Council/ Board certification Number <code>*</code></label>
                                <input type="text" class="form-control" name="council_number" id="council_number" value="{{!empty(old('council_number')) ? old('council_number') : @$user->userDetail->council_number}}" required>
                                @error('council_number')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3" hidden>
                                <label for="country_id">Country <code>*</code></label>
                                <select class="form-control @error('country_id') is-invalid @enderror" name="country_id" id="country_id">
                                    <option value="">-- Select Country --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{$country->id}}" @if(!empty(old('country_id'))) @selected(old('country_id') == $country->id) @elseif(@$user->userDetail->country->id == $country->id) selected @endif>{{$country->country_name}}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3" hidden>
                                <label for="delegate">Delegate <code>*</code></label>
                                <select name="delegate" class="form-control @error('delegate') is-invalid @enderror selectDelegate" id="selectDelegate" required>
                                    <option value="" hidden>-- Select Delegate --</option>
                                    <option value="National" @if(!empty(old('delegate'))) @selected(old('delegate') == 'National') @elseif(@$user->userDetail->memberType->delegate == 'National' || @$user->userDetail->country->country_name == 'Nepal') selected @endif>National</option>
                                    <option value="International" @if(!empty(old('delegate'))) @selected(old('delegate') == 'International') @elseif(@$user->userDetail->memberType->delegate == 'International' || @$user->userDetail->country->country_name != 'Nepal') selected @endif>International</option>
                                </select>
                                @error('delegate')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="member_type_id">Member Type <code>*</code></label>
                                <select name="member_type_id" class="form-control @error('member_type_id') is-invalid @enderror" id="memberTypes" required></select>
                                @error('member_type_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3" hidden id="memberShipNumberDiv">
                                <label for="san_number">Membership Number <code>*</code></label>
                                <input type="text" class="form-control" name="san_number" id="san_number" value="{{!empty(old('san_number')) ? old('san_number') : @$user->userDetail->san_number}}" required>
                                @error('san_number')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="affiliation">Institute Designation</label>
                                <input type="text" class="form-control" name="affiliation" id="affiliation" value="{{!empty(old('affiliation')) ? old('affiliation') : @$user->userDetail->affiliation}}" required>
                                @error('affiliation')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" name="department" id="department" value="{{!empty(old('department')) ? old('department') : @$user->userDetail->department}}" required>
                                @error('department')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="institute_name">Institute Name</label>
                                <input type="text" class="form-control" name="institute_name" id="institute_name" value="{{!empty(old('institute_name')) ? old('institute_name') : @$user->userDetail->institute_name}}" required>
                                @error('institute_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="address">Institute Address</label>
                                <input type="text" class="form-control" name="address" id="address" value="{{!empty(old('address')) ? old('address') : @$user->userDetail->address}}" required>
                                @error('address')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-5 form-group mb-3">
                                <label for="image">Image <code>(Only JPG/PNG) (Max: 500KB)</code></label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" />
                                @error('image')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                    @if (isset($user))
                                        <div class="col-3 mt-2">
                                            <img src="{{asset('storage/users/'.@$user->userDetail->image)}}" alt="image" class="img-fluid">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" id="submitButton">Update</button>
                                <a href="{{route('admin.signedUpUsersList')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#submitButton").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#editProfileForm").submit();
            });

            $("#selectDelegate").change(function() {
                var existingMemberId = '{{@$user->userDetail->member_type_id}}';
                var selectedDelegate = $(this).val();
                if ('{{ old('member_type_id') }}' != '') {
                    var memberTypeId = '{{ old('member_type_id') }}';
                } else if (existingMemberId != '') {
                    var memberTypeId = existingMemberId;
                }
                $.ajax({
                    type: 'POST',
                    url: '{{ route('front.getMemberTypes') }}',
                    data: {
                        selectedDelegate: selectedDelegate
                    },
                    success: function(response) {
                        var memberTypes = $('#memberTypes');
                        memberTypes.empty();
                        if (response.type == 'success') {
                            $("#memberTypes").attr('disabled', false);
                            var data = response.data.types;
                            var optionsHtml = '<option value="" hidden>-- Select Member Type --</option>';
                            $.each(data, function(index, item) {
                                var selected = (item.id == memberTypeId) ? 'selected' : '';
                                optionsHtml += '<option value="' + item.id + '" ' + selected + '>' + item.type + '</option>';
                            });
                            memberTypes.append(optionsHtml);

                            $("#memberTypes").change(function (e) {
                                e.preventDefault();
                                var memberTypeId = $(this).val();
                                if (memberTypeId == 1 || memberTypeId == 2) {
                                    $("#memberShipNumberDiv").attr('hidden', false);
                                } else {
                                    $("#memberShipNumberDiv").attr('hidden', true);
                                }
                            });
                            $("#memberTypes").trigger('change');
                        } else{
                            $("#memberTypes").attr('disabled', true);
                            memberTypes.append('<option value="" hidden>-- Select Delegate First --</option>');
                        }
                    }
                });
            });
            $("#selectDelegate").trigger('change');
        });
    </script>
@endsection
