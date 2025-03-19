<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conference Registeration Rejected</title>
</head>
<body>
    <div>
        <h3>Dear {{$data['namePrefix'] . ' ' . $data['name']}},</h3>
    </div>
    <br>
    <div>
        <p>I hope this message finds you well. I want to express my gratitude for your interest in attending conference ({{$data['conference_theme']}}) and for taking the time to submit your application.</p>
        <p>We feel regret to inform you that, your application has been cancelled as "{{$data['remarks']}}". Hope such mistakes won't be repeat in future. Thank You.</p>
    </div>
    <br>
    <div>
        <p>Best Regards,</p>
        <p>SANCON-ASPA 2025</p>
    </div>
</body>
</html>
