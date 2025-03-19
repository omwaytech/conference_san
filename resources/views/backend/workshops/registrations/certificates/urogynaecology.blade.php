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


<!DOCTYPE html>
<html>

<head>

    <title> Certificate </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="This ">

    <meta name="author" content="Code With Mark">
    <meta name="authorUrl" content="http://codewithmark.com">
    <meta charset="utf-8">

    <!--[CSS/JS Files - Start]-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tangerine:wght@400;700&display=swap" rel="stylesheet">


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

        /*.invoice-box {*/
        /*    max-width: 100%;*/
        /*    margin: auto;*/
        /*    padding: 30px;*/
        /*    border: 1px solid #eee;*/
        /*    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);*/
        /*    font-size: 16px;*/
        /*    line-height: 24px;*/
        /*    font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;*/
        /*    color: #555;*/
        /*}*/

        /*.invoice-box table {*/
        /*    width: 100%;*/
        /*    line-height: inherit;*/
        /*    text-align: left;*/
        /*}*/

        /*.invoice-box table td {*/
        /*    padding: 5px;*/
        /*    vertical-align: top;*/
        /*}*/

        /*.invoice-box table tr td:nth-child(2) {*/
        /*    text-align: right;*/
        /*}*/

        /*.invoice-box table tr.top table td {*/
        /*    padding-bottom: 20px;*/
        /*}*/

        /*.invoice-box table tr.top table td.title {*/
        /*    font-size: 45px;*/
        /*    line-height: 45px;*/
        /*    color: #333;*/
        /*}*/

        /*.invoice-box table tr.information table td {*/
        /*    padding-bottom: 40px;*/
        /*}*/

        /*.invoice-box table tr.heading td {*/
        /*    background: #eee;*/
        /*    border-bottom: 1px solid #ddd;*/
        /*    font-weight: bold;*/
        /*}*/

        /*.invoice-box table tr.details td {*/
        /*    padding-bottom: 20px;*/
        /*}*/

        /*.invoice-box table tr.item td {*/
        /*    border-bottom: 1px solid #eee;*/
        /*}*/

        /*.invoice-box table tr.item.last td {*/
        /*    border-bottom: none;*/
        /*}*/

        /*.invoice-box table tr.total td:nth-child(2) {*/
        /*    border-top: 2px solid #eee;*/
        /*    font-weight: bold;*/
        /*}*/

        /*@media only screen and (max-width: 600px) {*/
        /*    .invoice-box table tr.top table td {*/
        /*        width: 100%;*/
        /*        display: block;*/
        /*        text-align: center;*/
        /*    }*/

        /*    .invoice-box table tr.information table td {*/
        /*        width: 100%;*/
        /*        display: block;*/
        /*        text-align: center;*/
        /*    }*/
        /*}*/

        /*!** RTL **!*/
        /*.invoice-box.rtl {*/
        /*    direction: rtl;*/
        /*    font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;*/
        /*}*/

        /*.invoice-box.rtl table {*/
        /*    text-align: right;*/
        /*}*/

        /*.invoice-box.rtl table tr td:nth-child(2) {*/
        /*    text-align: left;*/
        /*}*/
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>



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
    </script>



</head>

<body>

    <div class="text-center" style="padding:20px;">
        <input type="button" id="rep" value="Download" class="btn btn-info btn_print">
    </div>

    <div class="container_content" id="container_content">
        <div class="invoice-box">
            <table width="1410" border="0" cellspacing="0" cellpadding="0"
                style="font-size:18px; background:url('/certificate/urogynaecology/background.png') no-repeat center top; background-size:100%; padding-bottom:50px;">

                <tr>
                    <td>
                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="text-align:center; margin-top:70px;">
                            <tr>
                                <td width="380">&nbsp;</td>
                                <td width="180">
                                    <img src="{{ asset('certificate/NESOG.png') }}" width="180"
                                        alt="" />
                                </td>
                                <td width="500"><img src="{{ asset('certificate/urogynaecology/golden.png') }}" width="120"
                                        style="float:left;" alt="" />
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

                                <td width="148">&nbsp;</td>
                                <td width="1200">
                                    <h1
                                        style="line-height:50px; padding-bottom:0px; margin-top:0px; margin-bottom:0px; font-size:42px;">
                                        17<sup>th</sup> National Conference <br />
                                        <small>Of</small><br /> <span style="color:#254d9e;">Nepal Society of Obstetricians and
                                            Gynaecologists (NESOG)</span><br />
                                        <i style="font-weight:400; font-size:38px; padding:10px 0px;">"Advances in Women's
                                            Health Care Now & Beyond"</i>
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
                                        @if (@$participant->user->userDetail->member_type_id == 6)
                                            @if ($participant->user->userDetail->gender == 'M')
                                                Mr. {{$participant->user->name}}
                                            @else
                                                M/S {{$participant->user->name}}
                                            @endif
                                        @else
                                            @php
                                                $explodeName = explode(' ', $participant->user->name);
                                            @endphp
                                            @if ($explodeName[0] == 'Dr.')
                                                {{$participant->user->name}}
                                            @else
                                                Dr. {{$participant->user->name}}
                                            @endif
                                        @endif
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
                                    <h1 style="line-height:60px; margin-bottom:0px;">for his/her participation in the <br />
                                        <small><b style="font-size:60px; margin:10px 0px; color:#e5a356;">Urogynecology Workshop
                                            </b> <br />3<sup>rd
                                            </sup> & 4<sup>th</sup>April, 2024, Kathmandu, Nepal</small>
                                    </h1>

                                <td width="200"></td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td>
                        <table width="1600" border="0" cellspacing="0" cellpadding="0"
                            style="margin-top:60px; margin-bottom:100px;">
                            <tr>
                                <td style="padding:0px 25px 0px 120px; text-align:center;">
                                    <table width="310" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="260" height="100"><img
                                                    src="{{ asset('certificate/saroja.png') }}" alt=""
                                                    style="height:85px;" /></td>
                                        </tr>
                                        <tr>
                                            <td width="260" style="border-bottom:#000 2px dotted;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="260"><span
                                                    style="text-align:center; line-height:35px; padding:12px 0px; font-size:26px;"><b>Dr.
                                                        Saroja Karki Pande</b><br />
                                                    (President NESOG)</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="padding:0px 25px 0px 25px; text-align:center;">

                                    <table width="310" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="260"><img
                                                    src="{{ asset('certificate/geeta.png') }}"
                                                    alt="" style="height:100px;" /></td>
                                        </tr>
                                        <tr>
                                            <td width="260" style="border-bottom:#000 2px dotted;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="260"><span
                                                    style="text-align:center; line-height:35px; padding:12px 0px; font-size:26px;"><b>Dr.
                                                        Geeta Gurung</b><br />
                                                    (Organising Chairperson)</span>
                                            </td>
                                        </tr>
                                    </table>

                                </td>


                                <td style="padding:0px 25px 0px 25px; text-align:center;">
                                    <table border="0" width="300" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="260"><img
                                                    src="{{ asset('certificate/neebha.png') }}"
                                                    alt="" style="height:100px;" /></td>
                                        </tr>
                                        <tr>
                                            <td width="260" style="border-bottom:#000 2px dotted;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="260"><span
                                                    style="text-align:center; line-height:35px; padding:12px 0px; font-size:26px;"><b>Dr
                                                        Neebha Ojha
                                                    </b><br />
                                                    (Scientific Chairperson)</span></td>
                                        </tr>
                                    </table>
                                </td>


                                <td style="padding:0px 150px 0px 25px; text-align:center;">
                                    <table border="0" width="320" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="260" height="100"><img
                                                    src="{{ asset('certificate/urogynaecology/sandesh.png') }}"
                                                    alt="" style="height:100px;" /></td>
                                        </tr>
                                        <tr>
                                            <td width="260" style="border-bottom:#000 2px dotted;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="260"><span
                                                    style="text-align:center; line-height:35px; padding:12px 0px; font-size:26px;"><b>Dr. Sandesh poudel
                                                    </b><br />
                                                    (Workshop Chairperson)</span></td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>
