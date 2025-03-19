<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paper Submission Submitted</title>
</head>
<body>
    <div>
        <h3>Dear {{$data['namePrefix'] . ' ' . $data['name']}},</h3>
    </div>
    <br>
    <div>
        <p>We hope this message finds you well. We want to inform you that we have received your presentation submission for a topic ({{$data['topic']}}) which is under review.</p>
        <p>We will inform you shortly. Thank You.</p>
    </div>
    <br>
    <div>
        <p>Best Regards,</p>
        <p>Scientific committee</p>
        <p>SANCON-ASPA 2025</p>
    </div>
</body>
</html>
