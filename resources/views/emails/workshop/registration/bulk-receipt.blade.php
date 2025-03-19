<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Workshop Registration Confirmation</title>
</head>

<body>
    <div>
        <h3>Dear {{ $data['name'] }},</h3>
    </div>
    <br>
    <div>
        <p>We hope this message finds you well. We are pleased to confirm that your registration for the workshop
            <strong>{{ $data['workshopTitle'] }}</strong> has been successfully received and processed.
        </p>
        <p>This email serves as a receipt for your registration.</p>
        <p>Thank you for your participation, and we look forward to seeing you at the event.</p>
    </div>
    <br>
    <div>
        <p>Best Regards,</p>
        <p>SANCON-ASPA 2025</p>
    </div>
</body>

</html>
