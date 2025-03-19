<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Conference Registeration Correction</title>
</head>
<body>
    <div>
        <h3>Dear {{$data['namePrefix'] . ' ' . $data['name']}},</h3>
    </div>
    <br>
    <div>
        <p>I hope this message finds you well. I want to express my gratitude for your interest in attending conference ({{$data['conference_theme']}}) and for taking the time to submit your application.</p>
        <p>We want to inform you that there is an error in your conference registration and want you to make necessary change by editing it. Following is the reason for correction.</p>
        <p>Reason: {{$data['remarks']}}</p>
        <p>Thank you.</p>
    </div>
    <br>
    <div>
        <p>Best Regards,</p>
        <p>SANCON-ASPA 2025</p>
    </div>
</body>
</html>
