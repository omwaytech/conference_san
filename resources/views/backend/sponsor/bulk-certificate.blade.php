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
                    filename: 'nesog-certificate_' + js.AutoCode() + '.pdf',
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
    </script> --}}

</head>

<body>
    {{-- <div class="text-center" style="padding:20px;">
        <input type="button" id="rep" value="Download" class="btn btn-info btn_print">
    </div> --}}
    <div class="container_content" id="container_content">
        @foreach ($sponsors as $sponsor)
            <table width="1410" border="0" cellspacing="0" cellpadding="0"
                style="font-size:18px; background:url('{{ asset('certificate/deafult/Frame-NESOG.jpg') }}') no-repeat center top; background-size:99%; padding-bottom:30px; margin-top:40px">

                <tr>
                    <td>
                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="text-align:center; margin-top:80px; margin-bottom:10px;">
                            <tr>
                                <td width="350">&nbsp;</td>
                                <td width="440">
                                    <img src="{{ asset('certificate/deafult/NESOG.png') }}" width="180"
                                        alt="" />
                                </td>

                                <td width="340" style="text-align:left;">&nbsp;
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>

                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="padding-top:0px; text-align:center; line-height:0px;">
                            <tr>

                                <td width="348">&nbsp;</td>
                                <td width="700">
                                    <h1
                                        style="text-transform:uppercase; font-size:40px; background-color:#364c99; width:auto; height:60px; line-height:50px; padding:10px 0px; margin:5px 0px; overflow:hidden; color:#fff;">
                                        certificate of Appreciation</h1>
                                </td>
                                <td width="355">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>

                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="padding-top:10px; text-align:center; line-height:10px;">
                            <tr>

                                <td width="300">&nbsp;</td>
                                <td width="1098">

                                    <h2 style="font-weight:500; font-size:50px;">This Certificate has been awarded </h2>
                                </td>
                                <td width="300">&nbsp;</td>
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
                                        {{ $sponsor->name }}</h3>
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
                                    <h1 style="line-height:55px; margin-bottom:20px;">for your valuable contribution in
                                        the
                                        <br />
                                        <small><b style="font-size:48px; margin:10px 0px; color:#e5a356;">XVII
                                                International
                                                Conference of NESOG</b> <br />held on 28<sup>th</sup> - 29<sup>th</sup>
                                            March, 2025, Kathmandu, Nepal</small>
                                    </h1>
                                <td width="200"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="text-align:center; font-size:20px; line-height:30px;">
                            <tr>
                                <td width="0">&nbsp;</td>
                                <td width="1210">
                                    <h1
                                        style="line-height:40px; margin-top:0px; font-size:40px; color:#364c99; margin-bottom:40px;">
                                        NESOGCON 2025<br />
                                        <small style="font-size:26px;color:#000;">"Innovation and Equity in Women’s
                                            Health:
                                            Shaping the future together"</small>
                                    </h1>
                                <td width="200"></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="1600" border="0" cellspacing="0" cellpadding="0"
                            style="margin-top:10px; margin-bottom:80px;">
                            <tr>
                                <td style="padding:0px 15px 0px 100px; text-align:center;">
                                    <table width="280" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="260"><img src="{{ asset('certificate/deafult/saroja.png') }}"
                                                    alt="" style="height:75px;" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="260" style="border-bottom:#000 2px dotted;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="260"><span
                                                    style="text-align:center; line-height:35px; padding:12px 0px; font-size:22px;"><b>Dr.
                                                        Saroja Karki Pande</b><br />
                                                    (President NESOG)
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <td style="padding:0px 15px 0px 15px; text-align:center;">
                                    <table border="0" width="300" cellspacing="0" cellpadding="0">
                                        <tr>
                                        <tr>
                                            <td width="260"><img
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
                                <td width="260"><img src="{{ asset('certificate/deafult/signdiki.png') }}"
                                        alt="" style="height:75px;" /></td>
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
                                <td width="260"><img src="{{ asset('certificate/deafult/swasti.png') }}"
                                        alt="" style="height:75px;" /></td>
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
                                <td width="260"><img src="{{ asset('certificate/deafult/neeva.png') }}"
                                        alt="" style="height:75px;" /></td>
                            </tr>
                            <tr>
                                <td width="260" style="border-bottom:#000 2px dotted;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="260"><span
                                        style="text-align:center; line-height:35px; padding:12px 0px; font-size:22px;"><b>Dr.
                                            Neebha Ojha</b><br />
                                        (Scientific Chairperson)</span></td>
                            </tr>
                        </table>
                    </td>


                </tr>
            </table>
            </td>
            </tr>

            </table>
        @endforeach
    </div>
</body>

</html>
