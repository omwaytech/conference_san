<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Workshop Registration Received</title>
</head>
<body>
    <div>
        <h3>Dear {{$data['receiverName']}},</h3>
    </div>
    <br>
    <div>
        <p>We hope this message finds you well. We want to inform you that a registration for {{$data['workshopTitle']}} has been received.</p>
        <p>Please check in dashboard for more details. Thank You.</p>
    </div>
    <br>
    <div>
        <h3>Applier Name: {{$data['senderName']}}</h3>
    </div>
    <br>
    <div>
        <p>Best Regards,</p>
        <p>SANCON-ASPA 2025</p>
    </div>
</body>
</html>
