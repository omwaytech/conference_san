<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SANCON 2025 Pass</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
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

        .pass-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }

        .pass {
            width: 550px;
            height: auto;
            margin: 20px;
            font-size: 18px;
            background: #99e5ff url('{{ asset('default-images/new-pass-bg.png') }}') no-repeat center top;
            background-size: 100%;
            padding: 50px 0 20px;
            overflow: hidden;
        }

        .pass img {
            display: block;
            margin: 0 auto;
        }

        .header,
        .footer {
            text-align: center;
            font-weight: bold;
        }

        .footer {
            background-color: #cc0000;
            padding: 15px 30px;
            height: 120px;
            margin-top: 10px;
        }

        .qr-code {
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>

<body>
    <h1 style="text-align:center;">SANCON 2025 Passes</h1>
    <div id="pass-container" class="pass-container"> 
        @foreach ($participants as $participant)
            <div class="pass" id="pass-{{ $loop->index }}" data-email="{{ $participant->user->email }}">
                <div style="text-align:center;">
                    <img src="{{ asset('frontend') }}/assets/images/logo/SAN.png" width="120" alt="logo" />
                </div>
                <div class="header">
                    <h1 style="color:#fff;font-size:36px; margin-top: 110px;">SANCON 2025</h1>
                    <h3>"Advances in Anesthesia"</h3>
                    <p>Hyatt Regency Kathmandu<br>4 - 5 April 2025</p>
                    <div style="background-color:rgba(38,38, 142); color:#fff; padding:5px;">
                        <h1 style="font-size:40px;">{{ $participant->user->fullName($participant, 'user') }}</h1>
                    </div>
                </div>
                <div class="qr-code">
                    {!! QrCode::size(120)->generate(config('app.url') . '/participant/profile/' . $participant->token) !!}
                </div>
                <div class="footer">
                    <h1
                        style="color:#fff; text-transform:capitalize;  font-size:40px; padding:15px 30px; margin:0px; float:left; weight:bold;">
                        Faculty</h1>
                    <p
                        style="float:right; font-size:30px; font-weight:bold; padding:10px 40px;	border-left:3px #fff solid; color:#fff; margin:10px; text-align:center;">
                        {{ $participant->userDetail->country->country_name }}</p>
                </div>
            </div>
            {{-- <button onclick="sendPass({{ $loop->index }}, '{{ $participant->user->email }}')">Send Pass via
                Email</button> --}}
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
