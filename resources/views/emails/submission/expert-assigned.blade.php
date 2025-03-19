<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subbmision Assigned For Review</title>
</head>
<body>
    <div>
        <h3>Dear {{$data['namePrefix'] . ' ' . $data['name']}},</h3>
    </div>
    <br>
    <div>
        <p>We hope this message finds you well. We want to inform you that a presentation submission for a topic ({{$data['topic']}}) has been assigned to you to review and make decision for the request.</p>
        <p>Please check your dashboard for more details. Thank You.</p>
    </div>
    <br>
    <div>
        <p>Best Regards,</p>
        <p>Scientific committee</p>
        <p>SANCON-ASPA 2025</p>
    </div>
</body>
</html>
