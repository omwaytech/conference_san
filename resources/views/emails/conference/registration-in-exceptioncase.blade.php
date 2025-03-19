<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conference Registration Confirmation</title>
</head>

<body>
    <div>
        <h3>Dear {{ $data['namePrefix'] . ' ' . $data['name'] }},</h3>
    </div>
    <br>
    <div>
        <p>I hope this message finds you well. We are pleased to inform you that your registration for the
            {{ $data['conference_theme'] }} conference has been confirmed.</p>
        <p>You will receive your pass with a QR code attached later.
            Please keep this email safe for your reference.</p>
        <p>Thank you.</p>
    </div>
    <br>
    <div>
        <p>Best Regards,</p>
        <p>SANCON-ASPA 2025</p>
    </div>
</body>

</html>
