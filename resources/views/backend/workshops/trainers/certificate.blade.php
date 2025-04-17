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
                    filename: 'workshop_' + js.AutoCode() + '.pdf',
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

    <script type="text/javascript">
        $(document).ready(function() {
            var element = document.getElementById('container_content');

            var opt = {
                margin: 0,
                filename: '{{ $participant->name }}' + '.pdf', // Unique filename
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
                // window.location.href = 'https://conference.san.org.np/';
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
            <table width="1400" border="0" cellspacing="0" cellpadding="0"
                style="
              font-size: 18px;
              background: url('{{ asset('certificate/deafult/frame.png') }}') no-repeat center top;
              background-size: 100%;
              padding-bottom: 20px;
            ">
                <tr>
                    <td>
                        <table width="1670" border="0" cellspacing="0" cellpadding="0"
                            style="text-align: center; margin-top: 80px">
                            <tr>
                                <td width="210">&nbsp;</td>
                                <td width="150">
                                    <img src="{{ asset('certificate/deafult/san.jpg') }}"
                                        style="
                          height: 130px;
                          width: 133px;
                          margin-left: 30px;
                          border-radius: 100%;
                          background: #fff;
                          padding: 6px;
                          border: 2px red solid;
                        "
                                        alt="" />
                                </td>
                                <td width="470"
                                    style="
                        text-align: left;
                        font-size: 60px;
                        font-weight: bold;
                        color: red;
                      ">
                                    SANCON-ASPA 2025
                                </td>

                                <td width="350" style="text-align: left">
                                    <img src="{{ asset('frontend/assets/images/logo/ASPN.png') }}" alt=""
                                        style="
                          height: 140px;
                          border-radius: 100%;
                          padding: 6px;
                          border: 2px red solid;
                        " />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="padding-top: 0px; text-align: center; line-height: 0px">
                            <tr>
                                <td width="248">&nbsp;</td>
                                <td width="900">
                                    <h1
                                        style="
                          font-size: 35px;
                          width: auto;
                          height: 45px;
                          line-height: 50px;
                          padding: 10px 0px;
                          margin: 5px 0px;
                        ">
                                        "Scaling new heights in Pediatric Anesthesia and beyond"
                                    </h1>
                                </td>
                                <td width="255">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="padding-top: 0px; text-align: center; line-height: 0px">
                            <tr>
                                <td width="348">&nbsp;</td>
                                <td width="700">
                                    <h1
                                        style="
                          text-transform: uppercase;
                          font-size: 40px;
                          background-color: #26268e;
                          width: auto;
                          height: 60px;
                          line-height: 50px;
                          padding: 10px 0px;
                          margin: 20px 0px;
                          overflow: hidden;
                          color: #fff;
                        ">
                                        certificate of Appreciation
                                    </h1>
                                </td>
                                <td width="355">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="padding-top: 10px; text-align: center; line-height: 0px">
                            <tr>
                                <td width="300">&nbsp;</td>
                                <td width="1098">
                                    <h2 style="font-weight: 500; font-size: 60px">
                                        This Certificate has been awarded
                                    </h2>
                                </td>
                                <td width="300">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="1698" border="0" cellspacing="0" cellpadding="0"
                            style="text-align: center; line-height: 0px">
                            <tr>
                                <td width="315">&nbsp;</td>
                                <td width="780">
                                    <h6 style="font-size: 40px; margin: 0px; padding: 10px 0px">
                                        to
                                    </h6>
                                    <h3
                                        style="
                          font-weight: 500;
                          font-size: 80px;
                          margin-bottom: 15px;
                          color: red;
                        ">
                                        {{ $participant->name }}

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
                            style="text-align: center; font-size: 22px; line-height: 32px">
                            <tr>
                                <td width="160">&nbsp;</td>
                                <td width="1410">
                                    <h1 style="line-height: 60px; margin-bottom: 20px">
                                        for participating as a faculty in <br />
                                        <small><b
                                                style="
                              font-size: 60px;
                              line-height: 80px;
                              margin: 20px 0px;
                              color: red;
                            ">{{ $participant->workshop->title }}</b>
                                            <br />held on @if ($participant->workshop->start_date == $participant->workshop->end_date)
                                                {{ \Carbon\Carbon::parse($participant->workshop->start_date)->format('jS F, Y') }},
                                            @else
                                                {{ \Carbon\Carbon::parse($participant->workshop->start_date)->format('jS') }}
                                                -
                                                {{ \Carbon\Carbon::parse($participant->workshop->end_date)->format('jS F, Y') }},
                                            @endif Kathmandu,
                                            Nepal</small><br /><i
                                            style="font-size:20px; margin:0px; padding:0px">Accredited by NMC for CPD
                                            Points</i>
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
                            style="margin-top: 10px; margin-bottom: 70px">
                            <tbody>
                                <tr>
                                    @if ($participant->workshop->id == 7)
                                        <td style="padding: 0px 0px 0px 100px; text-align: center">
                                            <table border="0" width="340" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="260">
                                                            <img src="{{ asset('certificate/deafult/Josephine.png') }}"
                                                                alt="" style="height: 100px" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="260" style="border-bottom: #000 2px dotted">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="260">
                                                            <span
                                                                style="
                                text-align: center;
                                line-height: 35px;
                                padding: 12px 0px;
                                font-size: 22px;
                              "><b>
                                                                    Dr Josephine TAN </b><br />
                                                                (Workshop Coordinator)</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endif
                                    @if ($participant->workshop->id == 5 || $participant->workshop->id == 6)
                                        <td style="padding: 0px 0px 0px 100px; text-align: center">
                                            <table border="0" width="340" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="260">
                                                            <img src="{{ asset('certificate/deafult/ritu.png') }}"
                                                                alt="" style="height: 100px" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="260" style="border-bottom: #000 2px dotted">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="260">
                                                            <span
                                                                style="
                                    text-align: center;
                                    line-height: 35px;
                                    padding: 12px 0px;
                                    font-size: 22px;
                                  "><b>Assoc.
                                                                    Prof. Dr. Ritu Pradhan </b><br />
                                                                (Workshop Coordinator)</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endif
                                    @if ($participant->workshop->id == 4)
                                        <td style="padding: 0px 0px 0px 100px; text-align: center">
                                            <table border="0" width="340" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="260">
                                                            <img src="{{ asset('certificate/deafult/battu.png') }}"
                                                                alt="" style="height: 100px" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="260" style="border-bottom: #000 2px dotted">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="260">
                                                            <span
                                                                style="
                                    text-align: center;
                                    line-height: 35px;
                                    padding: 12px 0px;
                                    font-size: 22px;
                                  "><b>Assoc.
                                                                    Dr Battu K Shrestha </b><br />
                                                                (Workshop Coordinator)</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endif
                                    @if ($participant->workshop->id == 3)
                                        <td style="padding: 0px 0px 0px 100px; text-align: center">
                                            <table border="0" width="340" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="260">
                                                            <img src="{{ asset('certificate/deafult/nina.png') }}"
                                                                alt="" style="height: 100px" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="260" style="border-bottom: #000 2px dotted">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="260">
                                                            <span
                                                                style="
                                    text-align: center;
                                    line-height: 35px;
                                    padding: 12px 0px;
                                    font-size: 22px;
                                  "><b>Assoc.
                                                                    Dr. Ninadini Shrestha </b><br />
                                                                (Workshop Coordinator)</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endif
                                    @if ($participant->workshop->id == 2)
                                        <td style="padding: 0px 0px 0px 100px; text-align: center">
                                            <table border="0" width="340" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="260">
                                                            <img src="{{ asset('certificate/deafult/pradeep.png') }}"
                                                                alt="" style="height: 100px" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="260" style="border-bottom: #000 2px dotted">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="260">
                                                            <span
                                                                style="
                                    text-align: center;
                                    line-height: 35px;
                                    padding: 12px 0px;
                                    font-size: 22px;
                                  "><b>Assoc.
                                                                    Dr. Pradip Tiwari</b><br />
                                                                (Workshop Coordinator)</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endif
                                    @if ($participant->workshop->id == 1)
                                        <td style="padding: 0px 0px 0px 100px; text-align: center">
                                            <table border="0" width="340" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="260">
                                                            <img src="{{ asset('certificate/deafult/tara.png') }}"
                                                                alt="" style="height: 100px" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="260" style="border-bottom: #000 2px dotted">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="260">
                                                            <span
                                                                style="
                                    text-align: center;
                                    line-height: 35px;
                                    padding: 12px 0px;
                                    font-size: 22px;
                                  "><b>Assoc.
                                                                    Dr. Tara Gurung</b><br />
                                                                (Workshop Coordinator)</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endif

                                    <td style="padding: 0px 0px 0px 0px; text-align: center">
                                        <table border="0" width="250" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr></tr>
                                                <tr>
                                                    <td width="250">
                                                        <img src="{{ asset('certificate/deafult/basu.png') }}"
                                                            alt="" style="height: 100px" />
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td width="250" style="border-bottom: #000 2px dotted">
                                                        &nbsp;
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="250">
                                                        <span
                                                            style="
                                    text-align: center;
                                    line-height: 35px;
                                    padding: 12px 0px;
                                    font-size: 22px;
                                  "><b>Dr.
                                                                Bashu Dev Parajuli </b><br />(Organizing
                                                            Secretary)
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>

                                    <td style="padding: 0px 0px 0px 10px; text-align: center">
                                        <table width="300" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td width="260">
                                                        <img src="{{ asset('certificate/deafult/anil.png') }}"
                                                            alt="" style="height: 100px" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="260" style="border-bottom: #000 2px dotted">
                                                        &nbsp;
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="260">
                                                        <span
                                                            style="
                                    text-align: center;
                                    line-height: 35px;
                                    padding: 12px 0px;
                                    font-size: 22px;
                                  "><b>Prof.
                                                                Dr. Anil Shrestha </b><br />
                                                            (Scientific Chairperson)</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>

                                    <td style="padding: 0px 15px 0px 0px; text-align: center">
                                        <table width="310" border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td width="260">
                                                        <img src="{{ asset('certificate/deafult/amir.png') }}"
                                                            alt="" style="height: 100px" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="260" style="border-bottom: #000 2px dotted">
                                                        &nbsp;
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="260">
                                                        <span
                                                            style="
                                    text-align: center;
                                    line-height: 35px;
                                    padding: 12px 0px;
                                    font-size: 22px;
                                  "><b>Prof.
                                                                Dr. Amir Babu Shrestha </b><br />(Organizing
                                                            Chairperson)
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>
