<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>NESOGCON Pass</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
    </style>
</head>

<body>
    <div style="width:1280px; height:auto;">
        @foreach ($sponsors as $sponsor)
            <div style="width:550px; float:left !important; margin:20px;">
                <div
                    style="font-size:18px; background:url('https://nesog.org.np/public/frontend/assets/NESOG-PAss.png') no-repeat center top #6dc3fe;  background-size:100%; height:auto; overflow:hidden; padding:80px 0px 20px;">
                    <div style="text-align:center;"><img src="https://nesog.org.np/public/frontend/assets/img/NESOG.png"
                            width="140" alt="" /></div>
                    <div
                        style="padding:28px 0px 0px;  font-size:20px; font-size:20px; letter-spacing:-0.5px !important;  text-align:center; font-weight:normal; line-height:22px;">
                        <h1
                            style="font-size:34px; color:#fff; font-weight:800; margin-bottom:40px; text-align:center; width:100%; text-shadow:0 1px 1px #000;">
                            NESOGCON 2024</h1>
                        <small style="font-size:24px; color:#000; padding-top:40px;">Advances in Women's Health Care Now &
                            Beyond</small>
                        <p style="line-height:30PX; margin:0px; padding:10px 0px; font-weight:bold;">Hyatt Regency
                            Kathmandu<br />
                            5th - 6th April 2024 </p>
                        <h6
                            style="font-size:24px; margin:5px 0px; line-height:30px; font-weight:500; padding:2px 0px; background-color:rgba(38,38, 142);">
                            <h1 style="font-size:34px; text-transform:uppercase; height:52px; letter-spacing:-0.05em; padding-top:10px;">
                                {{$sponsor->name}}
                            </h1>
                        </h6>
                    </div>
                    <div style="width:510px; padding:10px 20px 20px; text-align:center; float:left;">
                        <span style="padding:0px">
                            <span style="height:120px; width:120px;">
                                {!! QrCode::size(120)->generate(config('app.url').'/sponsor/profile/'.$sponsor->token) !!}
                            </span>
                        </span>
                    </div>
                    <div style="background-color:rgba(38,38, 142); height:auto; float:left; width:100%; overflow:hidden;">
                        <h1 style="color:#fff;  font-size:40px; padding:15px 30px; margin:0px;  weight:bold; text-align:center;">
                            {{$sponsor->category->category_name}}
                        </h1>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>
