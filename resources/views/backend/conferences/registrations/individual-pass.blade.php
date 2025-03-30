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
    <style>
        body {
            font-family: "Barlow", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
    </style>
</head>


<body>
    {{-- @foreach ($participants as $participant) --}}
    <div style="width:1280px; height:auto;">
        <div style="width:550px; float:left !important; margin:20px;">
            <div
                style="font-size:18px; background:url('{{ asset('pass/Image-07.png') }}') no-repeat center top #66b7ef;  background-size:100%; height:auto; overflow:hidden; padding:20px 0px 0px;">

                <ul style="width:100%; margin:0px; float:left; padding:0px; padding-top:0px; padding-bottom:20px;">


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
                    <h1
                        style="font-size:34px;text-transform:capitalize; letter-spacing:-0.02em; background:#fff; margin:25px auto 10px; width:470px; border-radius:10px; height:30px; padding:22px 0px;">
                        {{ $participant->user->namePrefix->prefix ?? null }}
                        {{ $participant->user->fullName($participant, 'user') }}
                    </h1>
                </div>
                <div style="width:510px; padding:0px 20px 10px; text-align:center; float:left;">

                    <div
                        style="padding:5px; font-size:15px; border-radius:5px; height:138px; width:120px; margin:10px auto 15px; overflow:hidden; background:#fff;">
                        {!! QrCode::size(120)->generate(config('app.url') . '/participant/profile/' . $participant->token) !!}
                        {{-- <img src="data:image/png;base64, {!! base64_encode(
                            QrCode::size(200)->generate(config('app.url') . '/participant/profile/' . $participant->token),
                        ) !!} "> --}}
                        <br />Serial No: ORG002

                    </div>



                </div>

                {{-- <div style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                    <h1
                        style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px;  weight:bold; text-align:center;"> --}}
                @if ($type == 'attendees' || $type == 'guest-attendees')
                    @if (!empty($participant->user->userDetail->pass_designation))
                        <div style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                            <h1
                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px;  weight:bold; text-align:center;">
                                {{ $participant->user->userDetail->pass_designation }}
                            </h1>
                        </div>
                    @elseif ($participant->committeMember->isNotEmpty())
                        <div style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                            <h1
                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px;  weight:bold; text-align:center;">
                                Organizer
                            </h1>
                        </div>
                    @elseif(
                        $participant->user->userDetail->country->country_name == 'Nepal' &&
                            ($participant->user->userDetail->member_type_id == 1 ||
                                $participant->user->userDetail->member_type_id == 2 ||
                                $participant->user->userDetail->member_type_id == 4))
                        <div style="background-color: #009aee; height:auto; float:left; width:100%; overflow:hidden;">
                            <h1
                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px;  weight:bold; text-align:center;">
                                Delegate
                            </h1>
                        </div>
                    @elseif($participant->user->userDetail->country->country_name !== 'Nepal')
                        <div style="background-color:#009aee; height:auto; float:left; width:100%; overflow:hidden;">
                            <h1
                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px;  weight:bold; text-align:center;">
                                Delegate ({{ $participant->user->userDetail->country->country_name }})
                            </h1>
                        </div>
                    @else
                        <div style="background-color: #009aee; height:auto; float:left; width:100%; overflow:hidden;">
                            <h1
                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px;  weight:bold; text-align:center;">

                                Delegate
                            </h1>
                        </div>
                    @endif
                @endif
                @if ($type == 'speakers' || $type == 'invited-speakers')
                    @if (!empty($participant->user->userDetail->pass_designation))
                        <div style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                            <h1
                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px;  weight:bold; text-align:center;">
                                {{ $participant->user->userDetail->pass_designation }}
                            </h1>
                        </div>
                    @elseif ($participant->committeMember->isNotEmpty())
                        <div style="background-color:red; height:auto; float:left; width:100%; overflow:hidden;">
                            <h1
                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px;  weight:bold; text-align:center;">
                                Organizer
                            </h1>
                        </div>
                    @elseif(
                        $participant->user->userDetail->country->country_name == 'Nepal' &&
                            ($participant->user->userDetail->member_type_id == 1 ||
                                $participant->user->userDetail->member_type_id == 2 ||
                                $participant->user->userDetail->member_type_id == 4))
                        <div style="background-color:green; height:auto; float:left; width:100%; overflow:hidden;">
                            <h1
                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px;  weight:bold; text-align:center;">
                                Faculty
                            </h1>
                        </div>
                    @elseif($participant->user->userDetail->country->country_name !== 'Nepal')
                        <div style="background-color:green; height:auto; float:left; width:100%; overflow:hidden;">
                            <h1
                                style="color:#fff;  font-size:40px; padding:0px 30px 8px; margin:0px;  weight:bold; text-align:center;">
                                Faculty ({{ $participant->user->userDetail->country->country_name }})
                            </h1>
                        </div>
                    @endif
                @endif

                <div style="width:92%; font-size:15px; padding:105px 25px 48px; color:#fff; float:left;">

                </div>






            </div>
        </div>



    </div>
    {{-- @endforeach --}}
</body>

</html>
