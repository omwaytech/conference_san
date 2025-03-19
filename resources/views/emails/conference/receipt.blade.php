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
        <h3>Dear {{ $data['namePrefix'] . ' ' . $data['name'] }},</h3>
    </div>
    <br>
    <div>
        <p>Sorry for the inconvenience! Due to some technical issues, our system sent you the blank receipt in the
            previous email.<br>
            Please find the correct receipt for your reference.<br>
            Thank you for your understanding!
        </p>
    </div>
    <br>

    <div>
        <p>Best Regards,</p>
        <p>SANCON-ASPA 2025</p>
        <p>Registration Committee</p>
    </div>
</body>

</html>
