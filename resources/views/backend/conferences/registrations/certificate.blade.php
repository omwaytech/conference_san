<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Certificate | SANCON 2024</title>
    {{-- <link href="{{asset('plugin-links/pass-font.css')}}" rel="stylesheet">
    <link href="{{asset('plugin-links/certificate-font.css')}}" rel="stylesheet"> --}}
    <link href="{{asset('plugin-links/font/stylesheet.css')}}" rel="stylesheet">
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
    <table width="1410" border="0" cellspacing="0" cellpadding="0"
        style="font-size:18px; background:url('{{asset('frontend/assets/images/certificate-bg.jpg')}}') no-repeat center top; background-size:100%; margin-bottom:50px">
        <tr>
            <td>

                <table width="1600" border="0" cellspacing="0" cellpadding="0"
                    style="padding-top:100px; text-align:center; line-height:0px;">
                    <tr>

                        <td width="355">&nbsp;</td>
                        <td width="700">
                            <h1
                                style="text-transform:uppercase; font-size:40px; background-color:#cc0000; width:auto; height:45px; line-height:50px; padding:10px 0px; overflow:hidden; color:#fff;">
                                certificate of Appreciation</h1>
                        </td>
                        <td width="355">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>

                <table width="1600" border="0" cellspacing="0" cellpadding="0"
                    style="padding-top:10px; text-align:center; line-height:0px;">
                    <tr>

                        <td width="255">&nbsp;</td>
                        <td width="900">

                            <h2 style="font-weight:500; font-size:55px;">This Certificate has been awarded </h2>
                        </td>
                        <td width="255">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="1600" border="0" cellspacing="0" cellpadding="0"
                    style="text-align:center; line-height:0px;">
                    <tr>
                        <td width="315">&nbsp;</td>
                        <td width="780">
                            <h6 style="font-size:40px; margin:0px; padding:10px 0px;">to</h6>
                            {{-- <h3 style="font-weight:500; font-size:80px;  color:#cc0000;">{{$participant->user->fullName($participant, 'user')}}</h3> --}}
                            <p style="font-size:80px;  color:#cc0000; font-family: 'Tangerine', cursive">{{$participant->user->fullName($participant, 'user')}}</p>
                        </td>
                        <td width="315">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="1600" border="0" cellspacing="0" cellpadding="0" style="text-align:center;">
                    <tr>
                        <td width="100">&nbsp;</td>
                        <td width="1210">
                            <h1>for his/her participation as
                                @if ($participant->registrant_type == 1 && $participant->is_invited == 0)
                                    an <strong>Attendee</strong>
                                @elseif ($participant->registrant_type == 2 && $participant->is_invited == 0)
                                    a <strong>Speaker</strong>
                                @elseif ($participant->registrant_type == 1 && $participant->is_invited == 1)
                                    a <strong>Guest Attendee</strong>
                                @elseif ($participant->registrant_type == 2 && $participant->is_invited == 1)
                                    a <strong>Guest Speaker</strong>
                                @endif
                                in the <br />
                                <small>24<sup>th</sup> Annual Conference of SAN, Society of Anesthesiologists of Nepal
                                </small>
                            </h1>
                        </td>
                        <td width="100">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="1600" border="0" cellspacing="0" cellpadding="0"
                    style="margin-top:110px; margin-bottom:80px;">
                    <tr>
                        @foreach ($signatures as $signature)
                            <td style="padding:0px 55px 100px 200px; text-align:center;">
                                <table width="320" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="260">
                                            <img src="{{asset('storage/certificates/signatures/'.$signature->signature)}}" alt="" style="width:70%;" height="50" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="260" style="border-bottom:#000 2px dotted;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="260"><span
                                                style="text-align:center; line-height:35px; padding:12px 0px; font-size:22px;"><b>{{$signature->name}}</b><br />
                                                ({{$signature->designation}})</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        @endforeach
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
