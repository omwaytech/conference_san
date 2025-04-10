<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>SANCON-ASPA 2025 - Certificate</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <p>Dear {{ $data['name'] }}</p>
    <p>Greetings!</p>
    <p>
        We are delighted to share your Certificate of Participation on
        <strong>Pre/Post Congress Workshop, SANCON-ASPA 2025</strong>
    </p>

    <p>Please find below the link to your certificate:</p>


    <p>
        📎 <a href="{{ config('app.url') . '/dash/workshop-registration/generate-certificate/' . $data['token'] }}"
            target="_blank" style="color: #2a5db0; text-decoration: none;"><strong>Participant
                Certificate</strong></a><br>
    </p>

    <p>
        Please feel free to contact us if you have any questions or need further assistance.
    </p>

    <p>Thank you once again for being an important part of this memorable gathering.</p>

    <p>Best Regards</p>

    <p><strong>SANCON-ASPA 2025, Scientific Committee</strong></p>

</body>

</html>
