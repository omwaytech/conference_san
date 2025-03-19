<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Workshop Correction</title>
</head>
<body>
    <div>
        <h3>Dear, {{$data['name']}}</h3>
    </div>
    <br>
    <div>
        <p>I hope this message finds you well. I want to express my gratitude for your interest in organizing workshop of title "{{$data['workshopTitle']}}".</p>
        <p>However, We have found few mistakes in your request and we would like you to make necessary correction. The reason for correction is {{$data['remarks']}}.
        For more details please check in your dashboard and submit the corrected data again. Thank You.</p>
    </div>
    <br>
    <div>
        <p>Best Regards,</p>
        <p>SANCON Conference</p>
    </div>
</body>
</html>
