{{-- <!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SANCON 2025 Pass</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Josefin Sans"';
            font-weight: normal;
            font-style: normal; 
            font-variant: normal;
            src: url("fonts/Josefin_Sans/static/JosefinSans-Regular.ttf") format('truetype');
            src: url('{{ storage_path('fonts/Josefin_Sans/static/JosefinSans-Regular.ttf') }}') format('truetype');
            src: url('http://localhost/CMS-Solo/public/fonts/Josefin_Sans/static/JosefinSans-Regular.ttf') format('truetype');
            src: url("{{asset('fonts/Josefin_Sans/static/JosefinSans-Regular.ttf')}}") format('truetype');
        }

        body {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
    </style>
</head>

<body>
    @foreach ($participants as $participant)
        <div style="width:1280px; height:auto;">
            <div style="width:550px; float:left !important; margin:20px;">
                <div
                    style="font-size:18px; background:url('{{asset('default-images/new-pass-bg.png')}}') no-repeat center top #99e5ff;  background-size:100%; height:auto; overflow:hidden; padding:50px 0px 20px;">
                    <div style="text-align:center;"><img src="{{ asset('frontend') }}/assets/images/logo/SAN.png"
                            width="120" alt="logo" /></div>
                    <div style="padding:95px 0px 0px; font-weight:bold;  text-align:center; line-height:22px;"> 
                        <h1 style="color:#fff;font-size:36px;">SANCON 2025</h1>
                        <h3
                            style="font-size:22px; letter-spacing:-0.8px; font-weight:500;margin:20px 0px 0px; padding:0px;">
                            "Advances in Anesthesia"</h3>
                        <p style="line-height:25px; font-size:20px;">Hyatt Regency Kathmandu<br />
                            4 - 5 April 2025</p>
                        <h6
                            style="font-size:24px; margin:20px 0px; color:#fff; font-weight:500; padding:2px 0px; background-color:rgba(38,38, 142);  ">
                            <h1
                                style="font-size:40px; text-transform:capitalize; line-height:50px; letter-spacing:-0.05em; margin-bottom:10px;">
                                {{ $participant->user->fullName($participant, 'user') }}</h1>
                        </h6>
                    </div>
                    <div style="width:510px; padding:10px 20px 20px; text-align:center; float:left;">
                        <span style="padding:0px"><span style="height:120px;  width:120px;">
                            {!! QrCode::size(120)->generate(config('app.url') . '/participant/profile/' . $participant->token) !!}
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate(config('app.url').'/participant/profile/'.$participant->token)) !!} ">
                        </span>
                    </div>
                    <div style="background-color:#cc0000; height:auto; float:left; width:100%; overflow:hidden;">
                        <h1
                            style="color:#fff; text-transform:capitalize;  font-size:40px; padding:15px 30px; margin:0px; float:left; weight:bold;  text-align:center;">
                            Faculty</h1>
                        <div
                            style="float:right; font-size:30px; font-weight:bold; padding:
        10px 40px;	border-left:3px #fff solid; color:#fff; margin:10px; text-align:center;"> 
                            {{ $participant->userDetail->country->country_name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</body>

</html> --}}



<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,300;0,500;0,700;1,300;1,500;1,700&family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: "Barlow", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
    </style>
</head>

<body>
    <div id="pass-container" class="pass-container">
        @foreach ($participants as $participant)
            <div style="width:1280px; height:auto;">
                <div style="width:550px; float:left !important; margin:20px;">
                    <div class="pass" id="pass-{{ $loop->index }}" data-email="{{ $participant->user->email }}">
                        <div
                            style="font-size:18px; background:url('{{ asset('pass/image-07.png') }}') no-repeat center top #66b7ef;  background-size:100%; height:auto; overflow:hidden; padding:20px 0px 0px;">

                            <ul
                                style="width:100%; margin:0px; float:left; padding:0px; padding-top:0px; padding-bottom:20px;">


                                <li
                                    style="float:left; padding:30px 0px 0px; width:100%; letter-spacing:-0.3px; text-align:center; display:inline; font-size:50px; line-height:40px; color:#fff; font-weight:700;text-shadow:-1px -1px 0 #000;">
                                    SANCON-ASPA 2025
                                </li>


                            </ul>

                            <ul style="width:100%; margin:0px; float:left; padding:0px; padding-bottom:20px;">

                                <li style="float:left; padding-left:60px; text-align:center; display:inline;">
                                    <img src="{{ asset('pass/SAN.png') }}" width="80" alt="" />
                                </li>

                                <li style="float:right; padding-right:60px;  text-align:center; display:inline;">
                                    <img src="{{ asset('pass/ASPA.png') }}" width="80" alt="" />
                                </li>

                            </ul>

                            <div
                                style="padding:30px 0px 0px;  font-size:20px; font-size:20px; text-align:center; font-weight:normal; line-height:22px;">


                                <small
                                    style="font-size:18px; font-weight:500; letter-spacing:-0.02em; color:#000; padding-top:40px;">"Scaling
                                    new heights in Pediatric Anesthesia and beyond"</small>
                                <p
                                    style="line-height:30PX; color:white; margin:0px; padding:2px 0px 6px; font-size:16px; font-weight:500;">
                                    4th - 5th April, 2025, Kathmandu, Nepal<br /> </p>

                                <h6
                                    style="font-size:24px; background:#fff;  margin:5px 0px; line-height:30px; font-weight:500; padding:2px 0px; background-color:rgba(255, 255, 255, 0.1);">
                                </h6>
                                @php
                                    $charCount = strlen($participant->user->fullName($participant, 'user'));
                                @endphp

                                @if ($charCount > 24)
                                    {{-- Adjust the character limit as needed --}}
                                    <h2
                                        style="font-size:26px;text-transform:capitalize; letter-spacing:-0.02em; background:#fff; margin:25px auto 10px; width:470px; border-radius:10px; height:70px; padding:22px 0px;">
                                        {{ $participant->user->namePrefix->prefix ?? null }}
                                        {{ $participant->user->fullName($participant, 'user') }}
                                    </h2>
                                @else
                                    <h1
                                        style="font-size:34px;text-transform:capitalize; letter-spacing:-0.02em; background:#fff; margin:25px auto 10px; width:470px; border-radius:10px; height:70px; padding:22px 0px;">
                                        {{ $participant->user->namePrefix->prefix ?? null }}
                                        {{ $participant->user->fullName($participant, 'user') }}
                                    </h1>
                                @endif

                            </div>
                            <div style="width:510px; padding:0px 20px 10px; text-align:center; float:left;">

                                <div
                                    style="padding:5px; font-size:11px; border-radius:5px; height:148px; width:145px; margin:10px auto 15px; overflow:hidden; background:#fff;">
                                    {!! QrCode::size(120)->generate(config('app.url') . '/participant/profile/' . $participant->token) !!}
                                    {{-- <img src="data:image/png;base64, {!! base64_encode(
                                QrCode::size(200)->generate(config('app.url') . '/participant/profile/' . $participant->token),
                            ) !!} "> --}}
                                    <br />Serial No:{{ $participant->registration_id }}

                                </div>



                            </div>

                            {{-- <div style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                        <h1
                            style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px;  weight:bold; text-align:center;"> --}}
                            @if ($passType == 1)
                                @if (!empty($participant->user->userDetail->pass_designation))
                                    @php
                                        $charCount = strlen($participant->user->userDetail->pass_designation);
                                    @endphp
                                    @if ($charCount > 25)
                                        <div
                                            style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                                            <h1
                                                style="color:#fff;  font-size:30px; padding:0px 30px 8px; margin:0px;height: 70px;  weight:bold; text-align:center;">
                                                {{ $participant->user->userDetail->pass_designation }}
                                            </h1>
                                        </div>
                                    @else
                                        <div
                                            style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                                            <h1
                                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px;height: 70px;  weight:bold; text-align:center;">
                                                {{ $participant->user->userDetail->pass_designation }}
                                            </h1>
                                        </div>
                                    @endif
                                @elseif ($participant->committeMember->isNotEmpty())
                                    <div
                                        style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                                        <h1
                                            style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px; height: 70px;  weight:bold; text-align:center;">
                                            Organizer
                                        </h1>
                                    </div>
                                @endif
                            @endif
                            @if ($passType == 2)
                                @if (!empty($participant->user->userDetail->pass_designation))
                                    @php
                                        $charCounts = strlen($participant->user->userDetail->pass_designation);
                                    @endphp
                                    @if ($charCounts > 25)
                                        <div
                                            style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                                            <h1
                                                style="color:#fff;  font-size:32px; padding:0px 30px 8px; margin:0px; height: 70px;  weight:bold; text-align:center;  ">
                                                {{ $participant->user->userDetail->pass_designation }}
                                            </h1>
                                        </div>
                                    @else
                                        <div
                                            style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                                            <h1
                                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px; height: 70px;  weight:bold; text-align:center;">
                                                {{ $participant->user->userDetail->pass_designation }}
                                            </h1>
                                        </div>
                                    @endif
                                @elseif($participant->committeMember->isNotEmpty())
                                    <div
                                        style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                                        <h1
                                            style="color:#fff;  font-size:40px; padding:0px 30px 8px; height: 70px; margin:0px;  weight:bold; text-align:center;">
                                            Organizer
                                        </h1>
                                    </div>
                                @elseif ($participant->user->userDetail->country->country_name != 'Nepal')
                                    @if ($participant->registrant_type == 1)
                                        <div
                                            style="background-color:#009aee; height:auto; float:left; width:100%; overflow:hidden;">
                                            <h1
                                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px; height: 70px;  weight:bold; text-align:center;">
                                                Delegate<small style=""> -
                                                    {{ $participant->user->userDetail->country->country_name }}</small>
                                            </h1>
                                        </div>
                                    @endif
                                    @if ($participant->registrant_type == 2)
                                        <div
                                            style="background-color:green; height:auto; float:left; width:100%; overflow:hidden;">
                                            <h1
                                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px; height: 70px;  weight:bold; text-align:center;">
                                                Faculty<small style=""> -
                                                    {{ $participant->user->userDetail->country->country_name }}</small>
                                            </h1>
                                        </div>
                                    @endif
                                @endif
                            @endif

                            @if ($passType == 3)
                                @if (
                                    !empty($participant->user->userDetail->pass_designation) &&
                                        $participant->user->userDetail->country->country_name == 'Nepal' &&
                                        $participant->registrant_type == 1 &&
                                        !$participant->committeMember->isNotEmpty())
                                    <div
                                        style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                                        <h1
                                            style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px; height: 70px;  weight:bold; text-align:center;">
                                            {{ $participant->user->userDetail->pass_designation }}
                                        </h1>
                                    </div>
                                @elseif (
                                    $participant->user->userDetail->country->country_name == 'Nepal' &&
                                        $participant->registrant_type == 1 &&
                                        !$participant->committeMember->isNotEmpty())
                                    <div
                                        style="background-color:#009aee; height:auto; float:left; width:100%; overflow:hidden;">
                                        <h1
                                            style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px; height: 70px;  weight:bold; text-align:center;">
                                            Delegate
                                        </h1>
                                    </div>
                                @endif
                            @endif

                            @if ($passType == 4)
                                @if (
                                    !empty($participant->user->userDetail->pass_designation) &&
                                        $participant->user->userDetail->country->country_name == 'Nepal' &&
                                        $participant->registrant_type == 2 &&
                                        !$participant->committeMember->isNotEmpty())
                                    <div
                                        style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                                        <h1
                                            style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px; height: 70px;  weight:bold; text-align:center;">
                                            {{ $participant->user->userDetail->pass_designation }}
                                        </h1>
                                    </div>
                                @elseif (
                                    $participant->user->userDetail->country->country_name == 'Nepal' &&
                                        $participant->registrant_type == 2 && 
                                        !$participant->committeMember->isNotEmpty() &&
                                        ($participant->user->userDetail->member_type_id == 2 || $participant->user->userDetail->member_type_id == 4))
                                    <div
                                        style="background-color:green; height:auto; float:left; width:100%; overflow:hidden;">
                                        <h1
                                            style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px; height: 70px;  weight:bold; text-align:center;">
                                            Speaker
                                        </h1>
                                    </div>
                                @elseif(
                                    $participant->user->userDetail->country->country_name == 'Nepal' &&
                                        $participant->registrant_type == 2 &&
                                        !$participant->committeMember->isNotEmpty() &&
                                        $participant->user->userDetail->member_type_id == 1)
                                    <div
                                        style="background-color:green; height:auto; float:left; width:100%; overflow:hidden;">
                                        <h1
                                            style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px; height: 70px;  weight:bold; text-align:center;">
                                            Faculty
                                        </h1>
                                    </div>
                                @endif
                            @endif
                            <div style="width:92%; font-size:15px; padding:105px 25px 48px; color:#fff; float:left;">

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        @endforeach
        <button onclick="sendAllPasses()">Send All Passes via Email</button>
    </div>
    <script>
        function sendAllPasses() {
            let passes = document.querySelectorAll(".pass");
            let formData = new FormData();
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute("content") : "";
            passes.forEach((pass, index) => {
                let email = pass.getAttribute("data-email");
                if (!email) {
                    console.error(`Email missing for pass ${index}`);
                    return;
                }

                html2canvas(pass, {
                    scale: 2
                }).then(canvas => {
                    canvas.toBlob(blob => {
                        formData.append(`images[]`, blob, `pass_${index + 1}.png`);
                        formData.append(`emails[]`, email);

                        if (index === passes.length - 1) {
                            fetch("/send-pass-email", {
                                method: "POST",
                                body: formData,
                                headers: {
                                    "X-CSRF-TOKEN": csrfToken,
                                    "Accept": "application/json"
                                }
                            }).then(response => response.json()).then(data => {
                                alert(data.message);
                            }).catch(error => console.error("Fetch error:", error));
                        }
                    });
                });
            });

        }
    </script>
</body>

</html>
