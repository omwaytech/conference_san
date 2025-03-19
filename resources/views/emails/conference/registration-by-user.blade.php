<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conference Registration</title>
</head>
<body>
    <div>
        <h3>Dear {{$data['namePrefix'] . ' ' . $data['name']}},</h3>
    </div>
    <br>
    <div>
        <p>I hope this message finds you well. I want to express my gratitude for registering to the conference {{$data['conference_theme']}}.</p>
        <p>Your registration is pending. You will be informed once registration committee will accept registration. Thank You.</p>
    </div>
    <br>
    <div>
        <p>Best Regards,</p>
        <p>SANCON-ASPA 2025</p>
    </div>
</body>
</html>
