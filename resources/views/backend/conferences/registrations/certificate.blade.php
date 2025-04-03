{{-- <!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Certificate | SANCON 2024</title>
  
    <link href="{{asset('plugin-links/font/stylesheet.css')}}" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Josefin Sans"';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
        
            src: url('{{ storage_path('fonts/Josefin_Sans/static/JosefinSans-Regular.ttf') }}') format('truetype');
       
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

</html> --}}


{{-- <!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Certificate | SANCON 2024</title>
   
    <link href="{{asset('plugin-links/font/stylesheet.css')}}" rel="stylesheet">
    <style> 
        @font-face {
            font-family: 'Josefin Sans"';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url('{{ storage_path('fonts/Josefin_Sans/static/JosefinSans-Regular.ttf') }}') format('truetype');
            
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

</html> --}}

<?php
//--->get app url > start

if ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1)) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {
    $ssl = 'https';
} else {
    $ssl = 'http';
}

$app_url =
    $ssl .
    '://' .
    $_SERVER['HTTP_HOST'] .
    //. $_SERVER["SERVER_NAME"]
    (dirname($_SERVER['SCRIPT_NAME']) == DIRECTORY_SEPARATOR ? '' : '/') .
    trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

//--->get app url > end

header('Access-Control-Allow-Origin: *');

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tangerine:wght@400;700&display=swap" rel="stylesheet">
    <!--[CSS/JS Files - Start]-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>


    <script src="{{ asset('certificate/af.min.js') }}"></script>
    <style>
        body {
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }

        h3 {
            font-family: "Tangerine", cursive;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>


    {{-- <script type="text/javascript">
        $(document).ready(function() {
            var element = document.getElementById('container_content');

            var opt = {
                margin: 0,
                filename: 'san-certificate_' + new Date().getTime() + '.pdf', // Unique filename
                image: {
                    type: 'jpeg',
                    quality: 1
                },
                html2canvas: {
                    scale: 2,
                    width: 1700
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'landscape'
                }
            };

            // Automatically generate and download the PDF when the page loads
            html2pdf().set(opt).from(element).save().then(() => {
                // Optionally return back after download
                window.history.back(); // Takes the user back to the previous page
            });
        });
    </script> --}}
    <script type="text/javascript">
        $(document).ready(function($) {

            $(document).on('click', '.btn_print', function(event) {
                event.preventDefault();

                //credit : https://ekoopmans.github.io/html2pdf.js

                var element = document.getElementById('container_content');

                //easy
                //html2pdf().from(element).save();

                //custom file name
                //html2pdf().set({filename: 'code_with_mark_'+js.AutoCode()+'.pdf'}).from(element).save();


                //more custom settings
                var opt = {
                    margin: 0,
                    filename: 'san_' + js.AutoCode() + '.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 5
                    },
                    html2canvas: {
                        scale: 3,
                        width: 1700
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'a4',
                        orientation: 'l'
                    },

                };

                // New Promise-based usage:
                html2pdf().set(opt).from(element).save();


            });



        });
    </script>


</head>

<body>
    <div class="text-center" style="padding:20px;">
        <input type="button" id="rep" value="Download" class="btn btn-info btn_print">
    </div>
    <div class="container_content" id="container_content">
        <div class="invoice-box">

            <table width="1410" border="0" cellspacing="0" cellpadding="0"
                style="font-size:18px; background:url('{{ asset('certificate/deafult/Frame-NESOG.jpg') }}') no-repeat center top; background-size:99%; padding-bottom:30px;">

                <tr>
                    <td>
                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="text-align:center; margin-top:70px;">
                            <tr>
                                <td width="480">&nbsp;</td>
                                <td width="140">
                                    <img src="{{ asset('certificate/deafult/NESOG.png') }}" width="180"
                                        style="float:left;" alt="" />
                                </td>
                                <td width="400">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>

                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="padding-top:0px; text-align:center; line-height:0px;">
                            <tr>

                                <td width="148">&nbsp;</td>
                                <td width="1200">
                                    <h1
                                        style="line-height:50px; padding-bottom:0px; margin-top:0px; margin-bottom:0px; font-size:42px;">
                                        17<sup>th</sup> International Conference <br />
                                        <small>Of</small><br /> <span style="color:#254d9e;">Nepal Society of
                                            Obstetricians
                                            and
                                            Gynaecologists (NESOG)</span><br />
                                        <i style="font-weight:400; font-size:38px; padding:10px 0px;">"Innovation and
                                            Equity
                                            in
                                            Women’s Health: Shaping the future together"</i>
                                    </h1>
                                </td>
                                <td width="155">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>

                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="padding-top:0px; text-align:center; line-height:0px;">
                            <tr>

                                <td width="100">&nbsp;</td>
                                <td width="1498">

                                    <h2 style="font-weight:500; font-size:58px;">This Certificate has been awarded </h2>
                                </td>
                                <td width="100">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="text-align:center; line-height:0px;">
                            <tr>
                                <td width="315">&nbsp;</td>
                                <td width="780">
                                    <h6 style="font-size:40px; margin:0px; padding:10px 0px;">to</h6>
                                    <h3 style="font-weight:500; font-size:80px; margin-bottom:15px; color:#e5a356;">
                                        {{ $participant->user->namePrefix->prefix ?? null }}
                                        {{ $participant->user->fullname($participant, 'user') }}
                                    </h3>
                                </td>
                                <td width="315">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="text-align:center; font-size:22px; line-height:32px;">
                            <tr>
                                <td width="260">&nbsp;</td>
                                <td width="1210">
                                    <h1 style="line-height:55px; margin-bottom:20px;">
                                        for Participating as a
                                        <strong>{{ $participant->registrant_type == 2 ? 'Speaker' : 'Attendee' }}</strong>
                                        in the
                                        <br />
                                        <small><b style="font-size:55px; margin:10px 0px; color:#e5a356;">XVII
                                                International
                                                Conference of NESOG</b> <br />held on 28<sup>th</sup> - 29<sup>th</sup>
                                            March,
                                            2025, Kathmandu, Nepal</small>
                                    </h1>
                                <td width="200"></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="1600" border="0" cellspacing="0" cellpadding="0"
                            style="margin-top:10px; margin-bottom:120px;">
                            <tr>
                                <td style="padding:0px 15px 0px 100px; text-align:center;">
                                    <table width="280" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="260" style="padding-left: 60px;"><img
                                                    src="{{ asset('certificate/deafult/saroja.png') }}" alt=""
                                                    style="height:75px;" /></td>
                                        </tr>
                                        <tr>
                                            <td width="260" style="border-bottom:#000 2px dotted;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="260" style="padding-left: 15px;"><span
                                                    style="text-align:center; line-height:35px; padding:12px 0px; font-size:22px;"><b>Dr.
                                                        Saroja Karki Pande</b><br />
                                                    (President NESOG)</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <td style="padding:0px 15px 0px 15px; text-align:center;">
                                    <table border="0" width="300" cellspacing="0" cellpadding="0">
                                        <tr>
                                        <tr>
                                            <td width="260" style="padding-left: 60px;"><img
                                                    src="{{ asset('certificate/deafult/sapana.png') }}" alt=""
                                                    style="height:75px;" /></td>
                                        </tr>
                            </tr>
                            <tr>
                                <td width="260" style="border-bottom:#000 2px dotted;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="260"><span
                                        style="text-align:center; line-height:35px; padding:12px 0px; font-size:22px;"><b>Dr.
                                            Sapana Amatya Vaidya</b><br />
                                        (General Secretary NESOG)</span></td>
                            </tr>
                        </table>
                    </td>

                    <td style="padding:0px 15px 0px 15px; text-align:center;">

                        <table width="280" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="260" style="padding-left: 60px;"><img
                                        src="{{ asset('certificate/deafult/signdiki.png') }}" alt=""
                                        style="height:75px;" /></td>
                            </tr>
                            <tr>
                                <td width="260" style="border-bottom:#000 2px dotted;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="260"><span
                                        style="text-align:center; line-height:35px; padding:12px 0px; font-size:22px;"><b>Prof.
                                            Kesang Diki Bista</b><br />
                                        (Organizing Chairperson)</span>
                                </td>
                            </tr>
                        </table>

                    </td>


                    <td style="padding:0px 15px 0px 15px; text-align:center;">
                        <table border="0" width="240" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="260" style="padding-left: 40px;"><img
                                        src="{{ asset('certificate/deafult/swasti.png') }}" alt=""
                                        style="height:75px;" /></td>
                            </tr>
                            <tr>
                                <td width="260" style="border-bottom:#000 2px dotted;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="260"><span
                                        style="text-align:center; line-height:35px; padding:12px 0px; font-size:22px;"><b>Dr.
                                            Swasti Sharma</b><br />
                                        (Organizing Secretary)</span></td>
                            </tr>
                        </table>
                    </td>

                    <td style="padding:0px 15px 0px 15px; text-align:center;">
                        <table border="0" width="250" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="260" style="padding-left: 40px;"><img
                                        src="{{ asset('certificate/deafult/neeva.png') }}" alt=""
                                        style="height:75px;" /></td>
                            </tr>
                            <tr>
                                <td width="260" style="border-bottom:#000 2px dotted;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="260" style="padding-left: 15px;"><span
                                        style="text-align:center; line-height:35px; padding:12px 0px; font-size:22px;"><b>Dr.
                                            Neebha Ojha</b><br />
                                        (Scientific Chairperson)</span></td>
                            </tr>
                        </table>
                    </td>


                </tr>
            </table>
        </div>
    </div>
</body>

</html>
