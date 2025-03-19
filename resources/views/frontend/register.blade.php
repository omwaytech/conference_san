<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up | {{config('app.name')}}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link href="{{asset('backend')}}/dist-assets/css/themes/lite-purple.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend') }}/dist-assets/css/plugins/toastr.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="auth-layout-wrap" style="background-image: url({{asset('backend')}}/dist-assets/images/conference-background.jpg)">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-4">
                            <div class="auth-logo text-center mb-4"><img src="{{asset('backend')}}/dist-assets/images/logo.png" alt="" height="200" width="200"></div>
                            <h1 class="mb-3 text-18">Sign Up</h1>
                            <form method="POST" action="{{ route('front.registerSubmit') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name_prefix_id">Name Prefix <code>*</code></label>
                                            <select name="name_prefix_id" class="form-control form-control-rounded @error('name_prefix_id') is-invalid @enderror selectname_prefix_id" id="selectname_prefix_id" required>
                                                <option value="" hidden>-- Select Prefix --</option>
                                                @foreach ($prefixesAll as $prefix)
                                                    <option value="{{$prefix->id}}" @if(!empty(old('name_prefix_id'))) @selected(old('name_prefix_id') == $prefix->id) @endif>{{$prefix->prefix}}</option>
                                                @endforeach
                                            </select>
                                            @error('name_prefix_id')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender">Select Gender <code>*</code></label><br>
                                            <input type="radio" @if(old('gender') == 'M') checked @endif id="male" name="gender" value="M">
                                            <label for="male">Male</label><br>
                                            <input type="radio" @if(old('gender') == 'F') checked @endif id="female" name="gender" value="F">
                                            <label for="female">Female</label><br>
                                            <input type="radio" @if(old('gender') == 'O') checked @endif id="other" name="gender" value="O">
                                            <label for="other">Other</label><br>
                                            @error('gender')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="f_name">First Name <code>*</code></label>
                                            <input type="text" class="form-control form-control-rounded @error('f_name') is-invalid @enderror" id="f_name" name="f_name" value="{{ !empty(old('f_name')) ? old('f_name') : session()->get('f_name') }}" required autocomplete="f_name" autofocus>
                                            @error('f_name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="m_name">Middle Name </label>
                                            <input type="text" class="form-control form-control-rounded @error('m_name') is-invalid @enderror" id="m_name" name="m_name" value="{{ !empty(old('m_name')) ? old('m_name') : session()->get('m_name') }}" autocomplete="m_name" autofocus>
                                            @error('m_name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="l_name">Last Name <code>*</code></label>
                                            <input type="text" class="form-control form-control-rounded @error('l_name') is-invalid @enderror" id="l_name" name="l_name" value="{{ !empty(old('l_name')) ? old('l_name') : session()->get('l_name') }}" required autocomplete="l_name" autofocus>
                                            @error('l_name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email <code>*</code></label>
                                            <input type="email" class="form-control form-control-rounded @error('email') is-invalid @enderror" id="email" name="email" value="{{ !empty(old('email')) ? old('email') : session()->get('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone <code>*</code></label>
                                            <input type="text" class="form-control form-control-rounded @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ !empty(old('phone')) ? old('phone') : session()->get('phone') }}" required autocomplete="phone" autofocus>
                                            @error('phone')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="institute_name">Institute Name <code>*</code></label>
                                            <input type="text" class="form-control form-control-rounded @error('institute_name') is-invalid @enderror" id="institute_name" name="institute_name" value="{{ !empty(old('institute_name')) ? old('institute_name') : session()->get('institute_name') }}" required autocomplete="institute_name" autofocus>
                                            @error('institute_name')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Institute Address <code>*</code></label>
                                            <input type="text" class="form-control form-control-rounded @error('address') is-invalid @enderror" id="address" name="address" value="{{ !empty(old('address')) ? old('address') : session()->get('address') }}" required autocomplete="address" autofocus>
                                            @error('address')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="affiliation">Affiliation <code>*</code></label>
                                            <input type="text" class="form-control form-control-rounded @error('affiliation') is-invalid @enderror" id="affiliation" name="affiliation" value="{{ !empty(old('affiliation')) ? old('affiliation') : session()->get('affiliation') }}" required autocomplete="affiliation" autofocus>
                                            @error('affiliation')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="council_number" id="councilText">Medical Council Number <code>*</code></label>
                                            <input type="text" class="form-control form-control-rounded @error('council_number') is-invalid @enderror" id="council_number" name="council_number" value="{{ !empty(old('council_number')) ? old('council_number') : session()->get('council_number') }}" required autocomplete="council_number" autofocus>
                                            @error('council_number')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="delegate">Delegate <code>*</code></label>
                                            <select name="delegate" class="form-control form-control-rounded @error('delegate') is-invalid @enderror selectDelegate" id="selectDelegate" required>
                                                <option value="" hidden>-- Select Delegate --</option>
                                                <option value="National" @if(!empty(old('delegate'))) @selected(old('delegate') == 'National') @elseif(!empty(session()->get('nationality'))) selected @endif>National</option>
                                                <option value="International" @selected(old('delegate') == 'International')>International</option>
                                            </select>
                                            @error('delegate')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="member_type_id">Member Type <code>*</code></label>
                                            <select name="member_type_id" class="form-control form-control-rounded @error('member_type_id') is-invalid @enderror" id="memberTypes" required></select>
                                            @error('member_type_id')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6" hidden id="countryDiv">
                                        <div class="form-group">
                                            <label for="country_id">Country <code>*</code></label>
                                            <select class="form-control form-control-rounded @error('country_id') is-invalid @enderror" name="country_id" id="country_id">
                                                <option value="">-- Select Country --</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->id}}" @selected(old('country_id') == $country->id)>{{$country->country_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('country_id')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password <code>* (Must be atleat 8 characters)</code></label>
                                            <input class="form-control form-control-rounded @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="current-password">
                                            @error('password')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password <code>*</code></label>
                                            <input class="form-control form-control-rounded @error('password_confirmation') is-invalid @enderror" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="current-password">
                                            @error('password_confirmation')
                                                <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-rounded btn-primary btn-block mt-2" type="submit">Sign Up</button>
                                <div class="text-center">
                                    <a class="btn btn-link" href="{{ route('login') }}">
                                        {{ __('Already Signed Up? Go to login') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('frontend') }}/assets/js/jquery.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/toastr.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/toastr.script.min.js"></script>

    @if (Session::has('status'))
        <script>
            toastr.success("{!! Session::get('status') !!}");
        </script>
    @endif
    @if (Session::has('delete'))
        <script>
            toastr.error("{!! Session::get('delete') !!}");
        </script>
    @endif

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#selectDelegate").change(function() {
                $("#nesogNumberDiv").attr('hidden', true);
                $("#nesog_number").attr('required', false);
                var selectedDelegate = $(this).val();
                if ('{{ old('member_type_id') }}' != '') {
                    var memberTypeId = '{{ old('member_type_id') }}';
                } else if ('{{ session()->get('nationality') }}') {
                    var memberTypeId = 1;
                }
                if (selectedDelegate == "International") {
                    $("#countryDiv").attr('hidden', false);
                    $("#country_id").attr('required', true);
                } else {
                    $("#countryDiv").attr('hidden', true);
                    $("#country_id").attr('required', false);
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
                            console.log(data);
                            var optionsHtml = '<option value="" hidden>-- Select Member Type --</option>';
                            $.each(data, function(index, item) {
                                var selected = (item.id == memberTypeId) ? 'selected' : '';
                                optionsHtml += '<option value="' + item.id + '" ' + selected + '>' + item.type + '</option>';
                            });
                            memberTypes.append(optionsHtml);
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
</body>
