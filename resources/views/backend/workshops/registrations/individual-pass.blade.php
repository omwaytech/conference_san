<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SANCON 2025 Pass</title>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet"> --}}
    <style>
        @font-face {
            font-family: 'Josefin Sans"';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            /* src: url("fonts/Josefin_Sans/static/JosefinSans-Regular.ttf") format('truetype'); */
            src: url('{{ storage_path('fonts/Josefin_Sans/static/JosefinSans-Regular.ttf') }}') format('truetype');
            /* src: url('http://localhost/CMS-Solo/public/fonts/Josefin_Sans/static/JosefinSans-Regular.ttf') format('truetype'); */
            /* src: url("{{asset('fonts/Josefin_Sans/static/JosefinSans-Regular.ttf')}}") format('truetype'); */
        }

        body {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
    </style>
</head>

<body>
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
                        "{{$participant->workshop->title}}"</h3>
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
                        {{-- {!! QrCode::size(120)->generate(config('app.url') . '/participant/profile/' . $participant->token) !!} --}}
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate(config('app.url').'/workshop-participant/profile/'.$participant->token)) !!} ">
                    </span>
                </div>
                <div style="background-color:#cc0000; height:auto; float:left; width:100%; overflow:hidden;">
                    <h1
                        style="color:#fff; text-transform:capitalize;  font-size:40px; padding:15px 30px; margin:0px; float:left; weight:bold;  text-align:center;">
                        Faculty</h1>
                    <div
                        style="float:right; font-size:30px; font-weight:bold; padding:
    10px 40px;	border-left:3px #fff solid; color:#fff; margin:10px; text-align:center;">
                        {{-- {{ $participant->userDetail->country->country_name }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
